<?php

declare(strict_types=1);

use App\View\Components\AppLayout;
use App\View\Components\GuestLayout;
use Illuminate\View\View;

test('the AppLayout component returns the correct view', function (): void {
    $component = new AppLayout;

    $view = $component->render();

    expect($view)
        ->toBeInstanceOf(View::class)
        ->and($view->name())->toBe('layouts.app');
});

test('the GuestLayout component returns the correct view', function (): void {
    $component = new GuestLayout;

    $view = $component->render();

    expect($view)
        ->toBeInstanceOf(View::class)
        ->and($view->name())->toBe('layouts.guest');
});
