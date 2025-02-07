<?php

declare(strict_types=1);

return [
    'register' => [
        'terms' => 'I agree to the :terms_of_service and :privacy_policy.',
        'already_registered' => 'Already registered?',
        'fields' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'password_confirmation' => 'Password confirmation',
        ],
        'actions' => [
            'register' => 'Register',
        ],
    ],
    'login' => [
        'fields' => [
            'email' => 'Email',
            'password' => 'Password',
        ],
        'remember' => 'Remember me',
        'forgot_password' => 'Forgot your password?',
        'actions' => [
            'login' => 'Log in',
        ],
    ],
    'confirm_password' => [
        'description' => 'This is a secure area of the application. Please confirm your password before continuing.',
        'fields' => [
            'password' => 'Password',
        ],
        'actions' => [
            'confirm' => 'Confirm',
        ],
    ],
    'forgot_password' => [
        'description' => 'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.',
        'fields' => [
            'email' => 'Email',
        ],
        'actions' => [
            'send' => 'Send Password Reset Link',
        ],
    ],
    'reset_password' => [
        'fields' => [
            'email' => 'Emaol',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
        ],
        'actions' => [
            'reset' => 'Reset Password',
        ],
    ],
    'two_factor_challenge' => [
        'confirm_authentication_code' => 'Please confirm access to your account by entering the authentication code provided by your authenticator application.',
        'confirm_recovery_code' => 'Please confirm access to your account by entering one of your emergency recovery codes.',
        'fields' => [
            'code' => 'Code',
            'recovery_code' => 'Recovery Code',
        ],
        'actions' => [
            'use_recovery_code' => 'Use a recovery code',
            'use_authentication_code' => 'Use an authentication code',
            'log_in' => 'Log in',
        ],
    ],
    'verify_email' => [
        'description' => 'Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.',
        'edit_profile' => 'Edit profile',
        'flash_messages' => [
            'resent' => 'A new verification link has been sent to the email address you provided in your profile settings.',
        ],
        'actions' => [
            'resend' => 'Resend Verification Email',
            'log_out' => 'Log Out',
        ],
    ],
];
