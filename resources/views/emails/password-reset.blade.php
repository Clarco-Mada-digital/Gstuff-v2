@component('mail::message')
    Bonjour {{ $user->name }},

    Vous avez demandé une réinitialisation de votre mot de passe.

    Pour réinitialiser votre mot de passe, cliquez sur le lien suivant :
    @component('mail::button', ['url' => $reset_url])
        Réinitialiser mon mot de passe
    @endcomponent

    Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.

    Merci,
    {{ config('app.name') }}
@endcomponent
