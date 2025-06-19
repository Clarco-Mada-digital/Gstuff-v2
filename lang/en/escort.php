<?php

return [
    // Validation messages
    'validation' => [
        'escort_ids_required' => 'Escort IDs are required.',
        'escort_ids_array' => 'Escort IDs must be an array.',
        'escort_ids_integer' => 'Each escort ID must be an integer.',
        'escort_ids_exists' => 'One or more escort IDs are invalid.',
    ],
    
    // Error messages
    'errors' => [
        'login_required' => 'You must be logged in to perform this action.',
        'unauthorized' => 'You do not have permission to perform this action.',
        'not_found' => 'Resource not found.',
        'escort_not_found' => 'Escort not found or not associated with your salon.',
        'salon_not_found' => 'Salon not found or not associated with your account.',
        'invitation_not_found' => 'No invitation found.',
        'no_escorts_selected' => 'No escorts selected.',
        'invalid_escort_type' => 'Only users with "escort" profile can be invited.',
        'invalid_salon_type' => 'Only users with "salon" profile can be invited.',
        'authentication_failed' => 'Authentication failed.',
    ],
    
    // Success messages
    'success' => [
        'invitation_sent' => 'Your invitation has been sent successfully!',
        'invitation_accepted' => 'Invitation accepted successfully.',
        'invitation_rejected' => 'Invitation rejected successfully.',
        'invitation_cancelled' => 'Invitation cancelled successfully.',
        'escort_managed' => 'You are now logged in as :name',
        'escort_autonomized' => 'The escort has been made autonomous successfully.',
        'escort_deleted' => 'The escort has been deleted successfully.',
        'escort_made_autonomous' => 'The escort is now autonomous.',
        'returned_to_salon' => 'You are now logged in as :name',
        'relation_deleted' => 'The relationship with the escort has been successfully deleted.',
    ],
];
