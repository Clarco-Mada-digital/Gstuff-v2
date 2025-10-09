<?php

return [
    // Interface
    'taxonomy_management' => 'Taxonomieverwaltung',
    'new_category' => '+ Neue Kategorie',
    'new_tag' => '+ Neues Tag',
    'categories' => 'Kategorien',
    'tags' => 'Tags',
    'name' => 'Name',
    'articles' => 'Artikel',
    'actions' => 'Aktionen',
    'edit' => 'Bearbeiten',
    'delete' => 'Löschen',
    'confirm_delete' => 'Löschen bestätigen',
    'confirm_delete_message' => 'Sind Sie sicher, dass Sie löschen möchten',
    'category' => 'diese Kategorie',
    'tag' => 'dieses Tag',
    'irreversible_action' => '? Diese Aktion kann nicht rückgängig gemacht werden.',
    'delete_button' => 'Löschen',
    'cancel_button' => 'Abbrechen',
    'save_button' => 'Speichern',
    'category_name' => 'Name',
    'category_description' => 'Beschreibung',
    'tag_name' => 'Name des Tags',
    'edit_category' => 'Kategorie bearbeiten',
    'create_category' => 'Kategorie erstellen',
    'edit_tag' => 'Tag bearbeiten',
    'create_tag' => 'Tag erstellen',
    'no_categories_found' => 'Keine Kategorien gefunden',
    'no_tags_found' => 'Keine Tags gefunden',
    'status' => 'Status',
    'active' => 'Aktiv',
    'inactive' => 'Inaktiv',
    'toggle_status' => 'Status umschalten',
    
    // Success messages
    'category_created' => 'Kategorie erfolgreich erstellt',
    'category_updated' => 'Kategorie erfolgreich aktualisiert',
    'category_deleted' => 'Kategorie erfolgreich gelöscht',
    'tag_created' => 'Tag erfolgreich erstellt',
    'tag_updated' => 'Tag erfolgreich aktualisiert',
    'tag_deleted' => 'Tag erfolgreich gelöscht',
    'status_updated' => 'Status erfolgreich aktualisiert',
    
    // Error messages
    'category_not_found' => 'Kategorie nicht gefunden',
    'tag_not_found' => 'Tag nicht gefunden',
    'delete_error' => 'Beim Löschen ist ein Fehler aufgetreten',
    'update_error' => 'Beim Aktualisieren ist ein Fehler aufgetreten',
    'create_error' => 'Beim Erstellen ist ein Fehler aufgetreten',
    
    // Validation
    'validation' => [
        'name_required' => 'Der Name ist erforderlich',
        'name_max' => 'Der Name darf nicht länger als :max Zeichen sein',
        'name_unique' => 'Dieser Name wird bereits verwendet',
        'name_exists' => 'Eine Kategorie mit diesem Namen existiert bereits',
        'description_string' => 'Die Beschreibung muss ein Text sein',
        'id_required' => 'Die ID ist erforderlich',
        'id_exists' => 'Die angegebene ID existiert nicht',
        'lang_required' => 'Die Sprache ist erforderlich',
        'lang_in' => 'Nicht unterstützte Sprache',
    ],
    
    // Form fields
    'fields' => [
        'name' => 'Name',
        'description' => 'Beschreibung',
        'language' => 'Sprache',
    ],
];
