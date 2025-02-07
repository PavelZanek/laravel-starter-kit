<?php

declare(strict_types=1);

return [
    'pages' => [
        'api_token_manager' => [
            'headline' => 'API Tokens',
        ],
    ],
    'api_token_manager' => [
        'create' => [
            'title' => 'Create API Token',
            'description' => 'API tokens allow third-party services to authenticate with our application on your behalf.',
            'fields' => [
                'token_name' => 'Token Name',
                'permissions' => 'Permissions',
            ],
            'messages' => [
                'created' => 'API token has been created.',
            ],
        ],
        'manage' => [
            'title' => 'Manage API Tokens',
            'description' => 'You may delete any of your existing tokens if they are no longer needed.',
            'fields' => [
                'last_used' => 'Last used',
            ],
        ],
        'modals' => [
            'display_token' => [
                'title' => 'API Token',
                'description' => "Please copy your new API token. For your security, it won't be shown again.",
            ],
            'permissions' => [
                'title' => 'API Token Permissions',
            ],
            'delete' => [
                'title' => 'Delete API Token',
                'description' => 'Are you sure you would like to delete this API token?',
            ],
        ],
    ],
];
