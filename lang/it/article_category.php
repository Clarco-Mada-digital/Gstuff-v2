<?php

return [
    // Validazione
    'name' => [
        'required' => 'Il nome della categoria è obbligatorio.',
        'max' => 'Il nome non può superare i :max caratteri.',
        'unique' => 'Questo nome categoria è già in uso.',
    ],
    'description' => [
        'string' => 'La descrizione deve essere una stringa.',
    ],
    
    // Messaggi di successo
    'stored' => 'Categoria creata con successo.',
    'updated' => 'Categoria aggiornata con successo.',
    'deleted' => 'Categoria eliminata con successo.',
    
    // Messaggi di errore
    'delete_error' => 'Si è verificato un errore durante l\'eliminazione della categoria.',
];
