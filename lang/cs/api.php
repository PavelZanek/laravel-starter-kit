<?php

declare(strict_types=1);

return [
    'pages' => [
        'api_token_manager' => [
            'headline' => 'API Tokeny',
        ],
    ],
    'api_token_manager' => [
        'create' => [
            'title' => 'Vytvořit API token',
            'description' => 'API tokeny umožňují třetím stranám autentizovat se v naší aplikaci vaším jménem.',
            'fields' => [
                'token_name' => 'Název tokenu',
                'permissions' => 'Oprávnění',
            ],
            'messages' => [
                'created' => 'API token byl vytvořen.',
            ],
        ],
        'manage' => [
            'title' => 'Správa API tokenů',
            'description' => 'Můžete smazat libovolný ze svých existujících tokenů, pokud je již nepotřebujete.',
            'fields' => [
                'last_used' => 'Naposledy použito',
            ],
        ],
        'modals' => [
            'display_token' => [
                'title' => 'API Token',
                'description' => 'Zkopírujte si svůj nový API token. Z bezpečnostních důvodů nebude zobrazen znovu.',
            ],
            'permissions' => [
                'title' => 'Oprávnění API tokenu',
            ],
            'delete' => [
                'title' => 'Smazat API token',
                'description' => 'Opravdu chcete smazat tento API token?',
            ],
        ],
    ],
];
