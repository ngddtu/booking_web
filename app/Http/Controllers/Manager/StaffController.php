<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        // List only employees (ROLE_SALER)
        $staffs = User::where('role', User::ROLE_SALER)->orderBy('id', 'desc')->paginate(10);
        return view('admins.manage-staff', compact('staffs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_SALER, // Force create as staff
        ]);

        return redirect()->back()->with('success', 'Thêm nhân viên thành công!');
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== User::ROLE_SALER) {
             return redirect()->back()->with('error', 'Không thể sửa tài khoản quản trị!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|unique:users,phone,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Cập nhật nhân viên thành công!');
    }

    public function destroy(User $user)
    {
        if ($user->role !== User::ROLE_SALER) {
             return redirect()->back()->with('error', 'Không thể xóa tài khoản quản trị!');
        }
        $user->delete();
        return redirect()->back()->with('success', 'Xóa nhân viên thành công!');
    }
}
