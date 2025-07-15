<?php

return [
    'failed' => 'Queste credenziali non corrispondono ai nostri record.',
    'password' => 'La password fornita non è corretta.',
    'throttle' => 'Troppi tentativi di accesso. Riprova tra :seconds secondi.',
    
    // Registration
    'registration' => [
        'success' => 'Registrazione completata con successo! Benvenuto.',
        'validation_error' => 'Errore di convalida',
        'email_exists' => 'Questa email è già in uso',
        'invalid_role' => 'Ruolo non valido',
    ],
    
    // Login
    'login' => [
        'success' => 'Accesso effettuato con successo!',
        'failed' => 'Queste credenziali non corrispondono ai nostri record.',
        'salon_managed' => 'Il tuo account è attualmente gestito da un salone. Si prega di contattare l\'amministrazione.',
        'inactive' => 'Il tuo account non è attivo. Si prega di contattare l\'amministrazione.',
        'suspended' => 'Il tuo account è stato sospeso. Si prega di contattare l\'amministrazione.',
    ],
    
    // Password Reset
    'password' => [
        'reset' => 'La tua password è stata reimpostata!',
        'sent' => 'Abbiamo inviato un collegamento per reimpostare la tua password!',
        'throttled' => 'Per favore, attendi prima di riprovare.',
        'token' => 'Questo token di reimpostazione della password è invalido.',
        'user' => 'Non possiamo trovare un utente con quell\'indirizzo email.',
        'reset_password' => 'Reimposta password',
        'reset_password_instructions' => 'Inserisci la nuova password per reimpostare il tuo account.',
        'email' => 'Indirizzo email',
        'password' => 'Nuova password',
        'confirm_password' => 'Conferma password',
        'reset_password_button' => 'Reimposta password',
        'user_not_found' => 'Nessun utente trovato con questo indirizzo email.',
        'reset_link_sent' => 'Un link di reimpostazione è stato inviato al tuo indirizzo email.',
        'invalid_token' => 'Il token di reimpostazione della password è invalido o scaduto.',
        'password_reset_success' => 'La tua password è stata reimpostata con successo!',
    ],
    
    // Email Verification
    'verification' => [
        'sent' => 'Un nuovo link di verifica è stato inviato al tuo indirizzo email.',
        'verify' => 'Prima di continuare, controlla la tua email per il link di verifica.',
        'request_another' => 'Un nuovo link di verifica è stato inviato al tuo indirizzo email.',
    ],
    
    // Logout
    'logout_success' => 'Disconnessione avvenuta con successo.',
    
    // Password Reset
    'reset_link_sent' => 'Un link per reimpostare la password è stato inviato al tuo indirizzo email.',
    'invalid_token' => 'Token di reimpostazione non valido o scaduto.',
    'email_not_found' => 'Non riusciamo a trovare un utente con questo indirizzo email.',
];
