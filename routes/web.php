<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Manager\RoomController;
use App\Http\Controllers\Manager\TypeRoomController;
use App\Http\Controllers\Manager\RoomServiceController;
use App\Http\Controllers\Saler\BookingController;
use App\Http\Controllers\Saler\BookingServiceController;
use App\Http\Controllers\Saler\CustomerController;

Route::get('/', [HomeController::class, 'index'])->name('login');

Route::get('/login', [AuthController::class, 'form_login'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'form_register'])->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');



Route::prefix('room')->name('room.')->group(function () {
    Route::get('manage-room', [RoomController::class, 'index'])->name('manage-room')->middleware('auth');
    //lọc phòng
    Route::post('manage-room', [RoomController::class, 'index'])->name('manage-room')->middleware('auth');
    //thêm phòng
    Route::post('manage-room/store', [RoomController::class, 'store'])->name('manage-room.store')->middleware('auth');
    //handle sửa phòng
    Route::put('manage-room/update/{room}', [RoomController::class, 'update'])->name('manage-type-room.update')->middleware('auth');



    //trang quản lý loại phòng
    Route::get('manage-type-room', [TypeRoomController::class, 'index'])->name('manage-type-room')->middleware('auth');
    //lọc loại phòng
    Route::post('manage-type-room', [TypeRoomController::class, 'index'])->middleware('auth');

    //handle thêm loại phòng
    Route::post('manage-type-room/store', [TypeRoomController::class, 'store'])->name('manage-type-room.store')->middleware('auth');

    //handle sửa loại phòng
    Route::put('manage-type-room/update/{typeRoom}', [TypeRoomController::class, 'update'])->name('manage-type-room.update')->middleware('auth');

    // Quản lý dịch vụ
    Route::get('manage-services', [RoomServiceController::class, 'index'])->name('manage-services')->middleware('auth');
    Route::post('manage-services/store', [RoomServiceController::class, 'store'])->name('manage-services.store')->middleware('auth');
    Route::put('manage-services/update/{roomService}', [RoomServiceController::class, 'update'])->name('manage-services.update')->middleware('auth');
    Route::delete('manage-services/destroy/{roomService}', [RoomServiceController::class, 'destroy'])->name('manage-services.destroy')->middleware('auth');
    

});


Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('manage-customer', [CustomerController::class, 'index'])->name('manage-customer');
    Route::post('manage-customer', [CustomerController::class, 'index'])->name('manage-customer');
});
Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('manage-booking', [BookingController::class, 'index'])->name('manage-booking');
    // Route::post('manage-customer', [CustomerController::class, 'index'])->name('manage-customer');
});


Route::prefix('reserve')->name('reserve.')->group(function () {
    Route::get('reserves', [RoomController::class,  'manage_reserve'])->name('manage_reserve');
});


Route::prefix('booking-services')->group(function(){
    Route::put('booking-service/update/{bookingId}', [BookingServiceController::class, 'update'])->name('booking-services.update');
});