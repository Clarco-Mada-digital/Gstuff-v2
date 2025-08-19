@props([
    'phone' => null,
    'noPhoneText' => 'No phone number',
    'class' => '',
    'isPause' => false
])

@php
    // Masquage du numéro si profil en pause
    $displayPhone = $phone;
    if ($isPause && $phone) {
        // Exemple : masquer après les 3 premiers chiffres
        $displayPhone = preg_replace('/^(\d{3})\d+$/', '$1XXXXXXX', $phone);
    }
@endphp

@if($phone)
    <div class="relative group w-full flex justify-center items-center">
        <a 
            @if(!$isPause)
                href="tel:{{ $phone }}"
            @else
                href="#"
                aria-disabled="true"
            @endif
            class="font-roboto-slab flex items-center gap-2 font-bold transition-all duration-300
                {{ $class }}
                @if($isPause)
                    cursor-not-allowed pointer-events-none text-gray-500
                @else
                    hover:text-green-gs text-black
                @endif"
        >
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M19.95 21q-3.125 0-6.187-1.35T8.2 15.8t-3.85-5.55T3 4.05V3h5.9l.925 5.025l-2.85 2.875q.55.975 1.225 1.85t1.45 1.625q.725.725 1.588 1.388T13.1 17l2.9-2.9l5 1.025V21zM16.5 11q-.425 0-.712-.288T15.5 10t.288-.712T16.5 9t.713.288t.287.712t-.288.713T16.5 11" />
            </svg>
            {{ $displayPhone }}
        </a>

        @if($isPause)
            <x-badgePauseToolTip />
        @endif
    </div>

@endif
