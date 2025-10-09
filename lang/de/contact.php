<?php

return [
    // Titres et libellés
    'page_title' => 'Kontakt',
    'contact_us' => 'Kontaktieren Sie uns',
    'make_comment' => 'Kommentar abgeben',
    'need_info' => 'Brauchen Sie Informationen oder Beratung? Kontaktieren Sie uns jetzt!',
    'comment' => 'Kommentar',
    'message_placeholder' => 'Nachricht',
    'send' => 'Senden',
    'name' => 'Name',
    'name_placeholder' => 'Ihr Name',
    'email' => 'E-Mail',
    'email_placeholder' => 'ihre@email.de',
    'subject' => 'Betreff',
    'subject_placeholder' => 'Betreff Ihrer Nachricht',
    'message' => 'Nachricht',
    'message_placeholder' => 'Ihre Nachricht...',
    
    // Messages de succès/erreur
    'success' => [
        'message_sent' => 'Ihre Nachricht wurde erfolgreich gesendet!',
    ],
    'errors' => [
        'sending_failed' => 'Beim Senden Ihrer Nachricht ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut.',
    ],
    
    // Messages de validation
    'validation' => [
        'name' => [
            'required' => 'Der Name ist erforderlich',
            'string' => 'Der Name muss eine Zeichenkette sein',
            'max' => 'Der Name darf nicht länger als :max Zeichen sein',
        ],
        'email' => [
            'required' => 'Die E-Mail-Adresse ist erforderlich',
            'email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein',
            'max' => 'Die E-Mail-Adresse darf nicht länger als :max Zeichen sein',
        ],
        'subject' => [
            'required' => 'Der Betreff ist erforderlich',
            'string' => 'Der Betreff muss eine Zeichenkette sein',
            'max' => 'Der Betreff darf nicht länger als :max Zeichen sein',
        ],
        'message' => [
            'required' => 'Die Nachricht ist erforderlich',
            'string' => 'Die Nachricht muss eine Zeichenkette sein',
            'max' => 'Die Nachricht darf nicht länger als :max Zeichen sein',
        ],
    ],
];
