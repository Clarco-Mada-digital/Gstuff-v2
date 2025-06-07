<?php

return [
    'validation' => [
        'pseudo_required' => 'Le pseudo est requis.',
        'pseudo_string' => 'Le pseudo doit être une chaîne de caractères.',
        'pseudo_max' => 'Le pseudo ne peut pas dépasser :max caractères.',
        'prenom_required' => 'Le prénom est requis.',
        'prenom_string' => 'Le prénom doit être une chaîne de caractères.',
        'prenom_max' => 'Le prénom ne peut pas dépasser :max caractères.',
        'email_required' => 'L\'adresse email est requise.',
        'email_email' => 'L\'adresse email doit être valide.',
        'email_unique' => 'Cette adresse email est déjà utilisée.',
        'password_required' => 'Le mot de passe est requis.',
        'password_string' => 'Le mot de passe doit être une chaîne de caractères.',
        'password_min' => 'Le mot de passe doit contenir au moins :min caractères.',
        'date_naissance_required' => 'La date de naissance est requise.',
        'date_naissance_date' => 'La date de naissance doit être une date valide.',
        'profile_type_required' => 'Le type de profil est requis.',
        'profile_type_in' => 'Le type de profil sélectionné est invalide.',
    ],
    'success' => [
        'user_created' => 'Utilisateur créé avec succès.',
        'user_updated' => 'Utilisateur mis à jour avec succès.',
        'user_deleted' => 'Utilisateur supprimé avec succès.',
    ],
    'error' => [
        'user_not_found' => 'Utilisateur non trouvé.',
    ]
];
