<?php

declare(strict_types=1);

return [
    'pages' => [
        'team_settings' => [
            'headline' => 'Nastavení týmu',
        ],
        'create_new_team' => [
            'headline' => 'Vytvořit nový tým',
        ],
    ],
    'update_team_name_form' => [
        'title' => 'Název týmu',
        'description' => 'Název týmu a informace o vlastníkovi.',
        'fields' => [
            'team_owner' => 'Vlastník týmu',
            'team_name' => 'Název týmu',
        ],
    ],
    'team_member_manager' => [
        'add_member' => [
            'title' => 'Přidat člena týmu',
            'description' => 'Přidejte nového člena týmu, aby s vámi mohl spolupracovat.',
            'info' => 'Zadejte e-mailovou adresu osoby, kterou chcete přidat do tohoto týmu.',
            'messages' => [
                'user_not_found' => 'Nepodařilo se nám najít registrovaného uživatele s touto e-mailovou adresou.',
                'belongs_to_team' => 'Tento uživatel již patří do týmu.',
                'user_already_invited' => 'Tento uživatel již byl do týmu pozván.',
            ],
        ],
        'fields' => [
            'email' => 'E-mail',
            'role' => 'Role',
        ],
        'pending_invitations' => [
            'title' => 'Čekající pozvánky do týmu',
            'description' => 'Tito lidé byli pozváni do vašeho týmu a obdrželi pozvánkový e-mail. Mohou se k týmu připojit přijetím této pozvánky.',
        ],
        'team_members' => [
            'title' => 'Členové týmu',
            'description' => 'Všichni lidé, kteří jsou součástí tohoto týmu.',
        ],
        'manage_role' => [
            'title' => 'Správa rolí',
        ],
        'leave_team' => [
            'title' => 'Opustit tým',
            'description' => 'Opravdu chcete opustit tento tým?',
        ],
        'remove_team_member' => [
            'title' => 'Odebrat člena týmu',
            'description' => 'Opravdu chcete tuto osobu odebrat z týmu?',
            'messages' => [
                'owner' => 'Nemůžete opustit tým, který jste vytvořili.',
            ],
        ],
    ],
    'delete_team_form' => [
        'title' => 'Smazat tým',
        'description' => 'Trvale smažte tento tým.',
        'warning' => 'Jakmile bude tým smazán, všechna jeho data a zdroje budou nenávratně odstraněny. Před smazáním týmu si stáhněte všechna data, která si přejete zachovat.',
        'confirmation' => 'Opravdu chcete smazat tento tým? Jakmile bude tým smazán, všechna jeho data a zdroje budou nenávratně odstraněny.',
        'action' => 'Smazat tým',
    ],
    'create_team_form' => [
        'title' => 'Detaily týmu',
        'description' => 'Vytvořte nový tým pro spolupráci na projektech.',
        'fields' => [
            'team_owner' => 'Vlastník týmu',
            'team_name' => 'Název týmu',
        ],
    ],
];
