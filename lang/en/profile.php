<?php

declare(strict_types=1);

return [
    'headline' => 'Your user profile',
    'update_profile_information_form' => [
        'title' => 'Profile Information',
        'description' => 'Update your account\'s profile information and email address.',
        'fields' => [
            'photo' => 'Photo',
            'name' => 'Name',
            'email' => 'Email',
        ],
        'messages' => [
            'unverified_email_address' => 'Your email address is unverified.',
            'verification_link_has_been_sent' => 'A new verification link has been sent to your email address.',
        ],
        'actions' => [
            'select_new_photo' => 'Select A New Photo',
            'remove_photo' => 'Remove Photo',
            'resend_verification_email' => 'Click here to re-send the verification email.',
        ],
    ],
    'update_password_form' => [
        'title' => 'Update Password',
        'description' => 'Ensure your account is using a long, random password to stay secure.',
        'fields' => [
            'current_password' => 'Current Password',
            'new_password' => 'New Password',
            'confirm_password' => 'Confirm New Password',
        ],
        'messages' => [
            'current_password_incorrect' => 'The provided password does not match your current password.',
        ],
    ],
    'two_factor_authentication_form' => [
        'title' => 'Two Factor Authentication',
        'description' => 'Add additional security to your account using two factor authentication.',
        'messages' => [
            'finish_enabling' => 'Finish enabling two factor authentication.',
            'enabled' => 'You have enabled two factor authentication.',
            'not_enabled' => 'You have not enabled two factor authentication.',
            'description' => 'When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.',
            'finish_qr' => 'To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.',
            'qr_code' => 'Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application or enter the setup key.',
            'recovery_codes_info' => 'Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.',
        ],
        'fields' => [
            'setup_key' => 'Setup Key',
            'code' => 'Code',
        ],
        'actions' => [
            'regenerate_recovery_codes' => 'Regenerate Recovery Codes',
            'show_recovery_codes' => 'Show Recovery Codes',
        ],
    ],
    'logout_other_browser_sessions' => [
        'title' => 'Browser Sessions',
        'description' => 'Manage and log out your active sessions on other browsers and devices.',
        'info' => 'If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.',
        'this_device' => 'This device',
        'last_active' => 'Last active :time',
        'action' => 'Log Out Other Browser Sessions',
        'confirm_message' => 'Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.',
        'password_placeholder' => 'Password',
    ],
    'delete_account' => [
        'title' => 'Delete Account',
        'description' => 'Permanently delete your account.',
        'warning' => 'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.',
        'confirm_message' => 'Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.',
        'password_placeholder' => 'Password',
        'action' => 'Delete Account',
    ],
];
