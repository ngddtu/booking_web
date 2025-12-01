<?php

namespace App\Http\Controllers\Manager;

use App\Models\RoomService;
use App\Http\Requests\StoreRoomServiceRequest;
use App\Http\Requests\UpdateRoomServiceRequest;

use App\Http\Controllers\Controller;

class RoomServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = RoomService::orderBy('id', 'desc')->paginate(10);
        $title = 'Quản lý dịch vụ';
        return view('admins.manage-services', compact('services', 'title'));
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
    public function store(StoreRoomServiceRequest $request)
    {
        try {
            RoomService::create($request->validated());
            return redirect()->back()->with('success', 'Thêm dịch vụ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm dịch vụ thất bại!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomService $roomService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomService $roomService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomServiceRequest $request, RoomService $roomService)
    {
        try {
            $roomService->update($request->validated());
            return redirect()->back()->with('success', 'Cập nhật dịch vụ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật dịch vụ thất bại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomService $roomService)
    {
        try {
            $roomService->delete();
            return redirect()->back()->with('success', 'Xóa dịch vụ thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa dịch vụ thất bại!');
        }
    }
}
