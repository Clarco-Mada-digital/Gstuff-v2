<?php

return [
    'validation' => [
        'visibility_required' => 'Das Sichtbarkeitsfeld ist erforderlich.',
        'visibility_in' => 'Die ausgewählte Sichtbarkeit ist ungültig.',
        'countries_required_if' => 'Das Länderfeld ist erforderlich, wenn die Sichtbarkeit angepasst ist.',
        'countries_array' => 'Die Länder müssen ein Array sein.',
        'countries_*_string' => 'Jedes Land muss eine Zeichenkette sein.',
        'countries_*_size' => 'Jeder Ländercode muss 2 Zeichen lang sein.',
    ],
    'success' => [
        'visibility_updated' => 'Sichtbarkeitseinstellungen erfolgreich aktualisiert.',
        'visibility_reset' => 'Sichtbarkeitseinstellungen erfolgreich zurückgesetzt.',
    ],
    'title' => 'Profil-Sichtbarkeitseinstellungen',
    'profile_visibility' => '🌍 Profil-Sichtbarkeit',
    'public' => [
        'label' => 'Öffentliches Profil',
        'description' => 'Sichtbar in allen Ländern ohne Einschränkungen'
    ],
    'private' => [
        'label' => 'Privates Profil',
        'description' => 'Versteckt in allen Ländern'
    ],
    'custom' => [
        'label' => 'Benutzerdefinierte Sichtbarkeit',
        'description' => 'Wählen Sie die Länder aus, in denen Ihr Profil sichtbar sein soll'
    ],
    'country_selector' => [
        'title' => 'Auswahl der autorisierten Länder',
        'description' => 'Wählen Sie ein oder mehrere Länder aus der Liste unten aus',
        'placeholder' => 'Suchen Sie nach einem Land...',
        'country' => 'Land',
        'selected' => 'Ausgewählt',
        'remove' => 'Entfernen',
        'highlight' => 'Ausgewählt'
    ],
    'save' => 'Änderungen speichern',
    'back' => 'Zurück'
];
