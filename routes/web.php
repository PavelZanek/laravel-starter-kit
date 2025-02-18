<?php

declare(strict_types=1);

use App\Enums\Users\DefaultRoleEnum;
use App\Http\Controllers\App\Admin\AdminDashboardController;
use App\Http\Controllers\App\Admin\UserController;
use App\Http\Controllers\App\DashboardController;
use App\Http\Controllers\Guest\HomepageController;
use App\Http\Controllers\LanguageSwitcherController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomepageController::class)->name('homepage');

Route::get('/locale/{locale}', LanguageSwitcherController::class)->name('locale.switch');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::name('admin.')->prefix('admin')->group(callback: function (): void {
        Route::group([
            'middleware' => ['role:'.DefaultRoleEnum::SUPER_ADMIN->value.'|'.DefaultRoleEnum::ADMIN->value],
        ], function (): void {
            Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
            Route::get('/users', UserController::class)->name('users.index');
        });
    });
});
