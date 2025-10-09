<?php

return [
    // Messages de succès
    'role_created' => 'Rôle créé avec succès',
    'role_updated' => 'Rôle mis à jour avec succès',
    'role_deleted' => 'Rôle supprimé avec succès',
    'permissions_updated' => 'Permissions mises à jour avec succès',
    
    // Messages d'erreur
    'admin_role_protected' => 'Ce rôle est protégé et ne peut pas être modifié',
    'delete_admin_denied' => 'Impossible de supprimer le rôle administrateur',
    'delete_self_denied' => 'Vous ne pouvez pas supprimer votre propre rôle',
    'role_not_found' => 'Rôle non trouvé',
    
    // Validation
    'validation' => [
        'name_required' => 'Le nom du rôle est requis',
        'name_unique' => 'Ce nom de rôle est déjà utilisé',
        'name_max' => 'Le nom du rôle ne peut pas dépasser :max caractères',
        'permissions_array' => 'Les permissions doivent être un tableau',
        'permissions_exists' => 'Une ou plusieurs permissions sélectionnées sont invalides',
    ],
];
