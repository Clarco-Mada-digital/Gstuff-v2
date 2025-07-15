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
        'reset' => '¡Tu contraseña ha sido restablecida!',
        'sent' => '¡Hemos enviado un enlace para restablecer tu contraseña a tu correo electrónico!',
        'throttled' => 'Por favor, espera antes de volver a intentarlo.',
        'token' => 'Este token de restablecimiento de contraseña es inválido.',
        'user' => 'No podemos encontrar un usuario con esa dirección de correo electrónico.',
        'reset_password' => 'Restablecer contraseña',
        'reset_password_instructions' => 'Introduce tu nueva contraseña para restablecer tu cuenta.',
        'email' => 'Dirección de correo electrónico',
        'password' => 'Nueva contraseña',
        'confirm_password' => 'Confirmar contraseña',
        'reset_password_button' => 'Restablecer contraseña',
        'user_not_found' => 'No se encontró ningún usuario con esta dirección de correo electrónico.',
        'reset_link_sent' => 'Se ha enviado un enlace de restablecimiento a tu dirección de correo electrónico.',
        'invalid_token' => 'El token de restablecimiento de contraseña es inválido o ha expirado.',
        'password_reset_success' => '¡Tu contraseña ha sido restablecida con éxito!',
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
