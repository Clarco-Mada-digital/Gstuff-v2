<div>
<div class="mx-auto w-full -translate-y-[30%] md:w-[80%] xl:w-[90%] xl:-translate-y-[50%] 2xl:w-[80%]">
    <!-- Lettres visibles par défaut -->
    <div class="flex flex-wrap items-center justify-center gap-3 rounded-md bg-white p-2 shadow-lg">
        @foreach (range('A', 'Z') as $index => $letter)
            <div class="{{ $index >= 7 ? 'hidden sm:flex' : '' }} lettre-item">
                <input wire:model.live='lettreSearche' id="lettre{{ $letter }}" type="checkbox"
                    value="{{ $letter }}" class="peer hidden" />
                <label for="lettre{{ $letter }}"
                    class="border-supaGirlRose font-roboto-slab hover:bg-green-gs peer-checked:bg-green-gs text-green-gs flex text-xs h-6 w-6 cursor-pointer items-center justify-center rounded-md border border-2 font-bold transition-all hover:text-white peer-checked:text-white 2xl:h-8 2xl:w-8">
                    {{ $letter }}
                </label>
            </div>
        @endforeach

        @if (count($lettreSearche) > 0)
            <button wire:click="$set('lettreSearche', [])"
                class="border-green-gs text-green-gs hover:bg-green-gs ml-2 rounded border border-2 bg-white px-2 py-1 md:px-4 md:py-2 text-xs md:text-sm font-medium transition-all hover:text-white">
                {{ __('glossary.reset') }}
            </button>
        @endif

       <!-- Bouton flèche pour afficher/masquer -->
<button onclick="toggleLetters()" class="sm:hidden ml-2 text-green-gs text-sm font-semibold flex items-center justify-center  bg-supaGirlRose p-1 rounded-md text-xs md:text-sm font-medium transition-all hover:text-white">
    <span id="toggleText"></span>
    <svg id="toggleArrow" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 20 20">
        <path d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"/>
    </svg>
</button>

    </div>
</div>


    <div class="mx-auto px-5 lg:container lg:p-10">
        @if ($glossaires->count() > 0)
            @foreach ($glossaires as $glossaire)
                <div class="my-5 flex flex-col justify-center gap-1 text-sm xl:text-base">
                    <a href="{{ route('glossaires.show', $glossaire->slug) }}"
                        class="font-roboto-slab text-green-gs text-md md:text-2xl font-bold hover:underline xl:text-4xl">
                        {{ $glossaire->title }}
                    </a>
                    @if ($glossaire->excerpt)
                        <div class="prose font-roboto-slab text-xs md:text-sm text-textColorParagraph max-w-none">{!! $glossaire->excerpt !!}
                        </div>
                    @else
                        <div class="prose font-roboto-slab text-xs md:text-sm text-textColorParagraph max-w-none">{!! Str::limit(strip_tags($glossaire->content), 200) !!}
                        </div>
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
<script>
     let expanded = false;
     function toggleLetters() {
        document.querySelectorAll('.lettre-item').forEach((el, index) => {
            if (index >= 7) {
                el.classList.toggle('hidden');
            }
        });

        expanded = !expanded;

        // Met à jour le texte
        // document.getElementById('toggleText').textContent = expanded ? 'Réduire' : 'Afficher plus';

        // Met à jour la flèche
        document.getElementById('toggleArrow').innerHTML = expanded
            ? '<path d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.83l-3.71 3.94a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z"/>'
            : '<path d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"/>';
    }
</script>