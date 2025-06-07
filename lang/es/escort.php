<?php

return [
    // Mensajes de validación
    'validation' => [
        'escort_ids_required' => 'Se requieren IDs de acompañantes.',
        'escort_ids_array' => 'Los IDs de acompañantes deben ser un arreglo.',
        'escort_ids_integer' => 'Cada ID de acompañante debe ser un número entero.',
        'escort_ids_exists' => 'Uno o más IDs de acompañantes no son válidos.',
    ],
    
    // Mensajes de error
    'errors' => [
        'login_required' => 'Debes iniciar sesión para realizar esta acción.',
        'unauthorized' => 'No tienes permiso para realizar esta acción.',
        'not_found' => 'Recurso no encontrado.',
        'escort_not_found' => 'Acompañante no encontrado o no asociado a tu salón.',
        'salon_not_found' => 'Salón no encontrado o no asociado a tu cuenta.',
        'invitation_not_found' => 'No se encontró ninguna invitación.',
        'no_escorts_selected' => 'No se seleccionaron acompañantes.',
        'invalid_escort_type' => 'Solo los usuarios con perfil "acompañante" pueden ser invitados.',
        'invalid_salon_type' => 'Solo los usuarios con perfil "salón" pueden ser invitados.',
        'authentication_failed' => 'Error de autenticación.',
    ],
    
    // Mensajes de éxito
    'success' => [
        'invitation_sent' => '¡Tu invitación ha sido enviada con éxito!',
        'invitation_accepted' => 'Invitación aceptada correctamente.',
        'invitation_rejected' => 'Invitación rechazada correctamente.',
        'invitation_cancelled' => 'Invitación cancelada correctamente.',
        'escort_managed' => 'Ahora has iniciado sesión como :name',
        'escort_autonomized' => 'La acompañante ha sido autonomizada correctamente.',
        'escort_deleted' => 'La acompañante ha sido eliminada correctamente.',
        'escort_made_autonomous' => 'La acompañante ahora es autónoma.',
        'returned_to_salon' => 'Ahora has iniciado sesión como :name',
    ],
];
