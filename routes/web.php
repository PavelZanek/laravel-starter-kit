<?php

declare(strict_types=1);

use App\Http\Controllers\LanguageSwitcherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/locale/{locale}', LanguageSwitcherController::class)->name('locale.switch');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function (): void {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
