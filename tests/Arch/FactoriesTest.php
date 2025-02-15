<?php

declare(strict_types=1);

arch('factories')
    ->expect('Database\Factories')
    ->toExtend('Illuminate\Database\Eloquent\Factories\Factory')
    // ->toUse('Database\Factories\Concerns\RefreshOnCreate')
    ->toHaveMethod('definition')
    ->ignoring('Database\Factories\Concerns')
    ->toOnlyBeUsedIn([
        'App\Models',
    ]);
