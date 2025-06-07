<?php

return [
    // Validation
    'title' => [
        'required' => 'Der Titel ist erforderlich.',
        'max' => 'Der Titel darf nicht länger als :max Zeichen sein.',
        'unique' => 'Dieser Titel wird bereits verwendet.',
    ],
    'slug' => [
        'required' => 'Der Slug ist erforderlich.',
        'max' => 'Der Slug darf nicht länger als :max Zeichen sein.',
        'unique' => 'Dieser Slug wird bereits verwendet.',
    ],
    'content' => [
        'required' => 'Der Inhalt ist erforderlich.',
    ],
    'article_category_id' => [
        'required' => 'Die Kategorie ist erforderlich.',
        'exists' => 'Die ausgewählte Kategorie ist ungültig.',
    ],
    'article_user_id' => [
        'required' => 'Der Autor ist erforderlich.',
        'exists' => 'Der ausgewählte Autor ist ungültig.',
    ],
    'tags' => [
        'array' => 'Die Tags müssen ein Array sein.',
        'exists' => 'Ein oder mehrere ausgewählte Tags sind ungültig.',
    ],
    'is_published' => [
        'boolean' => 'Das Veröffentlichungsfeld muss wahr oder falsch sein.',
    ],
    'published_at' => [
        'date' => 'Das Veröffentlichungsdatum muss ein gültiges Datum sein.',
        'after_or_equal' => 'Das Veröffentlichungsdatum muss ein Datum nach oder gleich heute sein.',
    ],
    
    // Erfolgsmeldungen
    'stored' => 'Artikel erfolgreich erstellt.',
    'updated' => 'Artikel erfolgreich aktualisiert.',
    'deleted' => 'Artikel endgültig gelöscht.',
    'published' => 'Artikel erfolgreich veröffentlicht.',
    'unpublished' => 'Artikel erfolgreich zurückgezogen.',
    
    // Fehlermeldungen
    'not_found' => 'Artikel nicht gefunden.',
    'unauthorized' => 'Sie sind nicht berechtigt, diesen Artikel zu bearbeiten.',
    'store_error' => 'Beim Erstellen des Artikels ist ein Fehler aufgetreten.',
    'update_error' => 'Beim Aktualisieren des Artikels ist ein Fehler aufgetreten.',
    'delete_error' => 'Beim Löschen des Artikels ist ein Fehler aufgetreten.',
];
