<?php

return [
    // Erfolgsmeldungen
    'role_created' => 'Rolle erfolgreich erstellt',
    'role_updated' => 'Rolle erfolgreich aktualisiert',
    'role_deleted' => 'Rolle erfolgreich gelöscht',
    'permissions_updated' => 'Berechtigungen erfolgreich aktualisiert',
    
    // Fehlermeldungen
    'admin_role_protected' => 'Diese Rolle ist geschützt und kann nicht geändert werden',
    'delete_admin_denied' => 'Administratorrolle kann nicht gelöscht werden',
    'delete_self_denied' => 'Sie können Ihre eigene Rolle nicht löschen',
    'role_not_found' => 'Rolle nicht gefunden',
    
    // Validierung
    'validation' => [
        'name_required' => 'Rollenname ist erforderlich',
        'name_unique' => 'Dieser Rollenname ist bereits vergeben',
        'name_max' => 'Der Rollenname darf nicht länger als :max Zeichen sein',
        'permissions_array' => 'Die Berechtigungen müssen ein Array sein',
        'permissions_exists' => 'Eine oder mehrere ausgewählte Berechtigungen sind ungültig',
    ],
];
