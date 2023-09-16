<?php

use App\Http\Controllers\ClientLogin;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerLogin;
use App\Http\Middleware\CustomerUser;
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




Route::get('/login', [CustomerLogin::class, 'index'])
->name('login');

Route::post('/login', [CustomerLogin::class, 'authenticate']);

Route::get('/register', [CustomerController::class, 'create'])
->name('register');

Route::post('/register', [CustomerController::class, 'store']);

Route::get('/logout', [CustomerController::class, 'destroy'])
->name('logout');