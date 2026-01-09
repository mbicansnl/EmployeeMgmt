<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LocalLoginController;
use App\Http\Controllers\Auth\OktaController;
use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;

Route::get('/health', HealthController::class)->name('health');

Route::get('/auth/okta/redirect', [OktaController::class, 'redirect'])->name('okta.redirect');
Route::get('/auth/okta/callback', [OktaController::class, 'callback'])->name('okta.callback');

Route::get('/login', [LocalLoginController::class, 'show'])->name('login');
Route::post('/login', [LocalLoginController::class, 'store'])->name('login.store');
