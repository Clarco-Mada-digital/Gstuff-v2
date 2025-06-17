<?php

return [
    'profile_type' => [
        'required' => 'Le type de profil est requis.',
        'in' => 'Le type de profil sélectionné est invalide.',
    ],
    'email' => [
        'required' => 'L\'adresse email est requise.',
        'email' => 'L\'adresse email doit être une adresse valide.',
        'unique' => 'Cette adresse email est déjà utilisée.',
    ],
    'password' => [
        'required' => 'Le mot de passe est requis.',
        'confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        'min' => 'Le mot de passe doit contenir au moins :min caractères.',
    ],
    'date_naissance' => [
        'required' => 'La date de naissance est requise.',
        'date' => 'La date de naissance doit être une date valide.',
        'before' => 'Vous devez avoir au moins 18 ans pour vous inscrire.',
    ],
    'cgu_accepted' => [
        'accepted' => 'Vous devez accepter les conditions générales d\'utilisation.',
    ],
    'pseudo' => [
        'required_if' => 'Le pseudo est requis pour un profil invité.',
        'string' => 'Le pseudo doit être une chaîne de caractères.',
        'max' => 'Le pseudo ne peut pas dépasser :max caractères.',
    ],
    'prenom' => [
        'required_if' => 'Le prénom est requis pour un profil escort.',
        'string' => 'Le prénom doit être une chaîne de caractères.',
        'max' => 'Le prénom ne peut pas dépasser :max caractères.',
    ],
    'genre_id' => [
        'required_if' => 'Le genre est requis pour un profil escort.',
        'exists' => 'Le genre sélectionné est invalide.',
    ],
    'nom_salon' => [
        'required_if' => 'Le nom du salon est requis pour un profil salon.',
        'string' => 'Le nom du salon doit être une chaîne de caractères.',
        'max' => 'Le nom du salon ne peut pas dépasser :max caractères.',
    ],
    'intitule' => [
        'required_if' => 'La civilité est requise pour un profil salon.',
        'in' => 'La civilité sélectionnée est invalide.',
    ],
    'nom_proprietaire' => [
        'required_if' => 'Le nom du propriétaire est requis pour un profil salon.',
        'string' => 'Le nom du propriétaire doit être une chaîne de caractères.',
        'max' => 'Le nom du propriétaire ne peut pas dépasser :max caractères.',
    ],
];
