<?php

return [
    // Messages de validation
    'validation' => [
        'escort_ids_required' => 'Les identifiants d\'escortes sont requis.',
        'escort_ids_array' => 'Les identifiants d\'escortes doivent être un tableau.',
        'escort_ids_integer' => 'Chaque identifiant d\'escorte doit être un nombre entier.',
        'escort_ids_exists' => 'Un ou plusieurs identifiants d\'escortes sont invalides.',
    ],
    
    // Messages d'erreur
    'errors' => [
        'login_required' => 'Vous devez être connecté pour effectuer cette action.',
        'unauthorized' => 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.',
        'not_found' => 'Ressource non trouvée.',
        'escort_not_found' => 'Escorte non trouvée ou non associée à votre salon.',
        'salon_not_found' => 'Salon non trouvé ou non associé à votre compte.',
        'invitation_not_found' => 'Aucune invitation trouvée.',
        'no_escorts_selected' => 'Aucune escorte sélectionnée.',
        'invalid_escort_type' => 'Seuls les utilisateurs avec un profil "escorte" peuvent être invités.',
        'invalid_salon_type' => 'Seuls les utilisateurs avec un profil "salon" peuvent être invités.',
        'authentication_failed' => 'Échec de l\'authentification.',
    ],
    
    // Messages de succès
    'success' => [
        'invitation_sent' => 'Votre demande d\'invitation a été envoyée avec succès !',
        'invitation_accepted' => 'Invitation acceptée avec succès.',
        'invitation_rejected' => 'Invitation refusée avec succès.',
        'invitation_cancelled' => 'Invitation annulée avec succès.',
        'escort_managed' => 'Vous êtes maintenant connecté en tant que :name',
        'escort_autonomized' => 'L\'escorte a été autonomisée avec succès.',
        'escort_deleted' => 'L\'escorte a été supprimée avec succès.',
        'escort_made_autonomous' => 'L\'escorte est maintenant autonome.',
        'returned_to_salon' => 'Vous êtes maintenant connecté en tant que :name',
        'relation_deleted' => 'La relation avec l\'escorte a été supprimée avec succès.',
    ],
];
