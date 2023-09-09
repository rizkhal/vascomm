<?php

use App\Http\Controllers\Auth\AuthSessionController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthSessionController::class, 'create'])->name('login');
Route::post('login', [AuthSessionController::class, 'store']);

Route::middleware('auth:web')->group(function () {
    Route::post('logout', [AuthSessionController::class, 'destroy'])->name('logout');
});
