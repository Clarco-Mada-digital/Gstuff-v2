<div class="relative flex flex-col justify-start  w-full min-w-[270px] min-h-[405px] max-w-[330px] mx-auto mb-2 p-1 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700" style="scroll-snap-align: center">
    <div class="absolute flex items-center justify-center top-0 right-0 w-10 h-10 rounded-full bg-white m-2 text-green-gs cursor-pointer shadow-lg">
        {{-- @livewire('favorite-button', ['userId' => $escortId], key($escortId)) --}}
        <livewire:favorite-button :userId=$escortId wire:key='{{$escortId}}' />
    </div>
  

    <a class="m-auto w-full h-full rounded-lg overflow-hidden" href="{{route('show_escort', $escortId)}}">
        <img class="w-full h-[405px] object-cover rounded-t-lg" @if($avatar) src="{{ asset('storage/avatars/'.$avatar) }}" @else src="{{ asset('images/icon_logo.png') }}" @endif alt="image profile" />
    </a>
    <div class="flex flex-col gap-2 mt-4">
        <a class="flex items-center gap-1" href="{{route('show_escort', $escortId)}}">
            <h5 class="text-base tracking-tight text-gray-900 dark:text-white">{{ $name }}</h5>
            <div class="w-2 h-2 rounded-full {{ $isOnline ? 'bg-green-gs' : 'bg-gray-400' }}"></div>
        </a>
        <p class="font-normal text-gray-700 dark:text-gray-400">
            <span>{{$canton}}</span> @if($ville != '') <span> | {{$ville}}</span>@endif
        </p>
        @if($distance > 0)
        <!-- Vérification si distance est supérieure à 0 -->
        
            <div class="absolute flex items-center justify-center top-0 left-0  rounded-sm px-2 py-1 bg-white m-2 text-green-gs font-bold cursor-pointer shadow-lg">
              @if($distance < 1) {{ round($distance * 1000) }} m @else {{ round($distance) }} km @endif
            </div>
                @endif



    </div>
</div>
