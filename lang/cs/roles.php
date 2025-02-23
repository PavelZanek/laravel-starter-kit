<?php

declare(strict_types=1);

return [
    'index' => [
        'title' => 'Role',
        'headline' => 'Seznam všech uživatelských rolí',
        'meta_description' => 'Seznam všech uživatelských rolí',
        'table' => [
            'name' => 'Jméno',
            'guard_name' => 'Guard',
            'is_default' => 'Výchozí',
            'number_of_users' => 'Počet uživatelů',
            'no_items' => 'Žádné uživatelské role nebyly nalezeny',
        ],
        'form' => [
            'name' => 'Jméno',
            'guard_name' => 'Guard',
        ],
        'validation' => [
            'name' => [
                'required' => ':Attribute je povinné',
                'string' => ':Attribute musí být řetězec',
                'max' => ':Attribute nesmí být delší než :max znaků',
            ],
            'guard_name' => [
                'required' => ':Attribute je povinné',
                'string' => ':Attribute musí být řetězec',
                'max' => ':Attribute nesmí být delší než :max znaků',
                'enum' => 'Vyberte platný :attribute',
            ],
        ],
        'create_role' => 'Vytvořit uživatelskou roli',
        'edit_role' => 'Upravit uživatelskou roli',
        'delete_role' => 'Smazat uživatelskou roli',
        'confirm_delete_role' => 'Opravdu chcete smazat tuto uživatelskou roli?',
        'flash_messages' => [
            'delete_error' => 'Nelze smazat uživatelskou roli, která je přiřazena k uživatelům',
        ],
    ],
];
