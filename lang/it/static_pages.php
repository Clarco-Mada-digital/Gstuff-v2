<?php

return [
    // Interfaccia
    'static_pages' => 'Pagine Statiche',
    'edit_static_page' => 'Modifica Pagina',
    'back' => 'Indietro',
    'new_page' => 'Nuova Pagina',
    'title' => 'Titolo',
    'content' => 'Contenuto',
    'meta_title' => 'Meta Titolo',
    'meta_description' => 'Meta Descrizione',
    'cancel' => 'Annulla',
    'delete' => 'Elimina',
    'save' => 'Salva',
    'slug' => 'Slug',
    'actions' => 'Azioni',
    'edit' => 'Modifica',
    'language' => 'Lingua',
    'select_language' => 'Seleziona lingua',
    
    // Messaggi di successo
    'created' => 'Pagina creata con successo',
    'updated' => 'Pagina aggiornata con successo',
    'deleted' => 'Pagina eliminata con successo',
    
    // Messaggi di errore
    'not_found' => 'Pagina non trovata',
    'delete_error' => 'Si è verificato un errore durante l\'eliminazione della pagina',
    'update_error' => 'Si è verificato un errore durante l\'aggiornamento della pagina',
    'create_error' => 'Si è verificato un errore durante la creazione della pagina',
    
    // Validazione
    'validation' => [
        'slug_required' => 'Lo slug è obbligatorio',
        'slug_unique' => 'Questo slug è già in uso',
        'slug_alpha_dash' => 'Lo slug può contenere solo lettere, numeri, trattini e trattini bassi',
        'title_required' => 'Il titolo è obbligatorio',
        'title_max' => 'Il titolo non può superare i :max caratteri',
        'content_required' => 'Il contenuto è obbligatorio',
        'meta_title_max' => 'Il meta titolo non può superare i :max caratteri',
        'meta_description_max' => 'La meta descrizione non può superare i :max caratteri',
        'lang_required' => 'La lingua è obbligatoria',
        'lang_in' => 'Lingua non supportata',
    ],

    'deleted_successfully' => 'Pagina eliminata con successo',
    'delete_error' => 'Si è verificato un errore durante l\'eliminazione della pagina',
    'confirm_delete' => 'Conferma eliminazione',
    'delete_confirmation_message' => 'Sei sicuro di voler eliminare questa pagina?',
    'table_of_contents' => 'Indice dei contenuti'
];
