<?php

return [
    'validation' => [
        'name_required' => 'El nombre de la etiqueta es obligatorio.',
        'name_string' => 'El nombre debe ser una cadena de caracteres.',
        'name_max' => 'El nombre no puede tener más de :max caracteres.',
        'name_unique' => 'Este nombre de etiqueta ya está en uso.',
    ],
    'success' => [
        'tag_created' => 'Etiqueta creada correctamente.',
        'tag_updated' => 'Etiqueta actualizada correctamente.',
        'tag_deleted' => 'Etiqueta eliminada correctamente.',
    ],
    'error' => [
        'tag_not_found' => 'Etiqueta no encontrada.',
    ]
];
