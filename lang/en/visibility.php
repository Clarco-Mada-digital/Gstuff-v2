<?php

return [
    'validation' => [
        'visibility_required' => 'The visibility field is required.',
        'visibility_in' => 'The selected visibility is invalid.',
        'countries_required_if' => 'The countries field is required when visibility is custom.',
        'countries_array' => 'The countries must be an array.',
        'countries_*_string' => 'Each country must be a string.',
        'countries_*_size' => 'Each country code must be 2 characters.',
    ],
    'success' => [
        'visibility_updated' => 'Visibility settings updated successfully.',
        'visibility_reset' => 'Visibility settings reset successfully.',
    ],
    'title' => 'Profile Visibility Settings',
    'profile_visibility' => '🌍 Profile Visibility',
    'public' => [
        'label' => 'Public Profile',
        'description' => 'Visible in all countries without restrictions'
    ],
    'private' => [
        'label' => 'Private Profile',
        'description' => 'Hidden in all countries'
    ],
    'custom' => [
        'label' => 'Custom Visibility',
        'description' => 'Choose the countries where your profile will be visible'
    ],
    'country_selector' => [
        'title' => 'Select Authorized Countries',
        'description' => 'Select one or more countries from the list below',
        'placeholder' => 'Search for a country...',
        'country' => 'Country',
        'selected' => 'Selected',
        'remove' => 'Remove',
        'highlight' => 'Selected'
    ],
    'save' => 'Save Changes',
    'back' => 'Back'
];
