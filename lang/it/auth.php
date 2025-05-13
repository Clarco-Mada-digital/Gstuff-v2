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
        'sent' => 'Abbiamo inviato via email il link per reimpostare la password!',
        'throttled' => 'Attendi prima di riprovare.',
        'token' => 'Questo token di reimpostazione della password non è valido.',
        'user' => 'Non riusciamo a trovare un utente con questo indirizzo email.',
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
