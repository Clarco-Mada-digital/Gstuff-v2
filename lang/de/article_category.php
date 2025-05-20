<?php

return [
    // Validation
    'name' => [
        'required' => 'Der Kategoriename ist erforderlich.',
        'max' => 'Der Name darf nicht länger als :max Zeichen sein.',
        'unique' => 'Dieser Kategoriename wird bereits verwendet.',
    ],
    'description' => [
        'string' => 'Die Beschreibung muss eine Zeichenkette sein.',
    ],
    
    // Erfolgsmeldungen
    'stored' => 'Kategorie erfolgreich erstellt.',
    'updated' => 'Kategorie erfolgreich aktualisiert.',
    'deleted' => 'Kategorie erfolgreich gelöscht.',
    
    // Fehlermeldungen
    'delete_error' => 'Beim Löschen der Kategorie ist ein Fehler aufgetreten.',
];
