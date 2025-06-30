<?php

return [
    // Interface
    'static_pages' => 'Pages Statiques',
    'new_page' => 'Nouvelle page',
    'title' => 'Titre',
    'content' => 'Contenu',
    'meta_title' => 'Meta Title',
    'meta_description' => 'Meta Description',
    'cancel' => 'Annuler',
    'save' => 'Enregistrer',
    'slug' => 'Slug',
    'actions' => 'Actions',
    'edit' => 'Éditer',
    'language' => 'Langue',
    'select_language' => 'Sélectionner la langue',
    
    // Messages de succès
    'created' => 'Page créée avec succès',
    'updated' => 'Page mise à jour avec succès',
    'deleted' => 'Page supprimée avec succès',
    
    // Messages d'erreur
    'not_found' => 'Page non trouvée',
    'delete_error' => 'Une erreur est survenue lors de la suppression de la page',
    'update_error' => 'Une erreur est survenue lors de la mise à jour de la page',
    'create_error' => 'Une erreur est survenue lors de la création de la page',
    
    // Validation
    'validation' => [
        'slug_required' => 'Le slug est requis',
        'slug_unique' => 'Ce slug est déjà utilisé',
        'slug_alpha_dash' => 'Le slug ne peut contenir que des lettres, des chiffres, des tirets et des underscores',
        'title_required' => 'Le titre est requis',
        'title_max' => 'Le titre ne peut pas dépasser :max caractères',
        'content_required' => 'Le contenu est requis',
        'meta_title_max' => 'Le meta titre ne peut pas dépasser :max caractères',
        'meta_description_max' => 'La meta description ne peut pas dépasser :max caractères',
        'lang_required' => 'La langue est requise',
        'lang_in' => 'Langue non supportée',
    ],
];