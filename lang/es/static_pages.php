<?php

return [
    // Interfaz
    'static_pages' => 'Páginas Estáticas',
    'edit_static_page' => 'Editar Página',
    'back' => 'Volver',
    'new_page' => 'Nueva Página',
    'title' => 'Título',
    'content' => 'Contenido',
    'meta_title' => 'Meta Título',
    'meta_description' => 'Meta Descripción',
    'cancel' => 'Cancelar',
    'save' => 'Guardar',
    'slug' => 'Slug',
    'actions' => 'Acciones',
    'edit' => 'Editar',
    'language' => 'Idioma',
    'select_language' => 'Seleccionar idioma',
    
    // Mensajes de éxito
    'created' => 'Página creada correctamente',
    'updated' => 'Página actualizada correctamente',
    'deleted' => 'Página eliminada correctamente',
    
    // Mensajes de error
    'not_found' => 'Página no encontrada',
    'delete_error' => 'Ocurrió un error al eliminar la página',
    'update_error' => 'Ocurrió un error al actualizar la página',
    'create_error' => 'Ocurrió un error al crear la página',
    
    // Validación
    'validation' => [
        'slug_required' => 'El slug es obligatorio',
        'slug_unique' => 'Este slug ya está en uso',
        'slug_alpha_dash' => 'El slug solo puede contener letras, números, guiones y guiones bajos',
        'title_required' => 'El título es obligatorio',
        'title_max' => 'El título no puede tener más de :max caracteres',
        'content_required' => 'El contenido es obligatorio',
        'meta_title_max' => 'El meta título no puede tener más de :max caracteres',
        'meta_description_max' => 'La meta descripción no puede tener más de :max caracteres',
        'lang_required' => 'El idioma es obligatorio',
        'lang_in' => 'Idioma no soportado',
    ],
];
