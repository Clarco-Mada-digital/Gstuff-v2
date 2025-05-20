<div class="relative mx-auto mb-2 flex min-h-[405px] w-full min-w-[270px] max-w-[330px] flex-col justify-start rounded-lg border border-gray-200 bg-white p-1 shadow-sm dark:border-gray-700 dark:bg-gray-800"
    style="scroll-snap-align: center">
    <div
        class="text-green-gs absolute right-0 top-0 m-2 flex h-10 w-10 items-center justify-center rounded-full bg-white p-3">
        {{-- @livewire('favorite-button', ['userId' => $salonId], key($salonId)) --}}
        <livewire:favorite-button :userId='$salonId' wire:key='{{ $salonId }}' />
    </div>
    <a class="m-auto w-full overflow-hidden rounded-lg" href="{{ route('show_salon', $salonId) }}">
        <img class="h-[405px] w-full rounded-t-lg object-cover"
            @if ($avatar) src="{{ asset('storage/avatars/' . $avatar) }}"
        @else
        src="{{ asset('images/icon_logo.png') }}" @endif
            alt="image profile" />
    </a>
    <div class="mt-4 flex flex-col gap-2">
        <a class="flex items-center gap-1" href="{{ route('show_salon', $salonId) }}">
            <h5 class="text-base tracking-tight text-gray-900 dark:text-white">{{ $name }}</h5>
            {{-- <div class="w-2 h-2 rounded-full bg-green-gs"></div> --}}
        </a>
        <p class="font-normal text-gray-700 dark:text-gray-400">
            <span>{{ $canton }}</span>
            @if ($ville != '')
                <span> | {{ $ville }}</span>
            @endif
        </p>
    </div>
</div>
