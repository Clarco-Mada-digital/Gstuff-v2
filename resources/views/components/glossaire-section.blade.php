{{-- Glossaire --}}
<div class="relative w-full px-4 py-4 sm:px-6 lg:px-8">
    <div class="relative">
        <!-- Conteneur des cartes avec défilement -->
        <div id="glossaire-container"
            class="flex w-full flex-nowrap items-stretch gap-6 overflow-x-auto scroll-smooth px-2"
            style="scroll-snap-type: x mandatory; scrollbar-width: none; -ms-overflow-style: none;" data-slider-wrapper>
            @foreach ($glossaires as $item)
                <a href="{{ route('glossaires.show', $item->slug) }}"
                    class="group w-[280px] flex-shrink-0 sm:w-[320px] md:w-[350px]" style="scroll-snap-align: start"
                    data-carousel-item>
                    <div
                        class="bg-green-gs h-full transform overflow-hidden rounded-xl shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-xl">
                        <div class="flex h-full flex-col p-6">
                            <h4 class="font-roboto-slab mb-3 line-clamp-2 text-sm md:text-xl font-bold text-white sm:text-2xl">
                                {{ $item->title }}
                            </h4>
                            <p class="font-dm md:mb-4 line-clamp-3 flex-1 text-xs md:text-sm text-gray-200">
                                {!! strip_tags(Str::limit($item->excerpt, 120, '...')) !!}
                            </p>
                            <div class="mt-auto flex items-center justify-between border-t border-gray-200 pt-3">
                                <span class="font-dm text-supaGirlRosePastel text-xs md:text-sm font-medium">
                                    {{ __('home.read_more') }}
                                </span>
                                <svg class="text-supaGirlRosePastel h-5 w-5 transform transition-transform group-hover:translate-x-1"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Bouton Précédent -->
        <button id="arrowScrollRight"
            class="text-green-gs focus:ring-green-gs/65 absolute -left-4 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 shadow-lg transition-all duration-200 hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2"
            data-carousel-prev aria-label="{{ __('Précédent') }}">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Bouton Suivant -->
        <button id="arrowScrollLeft"
            class="text-green-gs focus:ring-green-gs/65 absolute -right-4 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 shadow-lg transition-all duration-200 hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2"
            data-carousel-next aria-label="{{ __('Suivant') }}">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rightBtn = document.getElementById('arrowScrollRight');
        const leftBtn = document.getElementById('arrowScrollLeft');
        const container = document.getElementById('glossaire-container');
        const originalItems = Array.from(container.querySelectorAll('[data-carousel-item]'));
        
        if (originalItems.length === 0) return;

        // Cloner les éléments pour créer un effet infini
        const cloneCount = 2; // Nombre de fois qu'on clone la liste
        for (let i = 0; i < cloneCount; i++) {
            originalItems.forEach(item => {
                const clone = item.cloneNode(true);
                container.appendChild(clone);
            });
        }

        // Ajouter aussi des clones au début
        for (let i = 0; i < cloneCount; i++) {
            originalItems.slice().reverse().forEach(item => {
                const clone = item.cloneNode(true);
                container.insertBefore(clone, container.firstChild);
            });
        }

        const allItems = container.querySelectorAll('[data-carousel-item]');
        const itemWidth = originalItems[0].offsetWidth + 24; // Largeur + gap
        const totalOriginalWidth = itemWidth * originalItems.length;

        // Positionner au début de la section originale (après les clones du début)
        container.scrollLeft = totalOriginalWidth * cloneCount;

        let isScrolling = false;

        // Fonction pour gérer le défilement infini
        function handleInfiniteScroll() {
            if (isScrolling) return;

            const scrollLeft = container.scrollLeft;
            const maxScroll = container.scrollWidth - container.offsetWidth;

            // Si on atteint la fin, revenir au début de la section originale
            if (scrollLeft >= maxScroll - 10) {
                isScrolling = true;
                container.scrollLeft = totalOriginalWidth * cloneCount;
                setTimeout(() => isScrolling = false, 50);
            }
            // Si on atteint le début, aller à la fin de la section originale
            else if (scrollLeft <= 10) {
                isScrolling = true;
                container.scrollLeft = totalOriginalWidth * cloneCount;
                setTimeout(() => isScrolling = false, 50);
            }
        }

        // Fonction de défilement
        function scrollCarousel(direction) {
            container.scrollBy({
                left: direction * itemWidth,
                behavior: 'smooth'
            });
        }

        // Écouteurs d'événements
        rightBtn.addEventListener('click', () => scrollCarousel(-1));
        leftBtn.addEventListener('click', () => scrollCarousel(1));

        container.addEventListener('scroll', handleInfiniteScroll);

        // Les flèches sont toujours visibles pour un carrousel infini
        rightBtn.style.display = 'flex';
        leftBtn.style.display = 'flex';
    });
</script>