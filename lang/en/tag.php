<?php

return [
    'validation' => [
        'name_required' => 'The tag name is required.',
        'name_string' => 'The name must be a string.',
        'name_max' => 'The name may not be greater than :max characters.',
        'name_unique' => 'This tag name is already in use.',
    ],
    'success' => [
        'tag_created' => 'Tag created successfully.',
        'tag_updated' => 'Tag updated successfully.',
        'tag_deleted' => 'Tag deleted successfully.',
    ],
    'error' => [
        'tag_not_found' => 'Tag not found.',
    ]
];
