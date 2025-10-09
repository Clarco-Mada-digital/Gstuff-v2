<?php

return [
    'profile_type' => [
        'required' => 'El tipo de perfil es obligatorio.',
        'in' => 'El tipo de perfil seleccionado no es válido.',
    ],
    'email' => [
        'required' => 'La dirección de correo electrónico es obligatoria.',
        'email' => 'La dirección de correo electrónico debe ser una dirección válida.',
        'only' => 'Esta dirección de correo electrónico ya está en uso.',
    ],
    'password' => [
        'required' => 'La contraseña es obligatoria.',
        'confirmed' => 'La confirmación de la contraseña no coincide.',
        'min' => 'La contraseña debe tener al menos :min caracteres.',
    ],
    'date_naissance' => [
        'required' => 'La fecha de nacimiento es obligatoria.',
        'date' => 'La fecha de nacimiento no es una fecha válida.',
        'before' => 'Debes tener al menos 18 años para registrarte.',
    ],
    'cgu_accepted' => [
        'accepted' => 'Debes aceptar los términos y condiciones.',
    ],
    'pseudo' => [
        'required_if' => 'El nombre de usuario es obligatorio para el perfil de invitado.',
        'string' => 'El nombre de usuario debe ser una cadena de caracteres.',
        'max' => 'El nombre de usuario no puede tener más de :max caracteres.',
    ],
    'prenom' => [
        'required_if' => 'El nombre es obligatorio para el perfil de escort.',
        'string' => 'El nombre debe ser una cadena de caracteres.',
        'max' => 'El nombre no puede tener más de :max caracteres.',
    ],
    'genre_id' => [
        'required_if' => 'El género es obligatorio para el perfil de escort.',
        'exists' => 'El género seleccionado no es válido.',
    ],
    'nom_salon' => [
        'required_if' => 'El nombre del salón es obligatorio para el perfil de salón.',
        'string' => 'El nombre del salón debe ser una cadena de caracteres.',
        'max' => 'El nombre del salón no puede tener más de :max caracteres.',
    ],
    'intitule' => [
        'required_if' => 'El título es obligatorio para el perfil de salón.',
        'in' => 'El título seleccionado no es válido.',
    ],
    'nom_proprietaire' => [
        'required_if' => 'El nombre del propietario es obligatorio para el perfil de salón.',
        'string' => 'El nombre del propietario debe ser una cadena de caracteres.',
        'max' => 'El nombre del propietario no puede tener más de :max caracteres.',
    ],
    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute debe ser una cadena de caracteres.',
    'email' => 'El campo :attribute debe ser una dirección de correo electrónico válida.',
    'max' => [
        'string' => 'El campo :attribute no puede tener más de :max caracteres.',
    ],
    'unique' => 'El valor del campo :attribute ya está en uso.',
    'confirmed' => 'La confirmación del campo :attribute no coincide.',
    'array' => 'El campo :attribute debe ser un array.',
    'exists' => 'El :attribute seleccionado no es válido.',
    'attributes' => [
        'pseudo' => 'nombre de usuario',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
        'roles' => 'roles',
    ],
];
