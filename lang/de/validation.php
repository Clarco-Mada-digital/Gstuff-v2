<?php

return [
    'profile_type' => [
        'required' => 'Der Profiltyp ist erforderlich.',
        'in' => 'Der ausgewählte Profiltyp ist ungültig.',
    ],
    'email' => [
        'required' => 'Die E-Mail-Adresse ist erforderlich.',
        'email' => 'Die E-Mail-Adresse muss eine gültige E-Mail-Adresse sein.',
        'unique' => 'Diese E-Mail-Adresse wird bereits verwendet.',
    ],
    'password' => [
        'required' => 'Das Passwort ist erforderlich.',
        'confirmed' => 'Die Passwortbestätigung stimmt nicht überein.',
        'min' => 'Das Passwort muss mindestens :min Zeichen lang sein.',
    ],
    'date_naissance' => [
        'required' => 'Das Geburtsdatum ist erforderlich.',
        'date' => 'Das Geburtsdatum ist kein gültiges Datum.',
        'before' => 'Sie müssen mindestens 18 Jahre alt sein, um sich zu registrieren.',
    ],
    'cgu_accepted' => [
        'accepted' => 'Sie müssen die Allgemeinen Geschäftsbedingungen akzeptieren.',
    ],
    'pseudo' => [
        'required_if' => 'Der Benutzername ist für ein Gastprofil erforderlich.',
        'string' => 'Der Benutzername muss eine Zeichenkette sein.',
        'max' => 'Der Benutzername darf nicht länger als :max Zeichen sein.',
    ],
    'prenom' => [
        'required_if' => 'Der Vorname ist für ein Escort-Profil erforderlich.',
        'string' => 'Der Vorname muss eine Zeichenkette sein.',
        'max' => 'Der Vorname darf nicht länger als :max Zeichen sein.',
    ],
    'genre_id' => [
        'required_if' => 'Das Geschlecht ist für ein Escort-Profil erforderlich.',
        'exists' => 'Das ausgewählte Geschlecht ist ungültig.',
    ],
    'nom_salon' => [
        'required_if' => 'Der Salonname ist für ein Salon-Profil erforderlich.',
        'string' => 'Der Salonname muss eine Zeichenkette sein.',
        'max' => 'Der Salonname darf nicht länger als :max Zeichen sein.',
    ],
    'intitule' => [
        'required_if' => 'Die Anrede ist für ein Salon-Profil erforderlich.',
        'in' => 'Die ausgewählte Anrede ist ungültig.',
    ],
    'nom_proprietaire' => [
        'required_if' => 'Der Name des Inhabers ist für ein Salon-Profil erforderlich.',
        'string' => 'Der Name des Inhabers muss eine Zeichenkette sein.',
        'max' => 'Der Name des Inhabers darf nicht länger als :max Zeichen sein.',
    ],
    'required' => 'Das Feld :attribute ist erforderlich.',
    'string' => 'Das Feld :attribute muss eine Zeichenkette sein.',
    'email' => 'Das Feld :attribute muss eine gültige E-Mail-Adresse sein.',
    'max' => [
        'string' => 'Das Feld :attribute darf nicht länger als :max Zeichen sein.',
    ],
    'unique' => 'Der Wert des Feldes :attribute wird bereits verwendet.',
    'confirmed' => 'Die Bestätigung des Feldes :attribute stimmt nicht überein.',
    'array' => 'Das Feld :attribute muss ein Array sein.',
    'exists' => 'Das ausgewählte :attribute ist ungültig.',
    'attributes' => [
        'pseudo' => 'Benutzername',
        'email' => 'E-Mail-Adresse',
        'password' => 'Passwort',
        'roles' => 'Rollen',
    ],
];
