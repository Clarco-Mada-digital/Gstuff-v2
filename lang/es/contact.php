<?php

return [
    // Títulos y etiquetas
    'page_title' => 'Contacto',
    'contact_us' => 'Contáctanos',
    'make_comment' => 'Dejar un comentario',
    'need_info' => '¿Necesitas información o consejos? ¡Contáctanos ahora!',
    'comment' => 'Comentario',
    'message_placeholder' => 'Mensaje',
    'send' => 'Enviar',
    'name' => 'Nombre',
    'name_placeholder' => 'Tu nombre',
    'email' => 'Correo electrónico',
    'email_placeholder' => 'tu@email.com',
    'subject' => 'Asunto',
    'subject_placeholder' => 'Asunto de tu mensaje',
    'message' => 'Mensaje',
    'message_placeholder' => 'Tu mensaje...',
    
    // Mensajes de éxito/error
    'success' => [
        'message_sent' => '¡Tu mensaje ha sido enviado con éxito!',
    ],
    'errors' => [
        'sending_failed' => 'Ha ocurrido un error al enviar tu mensaje. Por favor, inténtalo de nuevo más tarde.',
    ],
    
    // Mensajes de validación
    'validation' => [
        'name' => [
            'required' => 'El nombre es obligatorio',
            'string' => 'El nombre debe ser una cadena de texto',
            'max' => 'El nombre no puede tener más de :max caracteres',
        ],
        'email' => [
            'required' => 'El correo electrónico es obligatorio',
            'email' => 'Por favor, introduce una dirección de correo electrónico válida',
            'max' => 'El correo electrónico no puede tener más de :max caracteres',
        ],
        'subject' => [
            'required' => 'El asunto es obligatorio',
            'string' => 'El asunto debe ser una cadena de texto',
            'max' => 'El asunto no puede tener más de :max caracteres',
        ],
        'message' => [
            'required' => 'El mensaje es obligatorio',
            'string' => 'El mensaje debe ser una cadena de texto',
            'max' => 'El mensaje no puede tener más de :max caracteres',
        ],
    ],
];
