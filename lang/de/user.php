<?php

return [
    'validation' => [
        'pseudo_required' => 'Der Benutzername ist erforderlich.',
        'pseudo_string' => 'Der Benutzername muss eine Zeichenkette sein.',
        'pseudo_max' => 'Der Benutzername darf nicht länger als :max Zeichen sein.',
        'prenom_required' => 'Der Vorname ist erforderlich.',
        'prenom_string' => 'Der Vorname muss eine Zeichenkette sein.',
        'prenom_max' => 'Der Vorname darf nicht länger als :max Zeichen sein.',
        'email_required' => 'Die E-Mail-Adresse ist erforderlich.',
        'email_email' => 'Die E-Mail-Adresse muss gültig sein.',
        'email_unique' => 'Diese E-Mail-Adresse wird bereits verwendet.',
        'password_required' => 'Das Passwort ist erforderlich.',
        'password_string' => 'Das Passwort muss eine Zeichenkette sein.',
        'password_min' => 'Das Passwort muss mindestens :min Zeichen lang sein.',
        'date_naissance_required' => 'Das Geburtsdatum ist erforderlich.',
        'date_naissance_date' => 'Das Geburtsdatum ist kein gültiges Datum.',
        'profile_type_required' => 'Der Profiltyp ist erforderlich.',
        'profile_type_in' => 'Der ausgewählte Profiltyp ist ungültig.',
    ],
    'success' => [
        'user_created' => 'Benutzer erfolgreich erstellt.',
        'user_updated' => 'Benutzer erfolgreich aktualisiert.',
        'user_deleted' => 'Benutzer erfolgreich gelöscht.',
    ],
    'error' => [
        'user_not_found' => 'Benutzer nicht gefunden.',
    ]
];
