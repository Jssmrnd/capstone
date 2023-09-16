<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function create()
    {
        return view('filament.customer.customer-register');
    }

    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = Customer::create([
            'customer_email' => $credentials["email"],
            'password' => $credentials["password"],
        ]);

        auth()->login($user);
        return redirect('/home');

    }

    public function destroy(){
        auth()->logout();
        return redirect("/home");
    }
}
