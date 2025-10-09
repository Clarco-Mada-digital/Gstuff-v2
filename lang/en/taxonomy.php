<?php

return [
    // Interface
    'taxonomy_management' => 'Taxonomy Management',
    'new_category' => '+ New Category',
    'new_tag' => '+ New Tag',
    'categories' => 'Categories',
    'tags' => 'Tags',
    'name' => 'Name',
    'articles' => 'Articles',
    'actions' => 'Actions',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'confirm_delete' => 'Confirm Deletion',
    'confirm_delete_message' => 'Are you sure you want to delete',
    'category' => 'this category',
    'tag' => 'this tag',
    'irreversible_action' => '? This action is irreversible.',
    'delete_button' => 'Delete',
    'cancel_button' => 'Cancel',
    'save_button' => 'Save',
    'category_name' => 'Name',
    'category_description' => 'Description',
    'tag_name' => 'Tag name',
    'edit_category' => 'Edit Category',
    'create_category' => 'Create Category',
    'edit_tag' => 'Edit Tag',
    'create_tag' => 'Create Tag',
    'no_categories_found' => 'No categories found',
    'no_tags_found' => 'No tags found',
    'status' => 'Status',
    'active' => 'Active',
    'inactive' => 'Inactive',
    'toggle_status' => 'Toggle Status',
    
    // Success messages
    'category_created' => 'Category created successfully',
    'category_updated' => 'Category updated successfully',
    'category_deleted' => 'Category deleted successfully',
    'tag_created' => 'Tag created successfully',
    'tag_updated' => 'Tag updated successfully',
    'tag_deleted' => 'Tag deleted successfully',
    'status_updated' => 'Status updated successfully',
    
    // Error messages
    'category_not_found' => 'Category not found',
    'tag_not_found' => 'Tag not found',
    'delete_error' => 'An error occurred while deleting',
    'update_error' => 'An error occurred while updating',
    'create_error' => 'An error occurred while creating',
    
    // Validation
    'validation' => [
        'name_required' => 'The name field is required',
        'name_max' => 'The name may not be greater than :max characters',
        'name_unique' => 'The name has already been taken',
        'name_exists' => 'A category with this name already exists',
        'description_string' => 'The description must be a string',
        'id_required' => 'The ID is required',
        'id_exists' => 'The specified ID does not exist',
        'lang_required' => 'The language field is required',
        'lang_in' => 'The selected language is invalid',
    ],
    
    // Form fields
    'fields' => [
        'name' => 'name',
        'description' => 'description',
        'language' => 'language',
    ],
];
