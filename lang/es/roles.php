<?php

return [
    // Mensajes de éxito
    'role_created' => 'Rol creado correctamente',
    'role_updated' => 'Rol actualizado correctamente',
    'role_deleted' => 'Rol eliminado correctamente',
    'permissions_updated' => 'Permisos actualizados correctamente',
    
    // Mensajes de error
    'admin_role_protected' => 'Este rol está protegido y no se puede modificar',
    'delete_admin_denied' => 'No se puede eliminar el rol de administrador',
    'delete_self_denied' => 'No puedes eliminar tu propio rol',
    'role_not_found' => 'Rol no encontrado',
    
    // Validación
    'validation' => [
        'name_required' => 'El nombre del rol es obligatorio',
        'name_unique' => 'Este nombre de rol ya está en uso',
        'name_max' => 'El nombre del rol no puede superar los :max caracteres',
        'permissions_array' => 'Los permisos deben ser un array',
        'permissions_exists' => 'Uno o más permisos seleccionados no son válidos',
    ],
];
