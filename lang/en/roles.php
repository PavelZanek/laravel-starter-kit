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
            'no_items' => 'No roles found',
        ],
    ],
    'create' => [
        'title' => 'Create role',
        'headline' => 'Create a new user role',
        'meta_description' => 'Create a new user role',
        'create_role' => 'Create role',
    ],
    'edit' => [
        'title' => 'Edit role',
        'headline' => 'Edit user role',
        'meta_description' => 'Edit user role',
        'edit_role' => 'Edit role',
    ],
    'delete' => [
        'delete_role' => 'Delete role',
        'confirm_delete_role' => 'Are you sure you want to delete this role?',
        'flash_messages' => [
            'delete_error' => 'Cannot delete a role that is assigned to users',
        ],
    ],
    'form' => [
        'name' => 'Name',
        'guard_name' => 'Guard',
    ],
    'form_sections' => [
        'role_details' => [
            'title' => 'Role details',
            'description' => 'Enter the role details',
        ],
        'permissions' => [
            'title' => 'Permissions',
            'description' => 'Select the permissions for the role',
        ],
        'delete' => [
            'title' => 'Delete role',
            'description' => 'Are you sure you want to delete this role?',
            'more_info' => 'This action cannot be undone. There can not be any users assigned to this role.',
        ],
    ],
    'validation' => [
        'name' => [
            'required' => 'The :attribute is required',
            'string' => 'The :attribute must be a string',
            'max' => 'The :attribute may not be greater than :max characters',
            'unique' => 'This :attribute already exists',
        ],
        'guard_name' => [
            'required' => 'The :attribute is required',
            'string' => 'The :attribute must be a string',
            'max' => 'The :attribute may not be greater than :max characters',
            'enum' => 'Select a valid :attribute',
        ],
    ],
];
