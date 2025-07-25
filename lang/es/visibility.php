<?php

return [
    'validation' => [
        'visibility_required' => 'El campo visibilidad es obligatorio.',
        'visibility_in' => 'La visibilidad seleccionada no es válida.',
        'countries_required_if' => 'El campo países es obligatorio cuando la visibilidad es personalizada.',
        'countries_array' => 'Los países deben ser un arreglo.',
        'countries_*_string' => 'Cada país debe ser una cadena de caracteres.',
        'countries_*_size' => 'Cada código de país debe tener 2 caracteres.',
    ],
    'success' => [
        'visibility_updated' => 'Configuración de visibilidad actualizada correctamente.',
        'visibility_reset' => 'Configuración de visibilidad restablecida correctamente.',
    ],
    'title' => 'Configuración de visibilidad del perfil',
    'profile_visibility' => '🌍 Visibilidad del perfil',
    'public' => [
        'label' => 'Perfil público',
        'description' => 'Visible en todos los países sin restricciones'
    ],
    'private' => [
        'label' => 'Perfil privado',
        'description' => 'Oculto en todos los países'
    ],
    'custom' => [
        'label' => 'Visibilidad personalizada',
        'description' => 'Elija los países donde su perfil será visible'
    ],
    'country_selector' => [
        'title' => 'Selección de países autorizados',
        'description' => 'Seleccione uno o más países de la lista a continuación',
        'placeholder' => 'Buscar un país...',
        'country' => 'País',
        'selected' => 'Seleccionado',
        'remove' => 'Eliminar',
        'highlight' => 'Seleccionado'
    ],
    'save' => 'Guardar cambios',
    'back' => 'Volver'
];
