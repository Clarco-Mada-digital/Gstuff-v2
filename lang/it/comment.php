<?php

return [
    // Validazione
    'content' => [
        'required' => 'Il contenuto del commento è obbligatorio.',
        'string' => 'Il contenuto deve essere una stringa.',
        'max' => 'Il commento non può superare i :max caratteri.',
    ],
    'lang' => [
        'required' => 'La lingua è obbligatoria.',
        'in' => 'La lingua selezionata non è valida.',
    ],
    
    // Messaggi di successo
    'stored' => 'Commento inviato con successo.',
    'approved' => 'Commento approvato con successo.',
    'deleted' => 'Commento eliminato con successo.',
    'marked_as_read' => 'Commento segnato come letto.',
    
    // Messaggi di errore
    'login_required' => 'Devi effettuare l\'accesso per eseguire questa azione.',
    'admin_required' => 'Devi essere un amministratore per eseguire questa azione.',
    'not_found' => 'Commento non trovato.',
    'store_error' => 'Si è verificato un errore durante l\'invio del commento.',
    'approve_error' => 'Si è verificato un errore durante l\'approvazione del commento.',
    'delete_error' => 'Si è verificato un errore durante l\'eliminazione del commento.',
];
