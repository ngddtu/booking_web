<?php

namespace App\Http\Controllers\Saler;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\BookingService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BookingServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BookingService $bookingService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookingService $bookingService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $bookingId)
    {   
        $servicesData = json_decode($request->services, true);

        if (!is_array($servicesData)) {
            return redirect()->back()->with('error', 'Dữ liệu không hợp lệ');
        }

        // 2. Sử dụng Transaction để đảm bảo dữ liệu an toàn
        DB::beginTransaction();
        try {
            // Bước A: Xóa toàn bộ dịch vụ cũ của Booking này
            // (Để tránh trùng lặp hoặc sót các món đã bị xóa khỏi giỏ hàng)
            BookingService::where('booking_id', $bookingId)->delete();

            // Bước B: Thêm lại danh sách mới
            foreach ($servicesData as $item) {
                // Kiểm tra xem item có đủ dữ liệu không để tránh lỗi
                if(isset($item['service_id']) && isset($item['quantity']) && $item['quantity'] > 0) {
                    BookingService::create([
                        'booking_id' => $bookingId,
                        'service_id' => $item['service_id'], // Hoặc $item['service']['id'] tùy cấu trúc JSON
                        'quantity'   => $item['quantity'],
                        // Nếu database có cột price, hãy thêm vào đây
                        // 'price'   => $item['service']['price'] ?? 0 
                    ]);
                }
            }

            DB::commit(); // Lưu thay đổi
            return redirect()->back()->with('success', 'Cập nhật dịch vụ thành công!');

        } catch (\Exception $e) {
            DB::rollBack(); // Hoàn tác nếu lỗi
            // Log lỗi ra để debug: \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookingService $bookingService)
    {
        //
    }
}
