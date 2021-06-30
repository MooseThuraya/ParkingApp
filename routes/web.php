<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationsController;

//Route::get('/login-page', function () {
//    return view('auth.login');
//});
Route::get('/start-page', [AuthController::class, 'startPage'])->name('startPage');
Route::get('/login-page', [AuthController::class, 'login'])->name('login');
Route::get('/quick-login', [AuthController::class, 'quickLogin'])->name('quickLogin');
Route::get('/register-page', [AuthController::class, 'registerPage'])->name('registerPage');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/verify-otp-login', [AuthController::class, 'verifyOtpLogin'])->name('verifyOtpLogin');
Route::post('/login-with-otp', [AuthController::class, 'loginWithOtp'])->name('loginWithOtp');
Route::post('/send-qr', [AuthController::class, 'sendQR'])->name('sendQR');
Route::post('/request-otp', [AuthController::class, 'requestOtp'])->name('requestOtp');
//Route::get('/register-page', function () {
//    return view('auth.register');
//});
//Route::get('/register-page', [AuthController::class, 'registerPage'])->name('register-page');
Route::get('/qr-sent', function () {
    return view('auth.qrsent');
});
Route::get('/otp', function () {
    return view('auth.otp');
});
Route::resource('home', HomeController::class);

Route::group(['middleware' => ['auth']], function () {

    Route::resource('reservations', ReservationsController::class);
    Route::resource('packages', PackagesController::class);
    Route::resource('profile', ProfileController::class);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/reserve', [ReservationsController::class, 'reserve'])->name('reserve');
    Route::post('/reservation-details', [ReservationsController::class, 'reservationDetails'])->name('reservationDetails');
    Route::post('/cancel-reservation', [ReservationsController::class, 'cancelReservation'])->name('cancelReservation');
    Route::post('/check-reservation', [ReservationsController::class, 'checkReservation'])->name('checkReservation');
    Route::post('/profile', [ProfileController::class, 'index'])->name('profile');

});

