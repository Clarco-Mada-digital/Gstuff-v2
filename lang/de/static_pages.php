<?php

return [
    // Interface
    'static_pages' => 'Statische Seiten',
    'edit_static_page' => 'Seite bearbeiten',
    'back' => 'Zurück',
    'new_page' => 'Neue Seite',
    'title' => 'Titel',
    'content' => 'Inhalt',
    'meta_title' => 'Meta-Titel',
    'meta_description' => 'Meta-Beschreibung',
    'cancel' => 'Abbrechen',
    'delete' => 'Löschen',
    'save' => 'Speichern',
    'slug' => 'Slug',
    'actions' => 'Aktionen',
    'edit' => 'Bearbeiten',
    'language' => 'Sprache',
    'select_language' => 'Sprache auswählen',
    
    // Erfolgsmeldungen
    'created' => 'Seite erfolgreich erstellt',
    'updated' => 'Seite erfolgreich aktualisiert',
    'deleted' => 'Seite erfolgreich gelöscht',
    
    // Fehlermeldungen
    'not_found' => 'Seite nicht gefunden',
    'delete_error' => 'Beim Löschen der Seite ist ein Fehler aufgetreten',
    'update_error' => 'Beim Aktualisieren der Seite ist ein Fehler aufgetreten',
    'create_error' => 'Beim Erstellen der Seite ist ein Fehler aufgetreten',
    
    // Validierung
    'validation' => [
        'slug_required' => 'Der Slug ist erforderlich',
        'slug_unique' => 'Dieser Slug wird bereits verwendet',
        'slug_alpha_dash' => 'Der Slug darf nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten',
        'title_required' => 'Der Titel ist erforderlich',
        'title_max' => 'Der Titel darf nicht länger als :max Zeichen sein',
        'content_required' => 'Der Inhalt ist erforderlich',
        'meta_title_max' => 'Der Meta-Titel darf nicht länger als :max Zeichen sein',
        'meta_description_max' => 'Die Meta-Beschreibung darf nicht länger als :max Zeichen sein',
        'lang_required' => 'Die Sprache ist erforderlich',
        'lang_in' => 'Nicht unterstützte Sprache',
    ],

    'deleted_successfully' => 'Seite erfolgreich gelöscht',
    'delete_error' => 'Beim Löschen der Seite ist ein Fehler aufgetreten',
    'confirm_delete' => 'Löschen bestätigen',
    'delete_confirmation_message' => 'Sind Sie sicher, dass Sie diese Seite löschen möchten?'
];
