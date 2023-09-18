<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerLogin extends Controller
{

    public function index()
    {
        return view('filament.customer.customer-login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        if (Auth::guard()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/home');
        }
        return redirect('/home');
    }
}
