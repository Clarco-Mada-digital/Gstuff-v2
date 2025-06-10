<?php

return [
    // Validation
    'content' => [
        'required' => 'Le contenu du commentaire est requis.',
        'string' => 'Le contenu doit être une chaîne de caractères.',
        'max' => 'Le commentaire ne peut pas dépasser :max caractères.',
    ],
    'lang' => [
        'required' => 'La langue est requise.',
        'in' => 'La langue sélectionnée n\'est pas valide.',
    ],
    
    // Messages de succès
    'stored' => 'Commentaire envoyé avec succès.',
    'approved' => 'Commentaire approuvé avec succès.',
    'deleted' => 'Commentaire supprimé avec succès.',
    'marked_as_read' => 'Commentaire marqué comme lu.',
    
    // Messages d'erreur
    'login_required' => 'Vous devez être connecté pour effectuer cette action.',
    'admin_required' => 'Vous devez être administrateur pour effectuer cette action.',
    'not_found' => 'Commentaire non trouvé.',
    'store_error' => 'Une erreur est survenue lors de l\'envoi du commentaire.',
    'approve_error' => 'Une erreur est survenue lors de l\'approbation du commentaire.',
    'delete_error' => 'Une erreur est survenue lors de la suppression du commentaire.',
];
