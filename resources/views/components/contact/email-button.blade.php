

@props([
    'email' => null,
    'noEmailText' => 'No email provided',
    'class' => '',
    'isPause' => false
])

@php
    // Masquage de l'email si profil en pause
    $displayEmail = $email;
    if ($isPause && $email) {
        // Exemple : masquer la partie avant le @
        $displayEmail = preg_replace('/^[^@]+/', 'XXXXXXX', $email);
    }
@endphp

<div class="relative group w-full">
    <a 
        @if($email && !$isPause)
            href="mailto:{{ $email }}"
        @else
            href="#"
            aria-disabled="true"
        @endif
        class="flex w-full items-center justify-center gap-2 rounded-lg border p-2 text-sm transition-all duration-300
            {{ $class }}
            @if($isPause)
                cursor-not-allowed pointer-events-none bg-gray-200 text-gray-500 border-gray-300
            @else
                text-green-gs border-green-gs hover:bg-green-gs hover:text-white
            @endif"
    >
    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill="currentColor"
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10h5v-2h-5c-4.34 0-8-3.66-8-8s3.66-8 8-8s8 3.66 8 8v1.43c0 .79-.71 1.57-1.5 1.57s-1.5-.78-1.5-1.57V12c0-2.76-2.24-5-5-5s-5 2.24-5 5s2.24 5 5 5c1.38 0 2.64-.56 3.54-1.47c.65.89 1.77 1.47 2.96 1.47c1.97 0 3.5-1.6 3.5-3.57V12c0-5.52-4.48-10-10-10m0 13c-1.66 0-3-1.34-3-3s1.34-3 3-3s3 1.34 3 3s-1.34 3-3 3" />
        </svg>
        @if($email)
            {{ $displayEmail }}
        @else
            {{ $noEmailText }}
        @endif
    </a>

    @if($isPause)
        <x-badgePauseToolTip/>
    @endif
</div>
