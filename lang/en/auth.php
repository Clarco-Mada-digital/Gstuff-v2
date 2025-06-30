<?php

return [
    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    
    // Registration
    'registration' => [
        'success' => 'Registration successful! Welcome.',
        'validation_error' => 'Validation error',
        'email_exists' => 'This email is already in use',
        'invalid_role' => 'Invalid role',
    ],
    
    // Login
    'login' => [
        'success' => 'Login successful!',
        'failed' => 'These credentials do not match our records.',
        'salon_managed' => 'Your account is currently managed by a salon. Please contact the administration.',
        'inactive' => 'Your account is inactive. Please contact the administration.',
        'suspended' => 'Your account has been suspended. Please contact the administration.',
    ],
    
    // Password Reset
    'password' => [
        'reset' => 'Your password has been reset!',
        'sent' => 'We have emailed your password reset link!',
        'throttled' => 'Please wait before retrying.',
        'token' => 'This password reset token is invalid.',
        'user' => 'We can\'t find a user with that email address.',
    ],
    
    // Email Verification
    'verification' => [
        'sent' => 'A fresh verification link has been sent to your email address.',
        'verify' => 'Before continuing, please check your email for a verification link.',
        'request_another' => 'A fresh verification link has been sent to your email address.',
    ],
    
    // Logout
    'logout_success' => 'Successfully logged out.',
    
    // Password Reset
    'reset_link_sent' => 'A password reset link has been sent to your email address.',
    'invalid_token' => 'Invalid or expired reset token.',
    'email_not_found' => 'We can\'t find a user with that email address.',
];
