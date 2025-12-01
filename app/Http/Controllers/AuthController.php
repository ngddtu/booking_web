<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    //handle login---------------------------
    public function login(Request $request)
    {
        $user = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        // dd($user);
        if($this->user->login($user)){
            $request->session()->regenerate();
            return redirect('/');
        } else {
            return redirect('/login')->with('error','Invalid login.');
        }
    }

    function form_login()
    {
        return view('auth.login');
    }



    //-----------------handle register----------------------
    public function register(Request $request)
    {
        try {
            $user = $request->validate([
                'name' => 'required|min:3',
                'email' => 'required|unique:users,email',
                'phone' => 'required|unique:users,phone',
                'password' => 'required|min:6|confirmed',
            ]);
            $this->user->register($user);
            return redirect('/login');
        } catch (ValidationException $e) {
            $message = $e->errors();
            return redirect()->back()
                ->withErrors($message); // truyền lỗi từng field
                // ->withInput();
        }
        // dd($user);
    }

    public function form_register()
    {
        return view('auth.register');
    }


    /* -----------------logout---------------- */
    public function logout() {
        auth()->logout();
        return redirect('/login')->with('success', 'Logout thành công');
    }
}
