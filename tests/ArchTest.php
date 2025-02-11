<?php

declare(strict_types=1);

arch()->preset()->php();

// arch()->preset()->strict();

arch()->preset()->security()->ignoring('assert');

arch()->preset()->laravel()
    ->ignoring([
        'App\Providers\AppServiceProvider',
    ]);

arch('strict types')
    ->expect('App')
    ->toUseStrictTypes();

arch('avoid open for extension')
    ->expect('App')
    ->classes()
    ->toBeFinal()
    ->ignoring([
        'App\Http\Controllers\Controller',
        'App\Models\User',
        'App\Models\Team',
    ]);

arch('ensure no extends')
    ->expect('App')
    ->classes()
    ->not->toBeAbstract()
    ->ignoring([
        'App\Http\Controllers\Controller',
    ]);

arch('avoid mutation')
    ->expect('App')
    ->classes()
    ->toBeReadonly()
    ->ignoring([
        'App\Console\Commands',
        'App\Exceptions',
        'App\Http\Controllers',
        'App\Http\Requests',
        'App\Jobs',
        'App\Livewire',
        'App\Mail',
        'App\Models',
        'App\Notifications',
        'App\Providers',
        'App\View',
        'App\Http\Responses',
    ]);

arch('avoid inheritance')
    ->expect('App')
    ->classes()
    ->toExtendNothing()
    ->ignoring([
        'App\Console\Commands',
        'App\Exceptions',
        'App\Http\Controllers',
        'App\Http\Requests',
        'App\Jobs',
        'App\Livewire',
        'App\Mail',
        'App\Models',
        'App\Notifications',
        'App\Providers',
        'App\View',
        'App\Http\Responses',
    ]);

// arch('annotations')
//    ->expect('App')
//    ->toHavePropertiesDocumented()
//    ->toHaveMethodsDocumented();
