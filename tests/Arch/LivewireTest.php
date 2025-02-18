<?php

declare(strict_types=1);

arch('livewire components')
    ->expect([
        'App\Livewire\App',
        'App\Livewire\Layout',
    ])
    ->toBeClasses()
    ->toExtend('Livewire\Component')
    ->toHaveMethod('render')
    ->toOnlyBeUsedIn([
        'App\Http\Controllers',
        'App\Http\Livewire',
        'App\Providers\AppServiceProvider',
    ])
    ->not->toUse(['redirect', 'to_route', 'back']);

arch('livewire form objects')
    ->expect('App\Livewire\Forms')
    ->toBeClasses()
    ->toExtend('Livewire\Form')
    ->toHaveMethod('setFormData')
    ->toOnlyBeUsedIn([
        'App\Livewire\App',
        'App\Livewire\Layout',
    ])
    ->not->toUse(['redirect', 'to_route', 'back']);

arch('livewire concerns')
    ->expect('App\Livewire\Concerns')
    ->toBeTraits();
