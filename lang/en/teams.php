<?php

declare(strict_types=1);

return [
    'pages' => [
        'team_settings' => [
            'headline' => 'Team Settings',
        ],
        'create_new_team' => [
            'headline' => 'Create New Team',
        ],
    ],
    'update_team_name_form' => [
        'title' => 'Team Name',
        'description' => 'The team\'s name and owner information.',
        'fields' => [
            'team_owner' => 'Team Owner',
            'team_name' => 'Team Name',
        ],
    ],
    'team_member_manager' => [
        'add_member' => [
            'title' => 'Add Team Member',
            'description' => 'Add a new team member to your team, allowing them to collaborate with you.',
            'info' => 'Please provide the email address of the person you would like to add to this team.',
            'messages' => [
                'user_not_found' => 'We were unable to find a registered user with this email address.',
                'belongs_to_team' => 'This user already belongs to the team.',
                'user_already_invited' => 'This user has already been invited to the team.',
            ],
        ],
        'fields' => [
            'email' => 'Email',
            'role' => 'Role',
        ],
        'pending_invitations' => [
            'title' => 'Pending Team Invitations',
            'description' => 'These people have been invited to your team and have been sent an invitation email. They may join the team by accepting the email invitation.',
        ],
        'team_members' => [
            'title' => 'Team Members',
            'description' => 'All of the people that are part of this team.',
        ],
        'manage_role' => [
            'title' => 'Manage Role',
        ],
        'leave_team' => [
            'title' => 'Leave Team',
            'description' => 'Are you sure you would like to leave this team?',
        ],
        'remove_team_member' => [
            'title' => 'Remove Team Member',
            'description' => 'Are you sure you would like to remove this person from the team?',
            'messages' => [
                'owner' => 'You may not leave a team that you created.',
            ],
        ],
    ],
    'delete_team_form' => [
        'title' => 'Delete Team',
        'description' => 'Permanently delete this team.',
        'warning' => 'Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.',
        'confirmation' => 'Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.',
        'action' => 'Delete Team',
    ],
    'create_team_form' => [
        'title' => 'Team Details',
        'description' => 'Create a new team to collaborate with others on projects.',
        'fields' => [
            'team_owner' => 'Team Owner',
            'team_name' => 'Team Name',
        ],
    ],
];
