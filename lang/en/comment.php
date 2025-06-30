<?php

return [
    // Validation
    'content' => [
        'required' => 'The comment content is required.',
        'string' => 'The content must be a string.',
        'max' => 'The comment may not be greater than :max characters.',
    ],
    'lang' => [
        'required' => 'The language field is required.',
        'in' => 'The selected language is invalid.',
    ],
    
    // Success messages
    'stored' => 'Comment submitted successfully.',
    'approved' => 'Comment approved successfully.',
    'deleted' => 'Comment deleted successfully.',
    'marked_as_read' => 'Comment marked as read.',
    
    // Error messages
    'login_required' => 'You must be logged in to perform this action.',
    'admin_required' => 'You must be an administrator to perform this action.',
    'not_found' => 'Comment not found.',
    'store_error' => 'An error occurred while submitting the comment.',
    'approve_error' => 'An error occurred while approving the comment.',
    'delete_error' => 'An error occurred while deleting the comment.',
];
