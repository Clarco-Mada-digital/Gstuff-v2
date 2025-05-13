<?php

return [
    'failed' => 'Estas credenciales no coinciden con nuestros registros.',
    'password' => 'La contraseña proporcionada es incorrecta.',
    'throttle' => 'Demasiados intentos de inicio de sesión. Por favor, intente de nuevo en :seconds segundos.',
    
    // Registration
    'registration' => [
        'success' => '¡Registro exitoso! Bienvenido/a.',
        'validation_error' => 'Error de validación',
        'email_exists' => 'Este correo electrónico ya está en uso',
        'invalid_role' => 'Rol no válido',
    ],
    
    // Login
    'login' => [
        'success' => '¡Inicio de sesión exitoso!',
        'failed' => 'Estas credenciales no coinciden con nuestros registros.',
        'salon_managed' => 'Su cuenta está actualmente gestionada por un salón. Por favor, contacte a la administración.',
        'inactive' => 'Su cuenta está inactiva. Por favor, contacte a la administración.',
        'suspended' => 'Su cuenta ha sido suspendida. Por favor, contacte a la administración.',
    ],
    
    // Password Reset
    'password' => [
        'reset' => '¡Su contraseña ha sido restablecida!',
        'sent' => '¡Hemos enviado por correo electrónico el enlace para restablecer su contraseña!',
        'throttled' => 'Por favor, espere antes de volver a intentarlo.',
        'token' => 'Este token de restablecimiento de contraseña no es válido.',
        'user' => 'No podemos encontrar un usuario con esa dirección de correo electrónico.',
    ],
    
    // Email Verification
    'verification' => [
        'sent' => 'Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.',
        'verify' => 'Antes de continuar, por favor revise su correo electrónico para ver el enlace de verificación.',
        'request_another' => 'Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.',
    ],
    
    // Logout
    'logout_success' => 'Cierre de sesión exitoso.',
    
    // Password Reset
    'reset_link_sent' => 'Se ha enviado un enlace para restablecer la contraseña a su dirección de correo electrónico.',
    'invalid_token' => 'Token de restablecimiento no válido o caducado.',
    'email_not_found' => 'No podemos encontrar un usuario con esa dirección de correo electrónico.',
];
