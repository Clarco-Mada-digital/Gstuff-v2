<?php

return [
    // Success messages
    'role_created' => 'Role created successfully',
    'role_updated' => 'Role updated successfully',
    'role_deleted' => 'Role deleted successfully',
    'permissions_updated' => 'Permissions updated successfully',
    
    // Error messages
    'admin_role_protected' => 'This role is protected and cannot be modified',
    'delete_admin_denied' => 'Cannot delete administrator role',
    'delete_self_denied' => 'You cannot delete your own role',
    'role_not_found' => 'Role not found',
    
    // Validation
    'validation' => [
        'name_required' => 'The role name is required',
        'name_unique' => 'This role name is already taken',
        'name_max' => 'The role name may not be greater than :max characters',
        'permissions_array' => 'The permissions must be an array',
        'permissions_exists' => 'One or more selected permissions are invalid',
    ],
];
