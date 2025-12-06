<?php

namespace App\Http\Controllers\Manager;

use App\Models\TypeRoom;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeRoomRequest;
use App\Http\Requests\UpdateTypeRoomRequest;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Validation\ValidationException;

class TypeRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $type_rooms;
    public function __construct(TypeRoom $type_rooms)
    {
        $this->type_rooms = $type_rooms;
    }
    public function index(Request $request)
    {
        // if($request->all()){
        //     dd($request->all());
        // }
        $typerooms = $this->type_rooms->scopeFilter($request->all());
        // dd($typerooms[3]);
        // if($request->all()){
        //     dd($typerooms);
        // }
        // dd($typerooms);
        return view('admins.manage-type-room', compact('typerooms'));
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
        try {
            $data = $request->validate([
                'name' => 'required|string|max:100|unique:room_types,name',
                'max_people' => 'required|integer|min:1',
                'extra_person_fee' => 'nullable|numeric|min:0',
                'initial_hour_rate' => 'required|numeric|min:0',
                'overnight_rate' => 'required|numeric|min:0',
                'daily_rate' => 'required|numeric|min:0',
                'late_checkout_fee_value' => 'nullable|numeric|min:0',
                'description' => 'nullable|string|max:255',
                'status' => 'required',
            ]);

            $this->type_rooms->store_new_type_room($data);
            // dd($data);
            return redirect()->back()->with('success', 'Thêm loại phòng thành công!');
        } catch (ValidationException $e) {
            $message = $e->errors();
            $message = $e->errors();
            return redirect()->back()
                ->with('error', 'Thêm loại phòng không thành công!')
                ->withErrors($message) // truyền lỗi từng field
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeRoom $typeRoom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeRoom $typeRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeRoom $typeRoom)
    {
        // dd($request->all());
        try {
            $data = $request->validate([
                'name' => 'required|string|max:100|unique:room_types,name, ' . $typeRoom->id,
                'max_people' => 'required|integer|min:1',
                'extra_person_fee' => 'nullable|numeric|min:0',
                'initial_hour_rate' => 'required|numeric|min:0',
                'overnight_rate' => 'required|numeric|min:0',
                'daily_rate' => 'required|numeric|min:0',
                'late_checkout_fee_value' => 'nullable|numeric|min:0',
                'description' => 'nullable|string|max:255',
                'status' => 'required',
            ]);
            // dd($data);
            // if ($this->type_rooms->update_type_room($typeRoom->id, $data)) {
            $this->type_rooms->update_type_room($typeRoom->id, $data);
            return redirect()->back()->with('success', 'Sửa loại phòng thành công!');
            // } else {
            //     return redirect()->back()->with('error', 'Đang có phòng liên kết không thể khóa');
            // }
        } catch (ValidationException $e) {
            $message = $e->errors();
            return redirect()->back()
                ->with('error', 'Sửa loại phòng không thành công!')
                ->withErrors($message) // truyền lỗi từng field
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeRoom $typeRoom) {}
}
