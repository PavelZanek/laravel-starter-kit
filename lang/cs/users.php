<?php

declare(strict_types=1);

return [
    'index' => [
        'title' => 'Uživatelé',
        'headline' => 'Seznam všech uživatelů',
        'meta_description' => 'Seznam všech uživatelů',
        'table' => [
            'name' => 'Jméno',
            'email' => 'Email',
            'role' => 'Role',
            'actions' => 'Akce',
            'no_items' => 'Žádní uživatelé nenalezeni',
            'select_role' => 'Vyberte roli',
        ],
        'form' => [
            'name' => 'Jméno',
            'email' => 'Email',
            'role' => 'Role',
        ],
        'validation' => [
            'name' => [
                'required' => ':Attribute je povinné',
                'string' => ':Attribute musí být řetězec',
                'max' => ':Attribute nesmí být delší než :max znaků',
            ],
            'email' => [
                'required' => ':Attribute je povinný',
                'string' => ':Attribute musí být řetězec',
                'email' => ':Attribute musí být platná emailová adresa',
                'max' => ':Attribute nesmí být delší než :max znaků',
                'unique' => ':Attribute musí být unikátní',
            ],
            'role' => [
                'required' => ':Attribute je povinná',
                'numeric' => ':Attribute musí být platná možnost',
                'exists' => ':Attribute musí existovat',
            ],
        ],
        'create_user' => 'Vytvořit uživatele',
        'edit_user' => 'Upravit uživatele',
        'delete_user' => 'Smazat uživatele',
        'confirm_delete_user' => 'Opravdu chcete smazat tohoto uživatele?',
    ],
];
