<?php

return [
    // Validazione
    'title' => [
        'required' => 'Il titolo è obbligatorio.',
        'max' => 'Il titolo non può superare i :max caratteri.',
        'unique' => 'Questo titolo è già in uso.',
    ],
    'slug' => [
        'required' => 'Lo slug è obbligatorio.',
        'max' => 'Lo slug non può superare i :max caratteri.',
        'unique' => 'Questo slug è già in uso.',
    ],
    'content' => [
        'required' => 'Il contenuto è obbligatorio.',
    ],
    'article_category_id' => [
        'required' => 'La categoria è obbligatoria.',
        'exists' => 'La categoria selezionata non è valida.',
    ],
    'article_user_id' => [
        'required' => 'L\'autore è obbligatorio.',
        'exists' => 'L\'autore selezionato non è valido.',
    ],
    'tags' => [
        'array' => 'I tag devono essere un array.',
        'exists' => 'Uno o più tag selezionati non sono validi.',
    ],
    'is_published' => [
        'boolean' => 'Il campo di pubblicazione deve essere vero o falso.',
    ],
    'published_at' => [
        'date' => 'La data di pubblicazione deve essere una data valida.',
        'after_or_equal' => 'La data di pubblicazione deve essere uguale o successiva a oggi.',
    ],
    
    // Messaggi di successo
    'stored' => 'Articolo creato con successo.',
    'updated' => 'Articolo aggiornato con successo.',
    'deleted' => 'Articolo eliminato definitivamente.',
    'published' => 'Articolo pubblicato con successo.',
    'unpublished' => 'Articolo rimosso dalla pubblicazione con successo.',
    
    // Messaggi di errore
    'not_found' => 'Articolo non trovato.',
    'unauthorized' => 'Non sei autorizzato a modificare questo articolo.',
    'store_error' => 'Si è verificato un errore durante la creazione dell\'articolo.',
    'update_error' => 'Si è verificato un errore durante l\'aggiornamento dell\'articolo.',
    'delete_error' => 'Si è verificato un errore durante l\'eliminazione dell\'articolo.',
];
