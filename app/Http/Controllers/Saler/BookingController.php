<?php

namespace App\Http\Controllers\Saler;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }


    public function index(Request $request)
    {
        $bookings = $this->booking->getListBookings();
        // dd($bookings);
        return view('saler.manage-booking-list', compact( 'bookings'));
    }

    public function checkIn(Booking $booking)
    {
        // if ($booking->status !== 'pending') {
        //     return redirect()->back()->with('error', 'Booking status must be pending to check in.');
        // }

        // DB::transaction(function () use ($booking) {
        //     $booking->update([
        //         'status' => 'confirmed', // Confirmed implies Checked In/Start of stay
        //         'check_in' => Carbon::now(), // Update actual check-in time
        //     ]);

        //     $booking->room->update(['status' => 'occupied']);
        // });

        // return redirect()->back()->with('success', 'Check-in successful.');
    }

    public function checkOut(Request $request, Booking $booking)
    {
        if ($booking->status === 'completed' || $booking->status === 'canceled') {
            return redirect()->back()->with('error', 'Booking already completed or canceled.');
        }

        try {
            DB::transaction(function () use ($booking, $request) {
                $now = Carbon::now();

                // 1. Calculate Room Price
                $checkIn = Carbon::parse($booking->check_in);
                $durationDays = $checkIn->diffInDays($now);
                if ($durationDays < 1) $durationDays = 1;

                $booking->load(['room.roomType', 'booking_service.service']);

                // Check if relationship exists, handle potential null
                $roomType = $booking->room->roomType;
                // dd($roomType);
                if (!$roomType) {
                    throw new \Exception("Room type data missing for calculation.");
                }

                $rentType = $booking->rent_type ?? 'daily';
                $roomPrice = 0;

                switch ($rentType) {
                    case 'hourly':
                        $durationHours = $checkIn->floatDiffInHours($now);
                        if ($durationHours < 1) $durationHours = 1;
                        $roomPrice = $roomType->initial_hour_rate * ceil($durationHours);
                        break;
                    case 'overnight':
                        $roomPrice = $roomType->overnight_rate;
                        break;
                    case 'daily':
                    default:
                        $durationDays = $checkIn->floatDiffInDays($now);
                        if ($durationDays < 1) $durationDays = 1;
                        $roomPrice = $roomType->daily_rate * ceil($durationDays);
                        break;
                }

                // 2. Calculate Services Price
                $servicePrice = 0;
                foreach ($booking->booking_service as $bs) {
                    $servicePrice += $bs->quantity * $bs->service->price;
                }

                $totalPrice = $roomPrice + $servicePrice;

                // 3. Update Booking
                $booking->update([
                    'status' => 'completed',
                    'check_out' => $now,
                    'total_price' => $totalPrice
                ]);

                // 4. Update Room Status -> Cleaning
                $booking->room->update(['status' => 'cleaning']);

                // 5. Create Payment Record
                $paymentMethod = match ($request->input('payment_id')) {
                    '2' => 'transfer',
                    '3' => 'card',
                    default => 'cash',
                };

                $payment = Payment::create([
                    'user_id' => auth()->id(),
                    'booking_id' => $booking->id,
                    'amount' => $totalPrice,
                    'method' => $paymentMethod,
                    'status' => 'success',
                ]);

                // 6. Create Invoice
                Invoice::create([
                    'user_id' => auth()->id(),
                    'booking_id' => $booking->id,
                    'payment_id' => $payment->id,
                    'total' => $totalPrice,
                    'issued_at' => $now,
                ]);
            });

            return redirect()->back()->with('success', 'Check-out successful. Invoice generated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Check-out failed: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        // dd($request->note);
        $request->validate([
            'room_id'     => 'required|exists:rooms,id',
            'check_in'    => 'required|date',
            'name'        => 'required|string',
            'phone'       => 'nullable|string',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        DB::beginTransaction();

        try {

            // ----------------------------------------------------
            // 1. Xử lý khách hàng
            // ----------------------------------------------------
            if ($request->customer_id) {
                // Khách cũ
                $customer = Customer::find($request->customer_id);
            } else {
                // Khách mới
                $customer = Customer::create([
                    'name'        => $request->name,
                    'phone'       => $request->phone,
                    'gender'      => $request->gender,
                    'citizen_id'  => $request->citizen_id,
                    'nationality' => $request->nationality,
                    'address'     => $request->address,
                ]);
            }

            // ----------------------------------------------------
            // 2. Tạo booking
            // ----------------------------------------------------
            $booking = Booking::create([
                'room_id'     => $request->room_id,
                'customer_id' => $customer->id,
                'rent_type'   => $request->rent_type,
                'check_in'    => $request->check_in,
                'check_out'   => $request->check_out ?: null,
                'total_price' => str_replace('.', '', $request->total_price),
                'deposit'     => $request->diposit ?? 0,
                'deposit_method' => $request->deposit_method,
                'note'        => $request->note,
                'status'      => 'pending',
            ]);

            // ----------------------------------------------------
            // 3. Nếu check-in = NOW → chuyển phòng sang đang ở
            // ----------------------------------------------------
            $room = Room::findOrFail($request->room_id);

            if (now()->format('Y-m-d H:i') === Carbon::parse($request->check_in)->format('Y-m-d H:i')) {
                $room->update(['status' => 'occupied']);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Tạo booking thành công!');
        } catch (\Exception $e) {

            DB::rollBack();
            Log::error($e);

            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }


    /**
     * Search customer by phone or citizen_id
     */
    public function searchCustomer(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return response()->json([]);
        }

        // DB không có cột citizen_id -> chỉ tìm theo phone hoặc name
        $customers = \App\Models\Customer::where('phone', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return response()->json($customers);
    }

    // Maintenance Methods
    public function setMaintenance(Room $room)
    {
        if ($room->status !== 'available') {
            return redirect()->back()->with('error', 'Chỉ phòng trống mới có thể bảo trì.');
        }
        $room->update(['status' => 'maintenance']);
        return redirect()->back()->with('success', 'Đã chuyển phòng sang trạng thái bảo trì.');
    }

    public function finishMaintenance(Room $room)
    {
        if ($room->status !== 'maintenance') {
            return redirect()->back()->with('error', 'Phòng không ở trạng thái bảo trì.');
        }
        // Switch to available
        $room->update(['status' => 'available']);
        return redirect()->back()->with('success', 'Hoàn tất bảo trì. Phòng đã sẵn sàng.');
    }



    public function finishCleaning(Room $room)
    {
        if ($room->status !== 'cleaning') {
            return redirect()->back()->with('error', 'Phòng không ở trạng thái dọn dẹp.');
        }
        // dd($room);
        // Switch to available
        if ($room->roomType->status == 'disable') {
            $room->update(['status' => 'disable']);
        } else {
            $room->update(['status' => 'available']);
        }

        return redirect()->back()->with('success', 'Hoàn tất dọn dẹp. Phòng đã sẵn sàng.');
    }

    public function update(Request $request, Booking $booking)
    {
        // dd($booking);
        $booking->update(['status' => 'confirmed']);
        $room = Room::find($booking->room_id);
        $room->update(['status' => 'occupied']);
        return redirect()->back()->with('success', 'Check in thành công!');
    }

    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();

            return back()->with('success', 'Hủy booking thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể hủy booking!');
        }
    }
}
