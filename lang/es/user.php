<?php

return [
    'validation' => [
        'pseudo_required' => 'El nombre de usuario es obligatorio.',
        'pseudo_string' => 'El nombre de usuario debe ser una cadena de caracteres.',
        'pseudo_max' => 'El nombre de usuario no puede tener más de :max caracteres.',
        'prenom_required' => 'El nombre es obligatorio.',
        'prenom_string' => 'El nombre debe ser una cadena de caracteres.',
        'prenom_max' => 'El nombre no puede tener más de :max caracteres.',
        'email_required' => 'La dirección de correo electrónico es obligatoria.',
        'email_email' => 'La dirección de correo electrónico debe ser válida.',
        'email_unique' => 'Esta dirección de correo electrónico ya está en uso.',
        'password_required' => 'La contraseña es obligatoria.',
        'password_string' => 'La contraseña debe ser una cadena de caracteres.',
        'password_min' => 'La contraseña debe tener al menos :min caracteres.',
        'date_naissance_required' => 'La fecha de nacimiento es obligatoria.',
        'date_naissance_date' => 'La fecha de nacimiento no es una fecha válida.',
        'profile_type_required' => 'El tipo de perfil es obligatorio.',
        'profile_type_in' => 'El tipo de perfil seleccionado no es válido.',
    ],
    'success' => [
        'user_created' => 'Usuario creado correctamente.',
        'user_updated' => 'Usuario actualizado correctamente.',
        'user_deleted' => 'Usuario eliminado correctamente.',
    ],
    'error' => [
        'user_not_found' => 'Usuario no encontrado.',
    ],
    'online' => 'En línea',
    'never_connected' => 'Nunca conectado',
    'just_now' => 'Ahora mismo',
    'minutes_ago' => 'Hace :count min',
    'hours_ago' => 'Hace :count h',
    'days_ago' => 'Hace :count días'
];
