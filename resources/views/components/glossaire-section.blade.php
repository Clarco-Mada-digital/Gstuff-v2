{{-- Glossaire --}}
<div class="relative w-full py-4 px-4 sm:px-6 lg:px-8">
    <div class="relative">
        <!-- Conteneur des cartes avec défilement -->
        <div id="glossaire-container" 
             class="flex w-full flex-nowrap items-stretch gap-6 overflow-x-auto  scroll-smooth px-2"
             style="scroll-snap-type: x mandatory; scrollbar-width: none; -ms-overflow-style: none;"
             data-slider-wrapper>
            @foreach ($glossaires as $item)
                <a href="{{ route('glossaires.show', $item->slug) }}" class="group flex-shrink-0 w-[280px] sm:w-[320px] md:w-[350px]"
                   style="scroll-snap-align: start" data-carousel-item>
                    <div class="bg-green-gs h-full rounded-xl shadow-lg overflow-hidden transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl">
                        <div class="p-6 h-full flex flex-col">
                            <h4 class="font-dm-serif text-xl sm:text-2xl font-bold text-white mb-3 line-clamp-2">
                                {{ $item->title }}
                            </h4>
                            <p class="text-gray-200 text-sm sm:text-base mb-4 flex-1 line-clamp-3">
                                {!! strip_tags(Str::limit($item->excerpt, 120, '...')) !!}
                            </p>
                            <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-200">
                                <span class="text-amber-300 text-sm font-medium">
                                    {{ __('home.read_more') }}
                                </span>
                                <svg class="w-5 h-5 text-amber-300 transform transition-transform group-hover:translate-x-1" 
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Bouton Précédent -->
        <button id="arrowScrollRight"
            class="absolute -left-4 top-1/2 -translate-y-1/2 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 shadow-lg text-green-700 hover:bg-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 z-10"
            data-carousel-prev
            aria-label="{{ __('Précédent') }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Bouton Suivant -->
        <button id="arrowScrollLeft"
            class="absolute -right-4 top-1/2 -translate-y-1/2 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 shadow-lg text-green-700 hover:bg-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 z-10"
            data-carousel-next
            aria-label="{{ __('Suivant') }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        const items = container.querySelectorAll('[data-carousel-item]');
        let currentIndex = 0;
        const itemWidth = items[0]?.offsetWidth + 24; // Largeur d'un élément + gap

        // Fonction pour mettre à jour la visibilité des flèches
        function updateArrows() {
            const containerWidth = container.offsetWidth;
            const scrollWidth = container.scrollWidth;
            const scrollLeft = container.scrollLeft;
            
            // Afficher/masquer les flèches en fonction de la position de défilement
            rightBtn.style.display = scrollLeft > 0 ? 'flex' : 'none';
            leftBtn.style.display = scrollLeft < (scrollWidth - containerWidth - 10) ? 'flex' : 'none';
        }

        // Écouteurs d'événements pour les boutons
        rightBtn.addEventListener('click', () => {
            container.scrollBy({ left: -itemWidth, behavior: 'smooth' });
        });

        leftBtn.addEventListener('click', () => {
            container.scrollBy({ left: itemWidth, behavior: 'smooth' });
        });

        // Mettre à jour les flèches au chargement et au redimensionnement
        window.addEventListener('resize', updateArrows);
        container.addEventListener('scroll', updateArrows);
        updateArrows(); // Initial call
    });
</script>
