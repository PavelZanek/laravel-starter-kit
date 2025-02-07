<?php

declare(strict_types=1);

return [
    'headline' => 'Váš uživatelský profil',
    'update_profile_information_form' => [
        'title' => 'Informace o profilu',
        'description' => 'Aktualizujte informace o svém profilu a e-mailové adrese.',
        'fields' => [
            'photo' => 'Fotografie',
            'name' => 'Jméno',
            'email' => 'E-mail',
        ],
        'messages' => [
            'unverified_email_address' => 'Vaše e-mailová adresa není ověřena.',
            'verification_link_has_been_sent' => 'Nový ověřovací odkaz byl odeslán na vaši e-mailovou adresu.',
        ],
        'actions' => [
            'select_new_photo' => 'Vybrat novou fotografii',
            'remove_photo' => 'Odstranit fotografii',
            'resend_verification_email' => 'Klikněte zde pro opětovné odeslání ověřovacího e-mailu.',
        ],
    ],
    'update_password_form' => [
        'title' => 'Aktualizace hesla',
        'description' => 'Ujistěte se, že váš účet používá dlouhé a náhodné heslo pro vyšší bezpečnost.',
        'fields' => [
            'current_password' => 'Současné heslo',
            'new_password' => 'Nové heslo',
            'confirm_password' => 'Potvrzení nového hesla',
        ],
        'messages' => [
            'current_password_incorrect' => 'Zadané heslo neodpovídá vašemu současnému heslu.',
        ],
    ],
    'two_factor_authentication_form' => [
        'title' => 'Dvoufaktorové ověřování',
        'description' => 'Přidejte ke svému účtu další vrstvu zabezpečení pomocí dvoufaktorového ověřování.',
        'messages' => [
            'finish_enabling' => 'Dokončete aktivaci dvoufaktorového ověřování.',
            'enabled' => 'Dvoufaktorové ověřování je aktivní.',
            'not_enabled' => 'Dvoufaktorové ověřování není aktivní.',
            'description' => 'Po aktivaci dvoufaktorového ověřování budete při přihlášení požádáni o zadání bezpečnostního kódu. Tento kód můžete získat z aplikace Google Authenticator na svém telefonu.',
            'finish_qr' => 'Pro dokončení aktivace dvoufaktorového ověřování naskenujte níže uvedený QR kód pomocí autentizační aplikace ve svém telefonu nebo zadejte konfigurační klíč a vygenerovaný OTP kód.',
            'qr_code' => 'Dvoufaktorové ověřování je nyní aktivní. Naskenujte níže uvedený QR kód pomocí autentizační aplikace ve svém telefonu nebo zadejte konfigurační klíč.',
            'recovery_codes_info' => 'Uložte si tyto záložní kódy do správce hesel. Můžete je použít k obnovení přístupu k účtu v případě ztráty dvoufaktorového ověřovacího zařízení.',
        ],
        'fields' => [
            'setup_key' => 'Konfigurační klíč',
            'code' => 'Kód',
        ],
        'actions' => [
            'regenerate_recovery_codes' => 'Znovu vygenerovat záložní kódy',
            'show_recovery_codes' => 'Zobrazit záložní kódy',
        ],
    ],
    'logout_other_browser_sessions' => [
        'title' => 'Relace v prohlížeči',
        'description' => 'Spravujte a odhlaste aktivní relace v jiných prohlížečích a zařízeních.',
        'info' => 'Pokud je to nutné, můžete se odhlásit ze všech ostatních relací na všech svých zařízeních. Níže jsou uvedeny některé z vašich nedávných relací; tento seznam však nemusí být vyčerpávající. Pokud máte podezření, že byl váš účet napaden, měli byste si také změnit heslo.',
        'this_device' => 'Toto zařízení',
        'last_active' => 'Naposledy aktivní: :time',
        'action' => 'Odhlásit ostatní relace',
        'confirm_message' => 'Pro potvrzení, že se chcete odhlásit ze všech ostatních relací na všech svých zařízeních, zadejte své heslo.',
        'password_placeholder' => 'Heslo',
    ],
    'delete_account' => [
        'title' => 'Smazání účtu',
        'description' => 'Trvale smažte svůj účet.',
        'warning' => 'Jakmile bude váš účet smazán, všechna jeho data a zdroje budou nenávratně odstraněny. Před smazáním účtu si stáhněte všechna data, která chcete zachovat.',
        'confirm_message' => 'Opravdu chcete smazat svůj účet? Jakmile bude váš účet smazán, všechna jeho data budou nenávratně odstraněna. Pro potvrzení zadejte své heslo.',
        'password_placeholder' => 'Heslo',
        'action' => 'Smazat účet',
    ],
];
