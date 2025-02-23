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
    ],
    'create' => [
        'title' => 'Vytvořit roli',
        'headline' => 'Vytvořit novou uživatelskou roli',
        'meta_description' => 'Vytvořit novou uživatelskou roli',
        'create_role' => 'Vytvořit uživatelskou roli',
    ],
    'edit' => [
        'title' => 'Upravit roli',
        'headline' => 'Upravit uživatelskou roli',
        'meta_description' => 'Upravit uživatelskou roli',
        'edit_role' => 'Upravit uživatelskou roli',
    ],
    'delete' => [
        'delete_role' => 'Smazat uživatelskou roli',
        'confirm_delete_role' => 'Opravdu chcete smazat tuto uživatelskou roli?',
        'flash_messages' => [
            'delete_error' => 'Nelze smazat uživatelskou roli, která je přiřazena k uživatelům',
        ],
    ],
    'form' => [
        'name' => 'Jméno',
        'guard_name' => 'Guard',
        'permissions' => 'Oprávnění',
    ],
    'form_sections' => [
        'role_details' => [
            'title' => 'Detaily role',
            'description' => 'Zadejte detaily role',
        ],
        'permissions' => [
            'title' => 'Oprávnění',
            'description' => 'Vyberte oprávnění pro roli',
        ],
        'delete' => [
            'title' => 'Smazat roli',
            'description' => 'Opravdu chcete smazat tuto roli?',
            'more_info' => 'Tato akce nemůže být vrácena. Nemůže být žádný uživatel přiřazen k této roli.',
        ],
    ],
    'validation' => [
        'name' => [
            'required' => ':Attribute je povinné',
            'string' => ':Attribute musí být řetězec',
            'max' => ':Attribute nesmí být delší než :max znaků',
            'unique' => 'Tato :attribute již existuje',
        ],
        'guard_name' => [
            'required' => ':Attribute je povinné',
            'string' => ':Attribute musí být řetězec',
            'max' => ':Attribute nesmí být delší než :max znaků',
            'enum' => 'Vyberte platný :attribute',
        ],
        'permissions' => [
            'array' => ':Attribute musí být pole',
            'numeric' => ':Attribute musí být číslo',
            'exists' => 'Vyberte platné :attribute',
        ],
    ],
];
