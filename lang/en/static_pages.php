<?php

return [
    // Interface
    'static_pages' => 'Static Pages',
    'edit_static_page' => 'Edit Page',
    'back' => 'Back',
    'new_page' => 'New Page',
    'title' => 'Title',
    'content' => 'Content',
    'meta_title' => 'Meta Title',
    'meta_description' => 'Meta Description',
    'cancel' => 'Cancel',
    'delete' => 'Delete',
    'save' => 'Save',
    'slug' => 'Slug',
    'actions' => 'Actions',
    'edit' => 'Edit',
    'language' => 'Language',
    'select_language' => 'Select language',
    
    // Success messages
    'created' => 'Page created successfully',
    'updated' => 'Page updated successfully',
    'deleted' => 'Page deleted successfully',
    
    // Error messages
    'not_found' => 'Page not found',
    'delete_error' => 'An error occurred while deleting the page',
    'update_error' => 'An error occurred while updating the page',
    'create_error' => 'An error occurred while creating the page',
    
    // Validation
    'validation' => [
        'slug_required' => 'The slug is required',
        'slug_unique' => 'This slug is already in use',
        'slug_alpha_dash' => 'The slug may only contain letters, numbers, dashes and underscores',
        'title_required' => 'The title is required',
        'title_max' => 'The title may not be greater than :max characters',
        'content_required' => 'The content is required',
        'meta_title_max' => 'The meta title may not be greater than :max characters',
        'meta_description_max' => 'The meta description may not be greater than :max characters',
        'lang_required' => 'The language is required',
        'lang_in' => 'Unsupported language',
    ],

    'deleted_successfully' => 'Page deleted successfully',
    'delete_error' => 'An error occurred while deleting the page',
    'confirm_delete' => 'Confirm Deletion',
    'delete_confirmation_message' => 'Are you sure you want to delete this page?'
];