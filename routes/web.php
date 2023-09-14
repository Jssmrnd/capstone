<?php

use App\Http\Controllers\ClientLogin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function(){
    return redirect('home');
});

Route::get('/login', function(){
    return view('filament.customer.customer-login');
})->name('login');

Route::post('/login',[ClientLogin::class, 'authenticate']);

// Route::get('/application', function(){
//     return redirect('home');
// })->name('application');

Route::get('/register', function(){
    return redirect('home');
})->name('register');