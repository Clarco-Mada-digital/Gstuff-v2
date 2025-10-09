<?php

return [
    // Validation
    'title' => [
        'required' => 'Le titre est requis.',
        'max' => 'Le titre ne peut pas dépasser :max caractères.',
        'unique' => 'Ce titre est déjà utilisé.',
    ],
    'slug' => [
        'required' => 'Le slug est requis.',
        'max' => 'Le slug ne peut pas dépasser :max caractères.',
        'unique' => 'Ce slug est déjà utilisé.',
    ],
    'content' => [
        'required' => 'Le contenu est requis.',
    ],
    'article_category_id' => [
        'required' => 'La catégorie est requise.',
        'exists' => 'La catégorie sélectionnée est invalide.',
    ],
    'article_user_id' => [
        'required' => 'L\'auteur est requis.',
        'exists' => 'L\'auteur sélectionné est invalide.',
    ],
    'tags' => [
        'array' => 'Les tags doivent être sous forme de tableau.',
        'exists' => 'Un ou plusieurs tags sélectionnés sont invalides.',
    ],
    'is_published' => [
        'boolean' => 'Le champ de publication doit être vrai ou faux.',
    ],
    'published_at' => [
        'date' => 'La date de publication doit être une date valide.',
        'after_or_equal' => 'La date de publication doit être égale ou postérieure à aujourd\'hui.',
    ],
    
    // Messages de succès
    'stored' => 'Article créé avec succès.',
    'updated' => 'Article mis à jour avec succès.',
    'deleted' => 'Article supprimé définitivement.',
    'published' => 'Article publié avec succès.',
    'unpublished' => 'Article retiré de la publication.',
    
    // Messages d'erreur
    'not_found' => 'Article non trouvé.',
    'unauthorized' => 'Vous n\'êtes pas autorisé à modifier cet article.',
    'store_error' => 'Une erreur est survenue lors de la création de l\'article.',
    'update_error' => 'Une erreur est survenue lors de la mise à jour de l\'article.',
    'delete_error' => 'Une erreur est survenue lors de la suppression de l\'article.',
];
