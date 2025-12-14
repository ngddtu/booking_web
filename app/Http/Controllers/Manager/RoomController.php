<?php

namespace App\Http\Controllers\Manager;

use App\Models\Room;
use App\Models\Booking;
use App\Models\TypeRoom;
use App\Models\RoomService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $room;
    protected $service;
    protected $roomType;
    public function __construct(Room $room, TypeRoom $roomType, RoomService $service)
    {
        $this->room = $room;
        $this->service = $service;
        $this->roomType = $roomType;
    }
    public function index(Request $request)
    {
        // if(isset($request)){
        //     dd($request->all());
        // }
        $roomTypes = $this->roomType->getTypeRoom();
        // dd($roomTypes);
        $rooms  = $this->room->filterRooms($request->all());
        // dd($rooms);
        // $status = $this->room->getStatusLabelAttribute($rooms->status);
        // dd($status);
        $title = 'Tổng quan hệ thống';
        return view('admins.manage-room', compact('title', 'rooms', 'roomTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $data = $request->validate([
                'room_number' => 'required|string|max:100|unique:rooms,room_number',
                'status' => 'required',
                'room_type_id' => 'required'

            ]);
            $this->room->store_new_room($data);
            return redirect()->back()->with('success', 'Thêm phòng thành công!');
        } catch (ValidationException $e) {
            $message = $e->errors();
            return redirect()->back()
                ->with('error', 'Thêm phòng không thành công!')
                ->withErrors($message) // truyền lỗi từng field
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        // dd($request->all());
        try {
            $data = $request->validate([
                'room_number' => 'required|string|max:100|unique:rooms,room_number,' . $room->id,
                'status' => 'required',
                'type_room_id' => 'required'
            ]);


            $this->room->update_room($room->id, $data);
            return redirect()->back()->with('success', 'Sửa phòng thành công!');
        } catch (ValidationException $e) {
            $message = $e->errors();
            return redirect()->back()
                ->with('error', 'Sửa phòng không thành công!')
                ->withErrors($message) // truyền lỗi từng field
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }



    public function manage_reserve(Request $request)
    {
        $rooms = $this->room->listWithActiveBooking($request->all());
        $services = $this->service->getServiceAttribute();
        // dd($services);
        // dd($rooms);
        // dd($rooms[3]->activeBooking->booking_service->map(fn($bs)=> $bs->service->name));
        return view('saler.manage-booking', compact('rooms', 'services'));
    }


    public function showCheckinModal($roomId)
    {
        $room = Room::with('roomType')->findOrFail($roomId);

        // $now = now();

        $bookings = Booking::with('customer')
            ->where('room_id', $roomId)
            ->where('status', 'pending') // chưa checkin
            // ->where('start_time', '<=', $now)
            // ->where('end_time', '>=', $now)
            ->orderBy('check_in', 'asc')
            ->get();

        return response()->json([
            'room' => $room,
            'bookings' => $bookings
        ]);
    }
}
