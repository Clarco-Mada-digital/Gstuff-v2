<?php

return [
    // Validation
    'content' => [
        'required' => 'Der Kommentarinhalt ist erforderlich.',
        'string' => 'Der Inhalt muss eine Zeichenkette sein.',
        'max' => 'Der Kommentar darf nicht länger als :max Zeichen sein.',
    ],
    'lang' => [
        'required' => 'Die Sprache ist erforderlich.',
        'in' => 'Die ausgewählte Sprache ist ungültig.',
    ],
    
    // Erfolgsmeldungen
    'stored' => 'Kommentar erfolgreich gesendet.',
    'approved' => 'Kommentar erfolgreich genehmigt.',
    'deleted' => 'Kommentar erfolgreich gelöscht.',
    'marked_as_read' => 'Kommentar als gelesen markiert.',
    
    // Fehlermeldungen
    'login_required' => 'Sie müssen angemeldet sein, um diese Aktion auszuführen.',
    'admin_required' => 'Sie müssen Administrator sein, um diese Aktion auszuführen.',
    'not_found' => 'Kommentar nicht gefunden.',
    'store_error' => 'Beim Senden des Kommentars ist ein Fehler aufgetreten.',
    'approve_error' => 'Beim Genehmigen des Kommentars ist ein Fehler aufgetreten.',
    'delete_error' => 'Beim Löschen des Kommentars ist ein Fehler aufgetreten.',
];
