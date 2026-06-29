<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EventController;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/bookings', [BookingController::class, 'store'])
    ->middleware('auth')
    ->name('bookings.store');

Route::get('/', [EventController::class,'index'])->name('events.index');

Route::get('/my-bookings',[BookingController::class,'index'])
    ->middleware('auth')
    ->name('bookings.index');

require __DIR__.'/auth.php';
