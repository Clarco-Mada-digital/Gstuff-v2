<?php

return [
    'validation' => [
        'user_id_required' => 'Se requiere el ID de usuario.',
        'user_id_numeric' => 'El ID de usuario debe ser un número.',
    ],
    'errors' => [
        'unauthorized' => 'Debe iniciar sesión como administrador para realizar esta operación.',
        'invalid_user_id' => 'ID de usuario no válido.',
        'user_not_found' => 'Usuario no encontrado.',
    ],
    'success' => [
        'notification_deleted' => 'La notificación ha sido eliminada y el estado del usuario ha sido actualizado correctamente.',
    ]
];
