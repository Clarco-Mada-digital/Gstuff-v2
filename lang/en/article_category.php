<?php

return [
    // Validation
    'name' => [
        'required' => 'The category name is required.',
        'max' => 'The name may not be greater than :max characters.',
        'unique' => 'This category name is already in use.',
    ],
    'description' => [
        'string' => 'The description must be a string.',
    ],
    
    // Success messages
    'stored' => 'Category created successfully.',
    'updated' => 'Category updated successfully.',
    'deleted' => 'Category deleted successfully.',
    
    // Error messages
    'delete_error' => 'An error occurred while deleting the category.',
];
