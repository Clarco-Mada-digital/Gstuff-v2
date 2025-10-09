<?php

return [
    'validation' => [
        'visibility_required' => 'Le champ visibilité est requis.',
        'visibility_in' => 'La visibilité sélectionnée est invalide.',
        'countries_required_if' => 'Le champ pays est requis lorsque la visibilité est personnalisée.',
        'countries_array' => 'Les pays doivent être un tableau.',
        'countries_*_string' => 'Chaque pays doit être une chaîne de caractères.',
        'countries_*_size' => 'Chaque code pays doit contenir 2 caractères.',
    ],
    'success' => [
        'visibility_updated' => 'Paramètres de visibilité mis à jour avec succès.',
        'visibility_reset' => 'Paramètres de visibilité réinitialisés avec succès.',
    ],
    'title' => 'Paramètres de visibilité du profil',
    'profile_visibility' => '🌍 Visibilité du profil',
    'public' => [
        'label' => 'Profil public',
        'description' => 'Visible dans tous les pays sans restriction'
    ],
    'private' => [
        'label' => 'Profil privé',
        'description' => 'Caché dans tous les pays'
    ],
    'custom' => [
        'label' => 'Visibilité personnalisée',
        'description' => 'Choisissez les pays où votre profil sera visible'
    ],
    'country_selector' => [
        'title' => 'Sélection des pays autorisés',
        'description' => 'Sélectionnez un ou plusieurs pays dans la liste ci-dessous',
        'placeholder' => 'Rechercher un pays...',
        'country' => 'Pays',
        'selected' => 'Sélectionné',
        'remove' => 'Supprimer',
        'highlight' => 'Sélectionné'
    ],
    'save' => 'Enregistrer les modifications',
    'back' => 'Retour'
];