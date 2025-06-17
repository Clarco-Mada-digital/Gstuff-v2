<?php

return [
    'validation' => [
        'pseudo_required' => 'The username is required.',
        'pseudo_string' => 'The username must be a string.',
        'pseudo_max' => 'The username may not be greater than :max characters.',
        'prenom_required' => 'The first name is required.',
        'prenom_string' => 'The first name must be a string.',
        'prenom_max' => 'The first name may not be greater than :max characters.',
        'email_required' => 'The email address is required.',
        'email_email' => 'The email must be a valid email address.',
        'email_unique' => 'The email has already been taken.',
        'password_required' => 'The password is required.',
        'password_string' => 'The password must be a string.',
        'password_min' => 'The password must be at least :min characters.',
        'date_naissance_required' => 'The birth date is required.',
        'date_naissance_date' => 'The birth date is not a valid date.',
        'profile_type_required' => 'The profile type is required.',
        'profile_type_in' => 'The selected profile type is invalid.',
    ],
    'success' => [
        'user_created' => 'User created successfully.',
        'user_updated' => 'User updated successfully.',
        'user_deleted' => 'User deleted successfully.',
    ],
    'error' => [
        'user_not_found' => 'User not found.',
    ],
    'online' => 'Online',
    'never_connected' => 'Never connected',
    'just_now' => 'Just now',
    'minutes_ago' => ':count min ago',
    'hours_ago' => ':count h ago',
    'days_ago' => ':count days ago'
];
