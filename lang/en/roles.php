<?php

declare(strict_types=1);

return [
    'index' => [
        'title' => 'Roles',
        'headline' => 'List of all user roles',
        'meta_description' => 'List of all user roles',
        'table' => [
            'name' => 'Name',
            'guard_name' => 'Guard',
            'is_default' => 'Default',
            'number_of_users' => 'Number of users',
            'no_items' => 'No users found',
        ],
        'form' => [
            'name' => 'Name',
            'guard_name' => 'Guard',
        ],
        'validation' => [
            'name' => [
                'required' => 'The :attribute is required',
                'string' => 'The :attribute must be a string',
                'max' => 'The :attribute may not be greater than :max characters',
            ],
            'guard_name' => [
                'required' => 'The :attribute is required',
                'string' => 'The :attribute must be a string',
                'max' => 'The :attribute may not be greater than :max characters',
                'enum' => 'Select a valid :attribute',
            ],
        ],
        'create_role' => 'Create role',
        'edit_role' => 'Edit role',
        'delete_role' => 'Delete role',
        'confirm_delete_role' => 'Are you sure you want to delete this role?',
        'flash_messages' => [
            'delete_error' => 'Cannot delete a role that is assigned to users',
        ],
    ],
];
