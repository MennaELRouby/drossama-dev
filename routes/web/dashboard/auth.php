<?php

use App\Http\Controllers\Dashboard\Auth\DashboardLoginController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function () {
    Route::get('login', [DashboardLoginController::class, 'showLoginForm'])->name('login')->middleware('guest:admin');
    Route::post('login/check', [DashboardLoginController::class, 'check'])->name('check')->middleware(['guest:admin', 'throttle:5,1']);
    Route::post('logout', [DashboardLoginController::class, 'logout'])->name('logout');
});
