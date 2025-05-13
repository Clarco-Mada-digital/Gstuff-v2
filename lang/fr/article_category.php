<?php

return [
    // Validation
    'name' => [
        'required' => 'Le nom de la catégorie est requis.',
        'max' => 'Le nom ne peut pas dépasser :max caractères.',
        'unique' => 'Ce nom de catégorie est déjà utilisé.',
    ],
    'description' => [
        'string' => 'La description doit être une chaîne de caractères.',
    ],
    
    // Messages de succès
    'stored' => 'Catégorie créée avec succès.',
    'updated' => 'Catégorie mise à jour avec succès.',
    'deleted' => 'Catégorie supprimée avec succès.',
    
    // Messages d'erreur
    'delete_error' => 'Une erreur est survenue lors de la suppression de la catégorie.',
];
