<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Manager\RoomController;
use App\Http\Controllers\TypeRoomController;

Route::get('/', [HomeController::class, 'index'])->name('login');

Route::get('/login', [AuthController::class, 'form_login'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'form_register'])->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');



Route::prefix('room')->name('room.')->group(function () {
    Route::get('manage-room', [RoomController::class, 'index'])->name('manage-room');
    //lọc phòng
    Route::post('manage-room', [RoomController::class, 'index'])->name('manage-room');
    //thêm phòng
    Route::post('manage-room/store', [RoomController::class, 'store'])->name('manage-room.store')->middleware('auth');




    //trang quản lý loại phòng
    Route::get('manage-type-room', [TypeRoomController::class, 'index'])->name('manage-type-room');
    //lọc loại phòng
    Route::post('manage-type-room', [TypeRoomController::class, 'index']);

    //handle thêm loại phòng
    Route::post('manage-type-room/store', [TypeRoomController::class, 'store'])->name('manage-type-room.store')->middleware('auth');

    //handle sửa loại phòng
    Route::put('manage-type-room/update/{typeRoom}', [TypeRoomController::class, 'update'])->name('manage-type-room.update')->middleware('auth');
});
