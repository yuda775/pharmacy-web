<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance')->middleware('auth');
Route::post('/checkin', [App\Http\Controllers\AttendanceController::class, 'checkIn'])->name('checkin')->middleware('auth');
Route::post('/checkout', [App\Http\Controllers\AttendanceController::class, 'checkOut'])->name('checkout')->middleware('auth');

Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('showLogin')->middleware('guest');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
