<?php

return [
    // Messaggi di successo
    'role_created' => 'Ruolo creato con successo',
    'role_updated' => 'Ruolo aggiornato con successo',
    'role_deleted' => 'Ruolo eliminato con successo',
    'permissions_updated' => 'Permessi aggiornati con successo',
    
    // Messaggi di errore
    'admin_role_protected' => 'Questo ruolo è protetto e non può essere modificato',
    'delete_admin_denied' => 'Impossibile eliminare il ruolo di amministratore',
    'delete_self_denied' => 'Non puoi eliminare il tuo stesso ruolo',
    'role_not_found' => 'Ruolo non trovato',
    
    // Validazione
    'validation' => [
        'name_required' => 'Il nome del ruolo è obbligatorio',
        'name_unique' => 'Questo nome ruolo è già stato utilizzato',
        'name_max' => 'Il nome del ruolo non può superare i :max caratteri',
        'permissions_array' => 'I permessi devono essere un array',
        'permissions_exists' => 'Uno o più permessi selezionati non sono validi',
    ],
];
