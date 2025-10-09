<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function build()
    {
        return $this->markdown('emails.password-reset')
                    ->subject('Réinitialisation de mot de passe')
                    ->with([
                        'user' => $this->user,
                        'token' => $this->token,
                        'reset_url' => url('reset-password/' . $this->token)
                    ]);
    }
}
