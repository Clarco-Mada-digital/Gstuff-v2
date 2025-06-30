<?php

return [
    // Validation
    'title' => [
        'required' => 'The title field is required.',
        'max' => 'The title may not be greater than :max characters.',
        'unique' => 'The title has already been taken.',
    ],
    'slug' => [
        'required' => 'The slug field is required.',
        'max' => 'The slug may not be greater than :max characters.',
        'unique' => 'The slug has already been taken.',
    ],
    'content' => [
        'required' => 'The content field is required.',
    ],
    'article_category_id' => [
        'required' => 'The category field is required.',
        'exists' => 'The selected category is invalid.',
    ],
    'article_user_id' => [
        'required' => 'The author field is required.',
        'exists' => 'The selected author is invalid.',
    ],
    'tags' => [
        'array' => 'The tags must be an array.',
        'exists' => 'One or more selected tags are invalid.',
    ],
    'is_published' => [
        'boolean' => 'The published field must be true or false.',
    ],
    'published_at' => [
        'date' => 'The published at must be a valid date.',
        'after_or_equal' => 'The published at must be a date after or equal to today.',
    ],
    
    // Success messages
    'stored' => 'Article created successfully.',
    'updated' => 'Article updated successfully.',
    'deleted' => 'Article permanently deleted.',
    'published' => 'Article published successfully.',
    'unpublished' => 'Article unpublished successfully.',
    
    // Error messages
    'not_found' => 'Article not found.',
    'unauthorized' => 'You are not authorized to edit this article.',
    'store_error' => 'An error occurred while creating the article.',
    'update_error' => 'An error occurred while updating the article.',
    'delete_error' => 'An error occurred while deleting the article.',
];
