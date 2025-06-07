@php
    $user = App\Models\User::find($escortId);
@endphp
<div class="relative mx-auto mb-2 flex h-full min-h-[405px] w-full min-w-[270px] max-w-[330px] flex-col justify-start rounded-lg border border-gray-200 bg-white p-1 shadow-sm dark:border-gray-700 dark:bg-gray-800"
    style="scroll-snap-align: center">
    <div
        class="text-green-gs absolute right-0 top-0 m-2 flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-white shadow-lg">
        <livewire:favorite-button :userId=$escortId wire:key='{{ $escortId }}' />
    </div>

    <a class="m-auto h-full w-full overflow-hidden rounded-lg"
        @if ($user->profile_type == 'escorte') href="{{ route('show_escort', $escortId) }}" @else href="{{ route('show_salon', $escortId) }}" @endif>
        <img class="h-[405px] w-full rounded-t-lg object-cover"
            @if ($avatar) src="{{ asset('storage/avatars/' . $avatar) }}" @else src="{{ asset('images/icon_logo.png') }}" @endif
            alt="image profile" />
    </a>
    <div class="mt-4 flex flex-col gap-2">
        <a class="flex items-center gap-1"
            @if ($user->profile_type == 'escorte') href="{{ route('show_escort', $escortId) }}" @else href="{{ route('show_salon', $escortId) }}" @endif>
            <h5 class="text-base tracking-tight text-gray-900 dark:text-white">{{ $name }}</h5>
            <div class="{{ $isOnline ? 'bg-green-gs' : 'bg-gray-400' }} h-2 w-2 rounded-full"></div>
        </a>
        <p class="font-normal text-gray-700 dark:text-gray-400">
            <span>{{ $canton }}</span>
            @if ($ville != '')
                <span> | {{ $ville }}</span>
            @endif
        </p>
        @if ($distance > 0)
            <!-- Vérification si distance est supérieure à 0 -->

            <div
                class="text-green-gs absolute left-0 top-0 m-2 flex cursor-pointer items-center justify-center rounded-sm bg-white px-2 py-1 font-bold shadow-lg">
                @if ($distance < 1)
                    {{ round($distance * 1000) }} m
                @else
                    {{ round($distance) }} km
                @endif
            </div>
        @endif



    </div>
</div>
