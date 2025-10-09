<?php

return [
    // Validación
    'name' => [
        'required' => 'El nombre de la categoría es obligatorio.',
        'max' => 'El nombre no puede tener más de :max caracteres.',
        'unique' => 'Este nombre de categoría ya está en uso.',
    ],
    'description' => [
        'string' => 'La descripción debe ser una cadena de texto.',
    ],
    
    // Mensajes de éxito
    'stored' => 'Categoría creada correctamente.',
    'updated' => 'Categoría actualizada correctamente.',
    'deleted' => 'Categoría eliminada correctamente.',
    
    // Mensajes de error
    'delete_error' => 'Se produjo un error al eliminar la categoría.',
];
