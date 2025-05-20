<?php

return [
    // Validierungsmeldungen
    'validation' => [
        'escort_ids_required' => 'Escort-IDs sind erforderlich.',
        'escort_ids_array' => 'Escort-IDs müssen ein Array sein.',
        'escort_ids_integer' => 'Jede Escort-ID muss eine Ganzzahl sein.',
        'escort_ids_exists' => 'Eine oder mehrere Escort-IDs sind ungültig.',
    ],
    
    // Fehlermeldungen
    'errors' => [
        'login_required' => 'Sie müssen angemeldet sein, um diese Aktion auszuführen.',
        'unauthorized' => 'Sie haben keine Berechtigung, diese Aktion auszuführen.',
        'not_found' => 'Ressource nicht gefunden.',
        'escort_not_found' => 'Escort nicht gefunden oder nicht mit Ihrem Salon verknüpft.',
        'salon_not_found' => 'Salon nicht gefunden oder nicht mit Ihrem Konto verknüpft.',
        'invitation_not_found' => 'Keine Einladung gefunden.',
        'no_escorts_selected' => 'Keine Escorts ausgewählt.',
        'invalid_escort_type' => 'Nur Benutzer mit dem Profil "Escort" können eingeladen werden.',
        'invalid_salon_type' => 'Nur Benutzer mit dem Profil "Salon" können eingeladen werden.',
        'authentication_failed' => 'Authentifizierung fehlgeschlagen.',
    ],
    
    // Erfolgsmeldungen
    'success' => [
        'invitation_sent' => 'Ihre Einladung wurde erfolgreich versendet!',
        'invitation_accepted' => 'Einladung erfolgreich angenommen.',
        'invitation_rejected' => 'Einladung erfolgreich abgelehnt.',
        'invitation_cancelled' => 'Einladung erfolgreich storniert.',
        'escort_managed' => 'Sie sind jetzt angemeldet als :name',
        'escort_autonomized' => 'Die Escort wurde erfolgreich autonomisiert.',
        'escort_deleted' => 'Die Escort wurde erfolgreich gelöscht.',
        'escort_made_autonomous' => 'Die Escort ist jetzt eigenständig.',
        'returned_to_salon' => 'Sie sind jetzt angemeldet als :name',
    ],
];
