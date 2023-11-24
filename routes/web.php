<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/riyadh-hotel')->group(function () {
    Route::get('', function () {
        return view('hotel.roomsList');
    });

    Route::get('/jobs', function () {
        return view('hotel.jobs');
    });

    Route::get('/login', function () {
        return view('hotel.login');
    });

    Route::get('/register', function () {
        return view('hotel.register');
    });
});

Auth::routes();

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminPanel\DashboardController::class, 'index'])->middleware('auth:sanctum')->name('dashboard');
    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', \App\Http\Controllers\AdminPanel\UserController::class);
        Route::resource('rooms', \App\Http\Controllers\AdminPanel\RoomsController::class);
        Route::resource('pending-rooms', \App\Http\Controllers\AdminPanel\PendingRoomsController::class);
        Route::post('/rooms/{id}/confirm', [\App\Http\Controllers\AdminPanel\PendingRoomsController::class, 'confirmBooking'])->name('rooms.confirm');
        Route::post('/rooms/{id}/reject', [\App\Http\Controllers\AdminPanel\PendingRoomsController::class, 'rejectBooking'])->name('rooms.reject');
    });

    // Employee routes
    Route::middleware(['role:admin,employee'])->group(function () {
        Route::resource('pending-rooms', \App\Http\Controllers\AdminPanel\PendingRoomsController::class);
        Route::post('/rooms/{id}/confirm', [\App\Http\Controllers\AdminPanel\PendingRoomsController::class, 'confirmBooking'])->name('rooms.confirm');
        Route::post('/rooms/{id}/reject', [\App\Http\Controllers\AdminPanel\PendingRoomsController::class, 'rejectBooking'])->name('rooms.reject');
    });
});



