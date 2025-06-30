<?php

return [
    // Titoli ed etichette
    'page_title' => 'Contatto',
    'contact_us' => 'Contattaci',
    'make_comment' => 'Lascia un commento',
    'need_info' => 'Hai bisogno di informazioni o consigli? Contattaci subito!',
    'comment' => 'Commento',
    'message_placeholder' => 'Messaggio',
    'send' => 'Invia',
    'name' => 'Nome',
    'name_placeholder' => 'Il tuo nome',
    'email' => 'Email',
    'email_placeholder' => 'tua@email.it',
    'subject' => 'Oggetto',
    'subject_placeholder' => 'Oggetto del messaggio',
    'message' => 'Messaggio',
    'message_placeholder' => 'Il tuo messaggio...',
    
    // Messaggi di successo/errore
    'success' => [
        'message_sent' => 'Il tuo messaggio è stato inviato con successo!',
    ],
    'errors' => [
        'sending_failed' => 'Si è verificato un errore durante l\'invio del messaggio. Riprova più tardi.',
    ],
    
    // Messaggi di validazione
    'validation' => [
        'name' => [
            'required' => 'Il nome è obbligatorio',
            'string' => 'Il nome deve essere una stringa',
            'max' => 'Il nome non può superare i :max caratteri',
        ],
        'email' => [
            'required' => 'L\'indirizzo email è obbligatorio',
            'email' => 'Inserisci un indirizzo email valido',
            'max' => 'L\'email non può superare i :max caratteri',
        ],
        'subject' => [
            'required' => 'L\'oggetto è obbligatorio',
            'string' => 'L\'oggetto deve essere una stringa',
            'max' => 'L\'oggetto non può superare i :max caratteri',
        ],
        'message' => [
            'required' => 'Il messaggio è obbligatorio',
            'string' => 'Il messaggio deve essere una stringa',
            'max' => 'Il messaggio non può superare i :max caratteri',
        ],
    ],
];
