<?php

return [
    'validation' => [
        'pseudo_required' => 'Il nome utente è obbligatorio.',
        'pseudo_string' => 'Il nome utente deve essere una stringa.',
        'pseudo_max' => 'Il nome utente non può superare i :max caratteri.',
        'prenom_required' => 'Il nome è obbligatorio.',
        'prenom_string' => 'Il nome deve essere una stringa.',
        'prenom_max' => 'Il nome non può superare i :max caratteri.',
        'email_required' => 'L\'indirizzo email è obbligatorio.',
        'email_email' => 'L\'indirizzo email deve essere valido.',
        'email_unique' => 'Questo indirizzo email è già in uso.',
        'password_required' => 'La password è obbligatoria.',
        'password_string' => 'La password deve essere una stringa.',
        'password_min' => 'La password deve contenere almeno :min caratteri.',
        'date_naissance_required' => 'La data di nascita è obbligatoria.',
        'date_naissance_date' => 'La data di nascita non è una data valida.',
        'profile_type_required' => 'Il tipo di profilo è obbligatorio.',
        'profile_type_in' => 'Il tipo di profilo selezionato non è valido.',
    ],
    'success' => [
        'user_created' => 'Utente creato con successo.',
        'user_updated' => 'Utente aggiornato con successo.',
        'user_deleted' => 'Utente eliminato con successo.',
    ],
    'error' => [
        'user_not_found' => 'Utente non trovato.',
    ]
];
