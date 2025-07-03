<div>
    <div class="mx-auto w-full md:w-[80%] -translate-y-[30%] xl:-translate-y-[50%] xl:w-[90%] 2xl:w-[80%] ">
        <div class="flex flex-wrap items-center justify-center gap-3 rounded-md bg-white p-2 shadow-lg xl:flex-wrap 2xl:flex-nowrap">
            @foreach (range('A', 'Z') as $letter)
                <div>
                    <input wire:model.live='lettreSearche' 
                           id="lettre{{ $letter }}" 
                           type="checkbox" 
                           value="{{ $letter }}"
                           class="peer hidden" />
                    <label for="lettre{{ $letter }}"
                           class="flex h-10 w-10 2xl:h-8 2xl:w-8 cursor-pointer items-center justify-center rounded-md border border-supaGirlRose 
                           border-2 font-roboto-slab font-bold transition-all hover:bg-green-gs hover:text-white
                           peer-checked:bg-green-gs peer-checked:text-white text-green-gs">
                        {{ $letter }}
                    </label>
                </div>
            @endforeach
            @if(count($lettreSearche) > 0)
                <button wire:click="$set('lettreSearche', [])" 
                        class="ml-2 rounded border border-2 border-green-gs bg-white px-4 py-2 text-sm font-medium text-green-gs hover:bg-green-gs hover:text-white transition-all">
                    {{ __('glossary.reset') }}
                </button>
            @endif
        </div>
    </div>

    <div class="mx-auto px-5 lg:container lg:p-10">
        @if($glossaires->count() > 0)
            @foreach ($glossaires as $glossaire)
                <div class="my-5 flex flex-col justify-center gap-1 text-sm xl:text-base">
                    <a href="{{ route('glossaires.show', $glossaire->slug) }}"
                       class="font-roboto-slab text-2xl font-bold text-green-gs hover:underline xl:text-4xl">
                        {{ $glossaire->title }}
                    </a>
                    @if ($glossaire->excerpt)
                        <div class="prose max-w-none font-roboto-slab text-textColorParagraph">{!! $glossaire->excerpt !!}</div>
                    @else
                        <div class="prose max-w-none font-roboto-slab text-textColorParagraph">{!! Str::limit(strip_tags($glossaire->content), 200) !!}</div>
                    @endif
                </div>
            @endforeach
            <div class="mt-6">
                {{ $glossaires->links('pagination::simple-tailwind') }}
            </div>
        @else
            <div class="py-10 text-center">
                <p class="text-lg text-gray-600">{{ __('glossary.noresult') }}</p>
            </div>
        @endif
    </div>
</div>
