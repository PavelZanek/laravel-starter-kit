<?php

declare(strict_types=1);

use App\Livewire\Layout\AppNavigation;

use function Pest\Livewire\livewire;

test('AppNavigation component renders successfully', function (): void {
    livewire(AppNavigation::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.layout.app-navigation');
});
