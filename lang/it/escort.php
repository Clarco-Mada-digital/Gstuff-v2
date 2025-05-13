<?php

return [
    // Messaggi di convalida
    'validation' => [
        'escort_ids_required' => 'Gli ID delle escort sono obbligatori.',
        'escort_ids_array' => 'Gli ID delle escort devono essere un array.',
        'escort_ids_integer' => 'Ogni ID escort deve essere un numero intero.',
        'escort_ids_exists' => 'Uno o più ID escort non sono validi.',
    ],
    
    // Messaggi di errore
    'errors' => [
        'login_required' => 'Devi essere loggato per eseguire questa azione.',
        'unauthorized' => 'Non hai i permessi per eseguire questa azione.',
        'not_found' => 'Risorsa non trovata.',
        'escort_not_found' => 'Escort non trovata o non associata al tuo salone.',
        'salon_not_found' => 'Salone non trovato o non associato al tuo account.',
        'invitation_not_found' => 'Nessun invito trovato.',
        'no_escorts_selected' => 'Nessuna escort selezionata.',
        'invalid_escort_type' => 'Solo gli utenti con profilo "escort" possono essere invitati.',
        'invalid_salon_type' => 'Solo gli utenti con profilo "salone" possono essere invitati.',
        'authentication_failed' => 'Autenticazione fallita.',
    ],
    
    // Messaggi di successo
    'success' => [
        'invitation_sent' => 'Il tuo invito è stato inviato con successo!',
        'invitation_accepted' => 'Invito accettato con successo.',
        'invitation_rejected' => 'Invito rifiutato con successo.',
        'invitation_cancelled' => 'Invito annullato con successo.',
        'escort_managed' => 'Ora sei loggato come :name',
        'escort_autonomized' => 'L\'escort è stata resa autonoma con successo.',
        'escort_deleted' => 'L\'escort è stata eliminata con successo.',
        'escort_made_autonomous' => 'L\'escort è ora autonoma.',
        'returned_to_salon' => 'Ora sei loggato come :name',
    ],
];
