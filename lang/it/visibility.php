<?php

return [
    'validation' => [
        'visibility_required' => 'Il campo visibilità è obbligatorio.',
        'visibility_in' => 'La visibilità selezionata non è valida.',
        'countries_required_if' => 'Il campo paesi è obbligatorio quando la visibilità è personalizzata.',
        'countries_array' => 'I paesi devono essere un array.',
        'countries_*_string' => 'Ogni paese deve essere una stringa.',
        'countries_*_size' => 'Ogni codice paese deve contenere 2 caratteri.',
    ],
    'success' => [
        'visibility_updated' => 'Impostazioni di visibilità aggiornate con successo.',
        'visibility_reset' => 'Impostazioni di visibilità reimpostate con successo.',
    ],
    'title' => 'Impostazioni di visibilità del profilo',
    'profile_visibility' => '🌍 Visibilità del profilo',
    'public' => [
        'label' => 'Profilo pubblico',
        'description' => 'Visibile in tutti i paesi senza restrizioni'
    ],
    'private' => [
        'label' => 'Profilo privato',
        'description' => 'Nascosto in tutti i paesi'
    ],
    'custom' => [
        'label' => 'Visibilità personalizzata',
        'description' => 'Scegli i paesi in cui il tuo profilo sarà visibile'
    ],
    'country_selector' => [
        'title' => 'Selezione dei paesi autorizzati',
        'description' => 'Seleziona uno o più paesi dalla lista sottostante',
        'placeholder' => 'Cerca un paese...',
        'country' => 'Paese',
        'selected' => 'Selezionato',
        'remove' => 'Rimuovi',
        'highlight' => 'Selezionato'
    ],
    'save' => 'Salva modifiche'
];
