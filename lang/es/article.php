<?php

return [
    // Validación
    'title' => [
        'required' => 'El título es obligatorio.',
        'max' => 'El título no puede tener más de :max caracteres.',
        'unique' => 'Este título ya está en uso.',
    ],
    'slug' => [
        'required' => 'El slug es obligatorio.',
        'max' => 'El slug no puede tener más de :max caracteres.',
        'unique' => 'Este slug ya está en uso.',
    ],
    'content' => [
        'required' => 'El contenido es obligatorio.',
    ],
    'article_category_id' => [
        'required' => 'La categoría es obligatoria.',
        'exists' => 'La categoría seleccionada no es válida.',
    ],
    'article_user_id' => [
        'required' => 'El autor es obligatorio.',
        'exists' => 'El autor seleccionado no es válido.',
    ],
    'tags' => [
        'array' => 'Las etiquetas deben ser un arreglo.',
        'exists' => 'Una o más etiquetas seleccionadas no son válidas.',
    ],
    'is_published' => [
        'boolean' => 'El campo de publicación debe ser verdadero o falso.',
    ],
    'published_at' => [
        'date' => 'La fecha de publicación debe ser una fecha válida.',
        'after_or_equal' => 'La fecha de publicación debe ser igual o posterior a hoy.',
    ],
    
    // Mensajes de éxito
    'stored' => 'Artículo creado correctamente.',
    'updated' => 'Artículo actualizado correctamente.',
    'deleted' => 'Artículo eliminado permanentemente.',
    'published' => 'Artículo publicado correctamente.',
    'unpublished' => 'Artículo retirado de la publicación correctamente.',
    
    // Mensajes de error
    'not_found' => 'Artículo no encontrado.',
    'unauthorized' => 'No estás autorizado a editar este artículo.',
    'store_error' => 'Ocurrió un error al crear el artículo.',
    'update_error' => 'Ocurrió un error al actualizar el artículo.',
    'delete_error' => 'Ocurrió un error al eliminar el artículo.',
];
