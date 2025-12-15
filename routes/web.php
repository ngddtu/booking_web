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
use App\Models\Room;

Route::get('/', [HomeController::class, 'index'])->name('login');

Route::get('/login', [AuthController::class, 'form_login'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'form_register'])->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');



Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::middleware(['auth', 'role:manager'])->prefix('room')->name('room.')->group(function () {
    Route::get('manage-room', [RoomController::class, 'index'])->name('manage-room');
    //lọc phòng
    Route::post('manage-room', [RoomController::class, 'index'])->name('manage-room');
    //thêm phòng
    Route::post('manage-room/store', [RoomController::class, 'store'])->name('manage-room.store');
    //handle sửa phòng
    Route::put('manage-room/update/{room}', [RoomController::class, 'update'])->name('manage-type-room.update');

    //trang quản lý loại phòng
    Route::get('manage-type-room', [TypeRoomController::class, 'index'])->name('manage-type-room');
    //lọc loại phòng
    Route::post('manage-type-room', [TypeRoomController::class, 'index']);

    //handle thêm loại phòng
    Route::post('manage-type-room/store', [TypeRoomController::class, 'store'])->name('manage-type-room.store');

    //handle sửa loại phòng
    Route::put('manage-type-room/update/{typeRoom}', [TypeRoomController::class, 'update'])->name('manage-type-room.update');

    // Quản lý dịch vụ
    Route::get('manage-services', [RoomServiceController::class, 'index'])->name('manage-services');
    Route::post('manage-services/store', [RoomServiceController::class, 'store'])->name('manage-services.store');
    Route::put('manage-services/update/{roomService}', [RoomServiceController::class, 'update'])->name('manage-services.update');
    Route::delete('manage-services/destroy/{roomService}', [RoomServiceController::class, 'destroy'])->name('manage-services.destroy');

    // Quản lý nhân viên
    Route::get('manage-staff', [\App\Http\Controllers\Manager\StaffController::class, 'index'])->name('manage-staff');
    Route::post('manage-staff/store', [\App\Http\Controllers\Manager\StaffController::class, 'store'])->name('manage-staff.store');
    Route::put('manage-staff/update/{user}', [\App\Http\Controllers\Manager\StaffController::class, 'update'])->name('manage-staff.update');
    Route::delete('manage-staff/destroy/{user}', [\App\Http\Controllers\Manager\StaffController::class, 'destroy'])->name('manage-staff.destroy');

    //đơn booking theo phòng
    // Route::get('checkin-list/{room}', [RoomController::class, 'showCheckinModal'])->name('checkin-list');

});


Route::middleware(['auth', 'role:saler'])->group(function () {
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('manage-customer', [CustomerController::class, 'index'])->name('manage-customer');
        Route::post('manage-customer', [CustomerController::class, 'index'])->name('manage-customer');
        Route::post('store', [CustomerController::class, 'store'])->name('store');
        Route::get('show/{customer}', [CustomerController::class, 'show'])->name('show');
        Route::put('update/{customer}', [CustomerController::class, 'update'])->name('update');
        Route::post('destroy/{customer}', [CustomerController::class, 'destroy'])->name('destroy'); // Using POST for form, but ideally DELETE method spoofing
    });

    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('manage-booking', [BookingController::class, 'index'])->name('manage-booking');
        // Check-in / Check-out routes
        Route::post('store', [BookingController::class, 'store'])->name('store');
        // Route::post('check-in/{booking}', [BookingController::class, 'checkIn'])->name('check-in');

        //check out
        Route::post('check-out/{booking}', [BookingController::class, 'checkOut'])->name('check-out');
        


        Route::put('check-in/update/{booking}',[BookingController::class, 'update'])->name('check-in.update');
        //Cập nhật trạng thái booking
        Route::post('check-in/confirm-checkin/{booking}', [BookingController::class, 'updateStatus'])->name('check-in.confirm-checkin');
        //Xóa booking
        Route::delete('check-in/reject-checkin/{booking}', [BookingController::class, 'destroy']);
        
        // Route::post('maintenance/{room}', [BookingController::class, 'setMaintenance'])->name('maintenance');
        // Route::post('maintenance/finish/{room}', [BookingController::class, 'finishMaintenance'])->name('maintenance.finish');
        Route::post('cleaning/finish/{room}', [BookingController::class, 'finishCleaning'])->name('cleaning.finish');
        // Search customer API
        Route::get('search-customer', [BookingController::class, 'searchCustomer'])->name('search-customer');
    });

    Route::prefix('reserve')->name('reserve.')->group(function () {
        Route::get('reserves', [RoomController::class,  'manage_reserve'])->name('manage_reserve');
    });

    Route::prefix('booking-services')->group(function () {
        Route::put('booking-service/update/{bookingId}', [BookingServiceController::class, 'update'])->name('booking-services.update');
    });
    Route::get('/rooms/{id}/checkin-list', [RoomController::class, 'showCheckinModal']);
});
