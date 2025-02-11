<?php

declare(strict_types=1);

return [
    'available_locales' => [
        'en',
        'cs',
    ],
    'horizon' => [
        'allowed_email' => env('HORIZON_ALLOWED_EMAIL'),
    ],
    'telescope' => [
        'allowed_email' => env('TELESCOPE_ALLOWED_EMAIL'),
    ],
];
