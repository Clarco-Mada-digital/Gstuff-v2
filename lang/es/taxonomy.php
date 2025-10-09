<?php

return [
    // Interface
    'taxonomy_management' => 'Gestión de Taxonomías',
    'new_category' => '+ Nueva Categoría',
    'new_tag' => '+ Nueva Etiqueta',
    'categories' => 'Categorías',
    'tags' => 'Etiquetas',
    'name' => 'Nombre',
    'articles' => 'Artículos',
    'actions' => 'Acciones',
    'edit' => 'Editar',
    'delete' => 'Eliminar',
    'confirm_delete' => 'Confirmar eliminación',
    'confirm_delete_message' => '¿Está seguro de que desea eliminar',
    'category' => 'esta categoría',
    'tag' => 'esta etiqueta',
    'irreversible_action' => '? Esta acción es irreversible.',
    'delete_button' => 'Eliminar',
    'cancel_button' => 'Cancelar',
    'save_button' => 'Guardar',
    'category_name' => 'Nombre',
    'category_description' => 'Descripción',
    'tag_name' => 'Nombre de la etiqueta',
    'edit_category' => 'Editar categoría',
    'create_category' => 'Crear categoría',
    'edit_tag' => 'Editar etiqueta',
    'create_tag' => 'Crear etiqueta',
    'no_categories_found' => 'No se encontraron categorías',
    'no_tags_found' => 'No se encontraron etiquetas',
    'status' => 'Estado',
    'active' => 'Activo',
    'inactive' => 'Inactivo',
    'toggle_status' => 'Cambiar estado',
    
    // Success messages
    'category_created' => 'Categoría creada correctamente',
    'category_updated' => 'Categoría actualizada correctamente',
    'category_deleted' => 'Categoría eliminada correctamente',
    'tag_created' => 'Etiqueta creada correctamente',
    'tag_updated' => 'Etiqueta actualizada correctamente',
    'tag_deleted' => 'Etiqueta eliminada correctamente',
    'status_updated' => 'Estado actualizado correctamente',
    
    // Error messages
    'category_not_found' => 'Categoría no encontrada',
    'tag_not_found' => 'Etiqueta no encontrada',
    'delete_error' => 'Ocurrió un error al eliminar',
    'update_error' => 'Ocurrió un error al actualizar',
    'create_error' => 'Ocurrió un error al crear',
    
    // Validation
    'validation' => [
        'name_required' => 'El campo nombre es obligatorio',
        'name_max' => 'El nombre no puede tener más de :max caracteres',
        'name_unique' => 'Este nombre ya está en uso',
        'name_exists' => 'Ya existe una categoría con este nombre',
        'description_string' => 'La descripción debe ser un texto',
        'id_required' => 'El ID es obligatorio',
        'id_exists' => 'El ID especificado no existe',
        'lang_required' => 'El idioma es obligatorio',
        'lang_in' => 'Idioma no soportado',
    ],
    
    // Form fields
    'fields' => [
        'name' => 'nombre',
        'description' => 'descripción',
        'language' => 'idioma',
    ],
];
