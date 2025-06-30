<?php

return [
    // Titres et libellés
    'page_title' => 'Contact',
    'contact_us' => 'Nous contacter',
    'make_comment' => 'Faire un commentaire',
    'need_info' => 'Besoin d\'informations ou de conseils ? Contactez-nous dès maintenant !',
    'comment' => 'Commentaire',
    'message_placeholder' => 'Message',
    'send' => 'Envoyer',
    'name' => 'Nom',
    'name_placeholder' => 'Votre nom',
    'email' => 'Email',
    'email_placeholder' => 'votre@email.com',
    'subject' => 'Sujet',
    'subject_placeholder' => 'Objet de votre message',
    'message' => 'Message',
    'message_placeholder' => 'Votre message...',
    
    // Messages de succès/erreur
    'success' => [
        'message_sent' => 'Votre message a été envoyé avec succès !',
    ],
    'errors' => [
        'sending_failed' => 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer plus tard.',
    ],
    
    // Messages de validation
    'validation' => [
        'name' => [
            'required' => 'Le nom est requis',
            'string' => 'Le nom doit être une chaîne de caractères',
            'max' => 'Le nom ne peut pas dépasser :max caractères',
        ],
        'email' => [
            'required' => 'L\'email est requis',
            'email' => 'Veuillez entrer une adresse email valide',
            'max' => 'L\'email ne peut pas dépasser :max caractères',
        ],
        'subject' => [
            'required' => 'Le sujet est requis',
            'string' => 'Le sujet doit être une chaîne de caractères',
            'max' => 'Le sujet ne peut pas dépasser :max caractères',
        ],
        'message' => [
            'required' => 'Le message est requis',
            'string' => 'Le message doit être une chaîne de caractères',
            'max' => 'Le message ne peut pas dépasser :max caractères',
        ],
    ],
];
