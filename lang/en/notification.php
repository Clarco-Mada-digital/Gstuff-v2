<?php

return [
    'notifications' => 'Notifications',
    'no_notifications' => 'No notifications',
    'view_all' => 'View all',
    'validation' => [
        'user_id_required' => 'User ID is required.',
        'user_id_numeric' => 'User ID must be a number.',
    ],
    'errors' => [
        'unauthorized' => 'You must be logged in as an administrator to perform this operation.',
        'invalid_user_id' => 'Invalid user ID.',
        'user_not_found' => 'User not found.',
    ],
    'success' => [
        'notification_deleted' => 'The notification has been deleted and the user status has been updated successfully.'
    ],
    'profileCompletion' => [
        'title' => 'Profile completed at :percent%',
        'message' => 'You have completed your profile at :percent%. To better enjoy our services, it\'s best to complete your profile as much as possible.'
    ],
    'escortInvitation' => [
        'title' => 'New invitation',
        'message' => 'You have been invited by :inviter_name.'
    ],
    'profileVerificationRequest' => [
        'title' => 'New profile verification request',
        'message' => 'User :user_name has submitted a profile verification request.'
    ]
];
