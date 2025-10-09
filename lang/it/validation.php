<?php

return [
    'profile_type' => [
        'required' => 'Il tipo di profilo è obbligatorio.',
        'in' => 'Il tipo di profilo selezionato non è valido.',
    ],
    'email' => [
        'required' => 'L\'indirizzo email è obbligatorio.',
        'email' => 'L\'indirizzo email deve essere un indirizzo valido.',
        'only' => 'Questo indirizzo email è già in uso.',
    ],
    'password' => [
        'required' => 'La password è obbligatoria.',
        'confirmed' => 'La conferma della password non corrisponde.',
        'min' => 'La password deve contenere almeno :min caratteri.',
    ],
    'date_naissance' => [
        'required' => 'La data di nascita è obbligatoria.',
        'date' => 'La data di nascita non è una data valida.',
        'before' => 'Devi avere almeno 18 anni per registrarti.',
    ],
    'cgu_accepted' => [
        'accepted' => 'Devi accettare i termini e le condizioni.',
    ],
    'pseudo' => [
        'required_if' => 'Lo username è obbligatorio per il profilo ospite.',
        'string' => 'Lo username deve essere una stringa.',
        'max' => 'Lo username non può superare i :max caratteri.',
    ],
    'prenom' => [
        'required_if' => 'Il nome è obbligatorio per il profilo escort.',
        'string' => 'Il nome deve essere una stringa.',
        'max' => 'Il nome non può superare i :max caratteri.',
    ],
    'genre_id' => [
        'required_if' => 'Il genere è obbligatorio per il profilo escort.',
        'exists' => 'Il genere selezionato non è valido.',
    ],
    'nom_salon' => [
        'required_if' => 'Il nome del salone è obbligatorio per il profilo salone.',
        'string' => 'Il nome del salone deve essere una stringa.',
        'max' => 'Il nome del salone non può superare i :max caratteri.',
    ],
    'intitule' => [
        'required_if' => 'Il titolo è obbligatorio per il profilo salone.',
        'in' => 'Il titolo selezionato non è valido.',
    ],
    'nom_proprietaire' => [
        'required_if' => 'Il nome del proprietario è obbligatorio per il profilo salone.',
        'string' => 'Il nome del proprietario deve essere una stringa.',
        'max' => 'Il nome del proprietario non può superare i :max caratteri.',
    ],
    'required' => 'Il campo :attribute è obbligatorio.',
    'string' => 'Il campo :attribute deve essere una stringa.',
    'email' => 'Il campo :attribute deve essere un indirizzo email valido.',
    'max' => [
        'string' => 'Il campo :attribute non può superare i :max caratteri.',
    ],
    'unique' => 'Il valore del campo :attribute è già stato utilizzato.',
    'confirmed' => 'La conferma del campo :attribute non corrisponde.',
    'array' => 'Il campo :attribute deve essere un array.',
    'exists' => 'Il :attribute selezionato non è valido.',
    'attributes' => [
        'pseudo' => 'username',
        'email' => 'indirizzo email',
        'password' => 'password',
        'roles' => 'ruoli',
    ],
];
