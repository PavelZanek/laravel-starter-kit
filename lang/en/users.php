<?php

declare(strict_types=1);

return [
    'index' => [
        'title' => 'Users',
        'headline' => 'List of all users',
        'meta_description' => 'List of all users',
        'table' => [
            'name' => 'Name',
            'email' => 'Email',
            'role' => 'Role',
            'no_items' => 'No users found',
            'select_role' => 'Select role',
        ],
        'form' => [
            'name' => 'Name',
            'email' => 'Email',
            'role' => 'Role',
        ],
        'validation' => [
            'name' => [
                'required' => 'The :attribute is required',
                'string' => 'The :attribute must be a string',
                'max' => 'The :attribute may not be greater than :max characters',
            ],
            'email' => [
                'required' => 'The :attribute is required',
                'string' => 'The :attribute must be a string',
                'email' => 'The :attribute must be a valid email address',
                'max' => 'The :attribute may not be greater than :max characters',
                'unique' => 'The :attribute must be unique',
            ],
            'role' => [
                'required' => 'The :attribute is required',
                'numeric' => 'The :attribute must be a valid option',
                'exists' => 'The :attribute must exist',
            ],
        ],
        'create_user' => 'Create user',
        'edit_user' => 'Edit user',
        'delete_user' => 'Delete user',
        'confirm_delete_user' => 'Are you sure you want to delete this user?',
    ],
];
