<?php

return [
    'contenuPrivate' => 'Contenu privé',


    'failed' => 'Ces identifiants ne correspondent pas à nos enregistrements.',
    'password' => 'Le mot de passe fourni est incorrect.',
    'throttle' => 'Trop de tentatives de connexion. Veuillez réessayer dans :seconds secondes.',
    
    // Registration
    'registration' => [
        'success' => 'Inscription réussie ! Bienvenue.',
        'validation_error' => 'Problème de validation',
        'email_exists' => 'Cet email est déjà utilisé',
        'invalid_role' => 'Rôle invalide',
    ],
    
    // Login
    'login' => [
        'success' => 'Connexion réussie !',
        'failed' => 'Identifiants incorrects',
        'salon_managed' => 'Votre compte est actuellement géré par un salon. Veuillez contacter l\'administration.',
        'inactive' => 'Votre compte est inactif. Veuillez contacter l\'administration.',
        'suspended' => 'Votre compte a été suspendu. Veuillez contacter l\'administration.',
    ],
    
    // Password Reset
    'password' => [
        'reset' => 'Votre mot de passe a été réinitialisé !',
        'sent' => 'Nous avons envoyé un lien de réinitialisation à votre adresse email !',
        'throttled' => 'Veuillez patienter avant de réessayer.',
        'token' => 'Ce jeton de réinitialisation est invalide.',
        'user' => 'Aucun utilisateur trouvé avec cette adresse email.',
        'reset_password' => 'Réinitialiser le mot de passe',
        'reset_password_instructions' => 'Entrez votre nouveau mot de passe pour réinitialiser votre compte.',
        'email' => 'Adresse email',
        'password' => 'Nouveau mot de passe',
        'confirm_password' => 'Confirmer le mot de passe',
        'reset_password_button' => 'Réinitialiser le mot de passe',
        'user_not_found' => 'Aucun utilisateur trouvé avec cette adresse email.',
        'reset_link_sent' => 'Un lien de réinitialisation a été envoyé à votre adresse email.',
        'invalid_token' => 'Token de réinitialisation invalide ou expiré.',
        'password_reset_success' => 'Votre mot de passe a été réinitialisé avec succès !',
    ],
    
    // Email Verification
    'verification' => [
        'sent' => 'Un nouveau lien de vérification a été envoyé à votre adresse email.',
        'verify' => 'Veuillez vérifier votre adresse email en cliquant sur le lien envoyé.',
        'request_another' => 'Un nouveau lien de vérification a été envoyé à votre adresse email.',
    ],
    
    // Logout
    'logout_success' => 'Déconnexion réussie.',
    
    // Password Reset
    'reset_link_sent' => 'Un lien de réinitialisation de mot de passe a été envoyé à votre adresse email.',
    'invalid_token' => 'Token de réinitialisation invalide ou expiré.',
    'email_not_found' => 'Aucun utilisateur trouvé avec cette adresse email.',
];
