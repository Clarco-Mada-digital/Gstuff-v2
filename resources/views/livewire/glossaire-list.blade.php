<div>
    <div class="mx-auto w-full md:w-[80%] -translate-y-[30%] xl:-translate-y-[50%]">
        <div class="flex flex-wrap items-center justify-center gap-3 rounded-md bg-white p-2 shadow-lg">
            @foreach (range('A', 'Z') as $letter)
                <div>
                    <input wire:model.live='lettreSearche' 
                           id="lettre{{ $letter }}" 
                           type="checkbox" 
                           value="{{ $letter }}"
                           class="peer hidden" />
                    <label for="lettre{{ $letter }}"
                           class="flex h-10 w-10 cursor-pointer items-center justify-center rounded-md border border-gray-300 text-base font-bold transition-all
                                  hover:bg-green-gs hover:text-white
                                  peer-checked:bg-green-gs peer-checked:text-white">
                        {{ $letter }}
                    </label>
                </div>
            @endforeach
            @if(count($lettreSearche) > 0)
                <button wire:click="$set('lettreSearche', [])" 
                        class="ml-2 rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300">
                    {{ __('Réinitialiser') }}
                </button>
            @endif
        </div>
    </div>

    <div class="mx-auto px-5 lg:container lg:p-10">
        @if($glossaires->count() > 0)
            @foreach ($glossaires as $glossaire)
                <div class="my-5 flex flex-col justify-center gap-1 text-sm xl:text-base">
                    <a href="{{ route('glossaires.show', $glossaire->slug) }}"
                       class="font-dm-serif text-2xl font-bold text-green-gs hover:underline xl:text-4xl">
                        {{ $glossaire->title }}
                    </a>
                    @if ($glossaire->excerpt)
                        <div class="prose max-w-none">{!! $glossaire->excerpt !!}</div>
                    @else
                        <div class="prose max-w-none">{!! Str::limit(strip_tags($glossaire->content), 200) !!}</div>
                    @endif
                </div>
            @endforeach
            <div class="mt-6">
                {{ $glossaires->links('pagination::simple-tailwind') }}
            </div>
        @else
            <div class="py-10 text-center">
                <p class="text-lg text-gray-600">{{ __('Aucun résultat trouvé pour la sélection actuelle.') }}</p>
            </div>
        @endif
    </div>
</div>
