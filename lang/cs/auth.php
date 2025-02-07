<?php

declare(strict_types=1);

return [
    'register' => [
        'terms' => 'Souhlasím s :terms_of_service a :privacy_policy.',
        'already_registered' => 'Už máte účet?',
        'fields' => [
            'name' => 'Jméno',
            'email' => 'E-mail',
            'password' => 'Heslo',
            'password_confirmation' => 'Potvrzení hesla',
        ],
        'actions' => [
            'register' => 'Registrovat se',
        ],
    ],
    'login' => [
        'fields' => [
            'email' => 'E-mail',
            'password' => 'Heslo',
        ],
        'remember' => 'Zapamatovat si mě',
        'forgot_password' => 'Zapomněli jste heslo?',
        'actions' => [
            'login' => 'Přihlásit se',
        ],
    ],
    'confirm_password' => [
        'description' => 'Toto je zabezpečená oblast aplikace. Před pokračováním prosím potvrďte své heslo.',
        'fields' => [
            'password' => 'Heslo',
        ],
        'actions' => [
            'confirm' => 'Potvrdit',
        ],
    ],
    'forgot_password' => [
        'description' => 'Zapomněli jste heslo? Žádný problém. Stačí zadat svou e-mailovou adresu a my vám pošleme odkaz pro obnovení hesla, abyste si mohli nastavit nové.',
        'fields' => [
            'email' => 'E-mail',
        ],
        'actions' => [
            'send' => 'Odeslat odkaz pro obnovení hesla',
        ],
    ],
    'reset_password' => [
        'fields' => [
            'email' => 'E-mail',
            'password' => 'Heslo',
            'confirm_password' => 'Potvrzení hesla',
        ],
        'actions' => [
            'reset' => 'Obnovit heslo',
        ],
    ],
    'two_factor_challenge' => [
        'confirm_authentication_code' => 'Pro přístup k účtu zadejte ověřovací kód z vaší autentizační aplikace.',
        'confirm_recovery_code' => 'Pro přístup k účtu zadejte jeden ze svých nouzových obnovovacích kódů.',
        'fields' => [
            'code' => 'Kód',
            'recovery_code' => 'Obnovovací kód',
        ],
        'actions' => [
            'use_recovery_code' => 'Použít obnovovací kód',
            'use_authentication_code' => 'Použít ověřovací kód',
            'log_in' => 'Přihlásit se',
        ],
    ],
    'verify_email' => [
        'description' => 'Před pokračováním prosím ověřte svou e-mailovou adresu kliknutím na odkaz, který jsme vám právě poslali. Pokud jste e-mail neobdrželi, rádi vám jej pošleme znovu.',
        'edit_profile' => 'Upravit profil',
        'flash_messages' => [
            'resent' => 'Nový ověřovací odkaz byl odeslán na e-mailovou adresu uvedenou ve vašem profilu.',
        ],
        'actions' => [
            'resend' => 'Znovu odeslat ověřovací e-mail',
            'log_out' => 'Odhlásit se',
        ],
    ],
];
