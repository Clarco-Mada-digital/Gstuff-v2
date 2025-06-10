<?php

return [
    'failed' => 'Diese Zugangsdaten stimmen nicht mit unseren Aufzeichnungen überein.',
    'password' => 'Das angegebene Passwort ist falsch.',
    'throttle' => 'Zu viele Anmeldeversuche. Bitte versuchen Sie es in :seconds Sekunden erneut.',
    
    // Registration
    'registration' => [
        'success' => 'Registrierung erfolgreich! Willkommen.',
        'validation_error' => 'Validierungsfehler',
        'email_exists' => 'Diese E-Mail-Adresse wird bereits verwendet',
        'invalid_role' => 'Ungültige Rolle',
    ],
    
    // Login
    'login' => [
        'success' => 'Anmeldung erfolgreich!',
        'failed' => 'Diese Zugangsdaten stimmen nicht mit unseren Aufzeichnungen überein.',
        'salon_managed' => 'Ihr Konto wird derzeit von einem Salon verwaltet. Bitte wenden Sie sich an die Verwaltung.',
        'inactive' => 'Ihr Konto ist inaktiv. Bitte wenden Sie sich an die Verwaltung.',
        'suspended' => 'Ihr Konto wurde gesperrt. Bitte wenden Sie sich an die Verwaltung.',
    ],
    
    // Password Reset
    'password' => [
        'reset' => 'Ihr Passwort wurde zurückgesetzt!',
        'sent' => 'Wir haben Ihnen einen Link zum Zurücksetzen des Passworts per E-Mail gesendet!',
        'throttled' => 'Bitte warten Sie, bevor Sie es erneut versuchen.',
        'token' => 'Dieser Token zum Zurücksetzen des Passworts ist ungültig.',
        'user' => 'Wir können keinen Benutzer mit dieser E-Mail-Adresse finden.',
    ],
    
    // Email Verification
    'verification' => [
        'sent' => 'Ein neuer Bestätigungslink wurde an Ihre E-Mail-Adresse gesendet.',
        'verify' => 'Bitte überprüfen Sie Ihre E-Mail auf einen Bestätigungslink, bevor Sie fortfahren.',
        'request_another' => 'Ein neuer Bestätigungslink wurde an Ihre E-Mail-Adresse gesendet.',
    ],
    
    // Logout
    'logout_success' => 'Erfolgreich abgemeldet.',
    
    // Password Reset
    'reset_link_sent' => 'Ein Link zum Zurücksetzen des Passworts wurde an Ihre E-Mail-Adresse gesendet.',
    'invalid_token' => 'Ungültiger oder abgelaufener Token.',
    'email_not_found' => 'Wir können keinen Benutzer mit dieser E-Mail-Adresse finden.',
];
