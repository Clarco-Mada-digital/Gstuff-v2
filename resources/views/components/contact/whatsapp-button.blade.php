@props([
    'phone' => null,
    'noContactText' => __('escort_profile.no_whatsapp_contact'),
    'class' => '',
    'isPause' => false,
    'name' => null,
    'price' => null,
    'profileVerifier' => false,
])

@php
    $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
    $defaultMessage = urlencode(__('escort_profile.whatsapp_default_message', ['name' => $name]));
@endphp

<div x-data="{ openModal: false }" class="group relative w-full">
    <!-- Bouton principal -->
    <button @click="openModal = {{ $phone && !$isPause ? 'true' : 'false' }}"
        class="{{ $class }} @if ($isPause) cursor-not-allowed pointer-events-none bg-gray-200 text-gray-500 border-gray-300
            @else
                text-green-gs border-green-gs hover:bg-green-gs hover:text-white @endif flex w-full items-center justify-center gap-2 rounded-lg border p-2 text-sm transition-all duration-300"
        @if ($isPause) disabled @endif>
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g fill="none" fill-rule="evenodd">
                <path
                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                <path fill="currentColor"
                    d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2.546 20.2A1.01 1.01 0 0 0 3.8 21.454l3.032-.892A9.96 9.96 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2M9.738 14.263c2.023 2.022 3.954 2.289 4.636 2.314c1.037.038 2.047-.754 2.44-1.673a.7.7 0 0 0-.088-.703c-.548-.7-1.289-1.203-2.013-1.703a.71.71 0 0 0-.973.158l-.6.915a.23.23 0 0 1-.305.076c-.407-.233-1-.629-1.426-1.055s-.798-.992-1.007-1.373a.23.23 0 0 1 .067-.291l.924-.686a.71.71 0 0 0 .12-.94c-.448-.656-.97-1.49-1.727-2.043a.7.7 0 0 0-.684-.075c-.92.394-1.716 1.404-1.678 2.443c.025.682.292 2.613 2.314 4.636" />
            </g>
        </svg>
        @if ($phone)
            {{ __('escort_profile.contact_on_whatsapp') }}
        @else
            {{ $noContactText }}
        @endif
    </button>

    @if ($isPause)
        <x-badgePauseToolTip />
    @endif
    <!-- Modal WhatsApp --><!-- Modal WhatsApp -->
    <div x-show="openModal" x-transition x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="relative w-full max-w-lg rounded-lg bg-white p-6 shadow-xl">
            <!-- Bouton de fermeture en haut à droite -->
            <button @click="openModal = false" class="absolute right-3 top-3 text-gray-500 hover:text-gray-700"
                :aria-label="__('escort_profile.close')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Titre et badge -->
            <div class="mb-4 flex items-center space-x-2">
                <h2 class="text-xl font-bold text-gray-800">{{ __('escort_profile.contact_person', ['name' => $name]) }}
                </h2>
                @if ($profileVerifier)
                    <span
                        class="inline-flex items-center gap-1 rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">
                        ✅ {{ __('escort_profile.certifier') }}
                    </span>
                @endif
            </div>

            <!-- Mention -->
            <p class="text-supaGirlRose mb-2 text-center text-sm">
                {{ __('escort_profile.mention_contact_source') }} <strong>Supagirl.ch</strong>
            </p>

            <!-- Tarifs -->
            <p class="mb-4 text-center text-sm text-gray-700">
                💰 {{ __('escort_profile.prices_starting_from') }} <strong>{{ $price }}</strong> CHF
            </p>

            <!-- Boutons WhatsApp et Téléphone -->
            <div class="flex flex-row items-center justify-around">
                <!-- WhatsApp -->
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ $defaultMessage }}" target="_blank"
                    class="bg-supaGirlRose hover:bg-fieldBg hover:text-green-gs inline-flex w-1/3 items-center justify-center gap-2 rounded px-4 py-2 text-white">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g fill="none" fill-rule="evenodd">
                            <path
                                d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                            <path fill="currentColor"
                                d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2.546 20.2A1.01 1.01 0 0 0 3.8 21.454l3.032-.892A9.96 9.96 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2M9.738 14.263c2.023 2.022 3.954 2.289 4.636 2.314c1.037.038 2.047-.754 2.44-1.673a.7.7 0 0 0-.088-.703c-.548-.7-1.289-1.203-2.013-1.703a.71.71 0 0 0-.973.158l-.6.915a.23.23 0 0 1-.305.076c-.407-.233-1-.629-1.426-1.055s-.798-.992-1.007-1.373a.23.23 0 0 1 .067-.291l.924-.686a.71.71 0 0 0 .12-.94c-.448-.656-.97-1.49-1.727-2.043a.7.7 0 0 0-.684-.075c-.92.394-1.716 1.404-1.678 2.443c.025.682.292 2.613 2.314 4.636" />
                        </g>
                    </svg>
                    {{ __('WhatsApp') }}
                </a>

                <!-- Téléphone -->
                <a href="tel:{{ $cleanPhone }}"
                    class="inline-flex w-1/3 items-center justify-center gap-2 rounded bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm0 10a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2zm10-10a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zm0 10a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    {{ $phone }}
                </a>
            </div>
        </div>
    </div>

</div>
