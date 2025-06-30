<?php

return [
    // Validación
    'content' => [
        'required' => 'El contenido del comentario es obligatorio.',
        'string' => 'El contenido debe ser una cadena de texto.',
        'max' => 'El comentario no puede tener más de :max caracteres.',
    ],
    'lang' => [
        'required' => 'El idioma es obligatorio.',
        'in' => 'El idioma seleccionado no es válido.',
    ],
    
    // Mensajes de éxito
    'stored' => 'Comentario enviado correctamente.',
    'approved' => 'Comentario aprobado correctamente.',
    'deleted' => 'Comentario eliminado correctamente.',
    'marked_as_read' => 'Comentario marcado como leído.',
    
    // Mensajes de error
    'login_required' => 'Debes iniciar sesión para realizar esta acción.',
    'admin_required' => 'Debes ser administrador para realizar esta acción.',
    'not_found' => 'Comentario no encontrado.',
    'store_error' => 'Ocurrió un error al enviar el comentario.',
    'approve_error' => 'Ocurrió un error al aprobar el comentario.',
    'delete_error' => 'Ocurrió un error al eliminar el comentario.',
];
