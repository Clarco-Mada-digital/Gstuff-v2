<?php

return [
    'validation' => [
        'name_required' => 'Il nome del tag è obbligatorio.',
        'name_string' => 'Il nome deve essere una stringa.',
        'name_max' => 'Il nome non può superare i :max caratteri.',
        'name_unique' => 'Questo nome di tag è già in uso.',
    ],
    'success' => [
        'tag_created' => 'Tag creato con successo.',
        'tag_updated' => 'Tag aggiornato con successo.',
        'tag_deleted' => 'Tag eliminato con successo.',
    ],
    'error' => [
        'tag_not_found' => 'Tag non trovato.',
    ]
];
