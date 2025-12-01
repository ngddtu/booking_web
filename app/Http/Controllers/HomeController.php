<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if(auth()->check()){
            return view('admins.dashboard');
        } else {
            return redirect('/login');
        }
    }
}
