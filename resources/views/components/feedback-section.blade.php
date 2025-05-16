<!-- resources/views/components/feedback-section.blade.php -->
<div class="min-h-90 relative flex w-full items-center justify-center overflow-hidden py-10">
    <div class="absolute right-0 top-0 z-0 h-full w-full bg-[#E4F1F1]"></div>
    <div class="flex w-full flex-nowrap items-center justify-center gap-5 overflow-hidden">
        @foreach ($listcommentApprouved as $index => $item)
            <div
                class="shadow-sm transition-feed {{ $currentIndex === $index ? 'scale-75 translate-x-[-100%] z-10' : '' }} {{ $currentIndex === $index - 1 ? 'scale-100 translate-x-0 z-20' : '' }} {{ $currentIndex === $index - 2 ? 'scale-75 translate-x-[100%] z-10' : '' }} {{ $currentIndex !== $index && $currentIndex !== $index - 1 && $currentIndex !== $index - 2 ? 'translate-x-0 opacity-0 scale-50' : '' }} absolute flex h-[250px] w-full min-w-[400px] flex-shrink-0 flex-col items-center justify-center gap-7 rounded-lg bg-white p-5 text-xl duration-500 md:w-1/3 lg:w-[625px] lg:text-3xl">
                <p class="mx-auto w-[80%] text-center">
                    {{ $item->getTranslation('content', session('locale', 'fr')) ?: $item->content }}</p>
                <div class="flex w-full flex-col items-center justify-center gap-4 xl:flex-row">
                    <!-- Affichage de l'avatar de l'utilisateur -->
                    <img class="h-12 w-12 rounded-full" src="{{ get_gravatar($item->user->email) }}" alt="Avatar" />
                    <div class="flex flex-col font-bold">
                        <span
                            class="font-dm-serif text-base text-green-800 lg:text-2xl">{{ $item->user->pseudo ?? ($item->user->prenom ?? $item->user->nom_salon) }}</span>
                        <span
                            class="text-center text-sm lg:text-base xl:text-start">{{ $item->user->profile_type }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button onclick="prev()"
        class="absolute left-1 top-1/2 z-40 flex h-10 w-10 -translate-y-1/2 transform cursor-pointer items-center justify-center rounded-full bg-amber-300/60 shadow xl:left-10">
        ←
    </button>
    <button onclick="next()"
        class="absolute right-1 top-1/2 z-40 flex h-10 w-10 -translate-y-1/2 transform cursor-pointer items-center justify-center rounded-full bg-amber-300/60 shadow xl:right-10">
        →
    </button>
</div>

<style>
    .transition-feed {
        transition: all 1.5s ease-in-out;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentIndex = {{ $currentIndex }};

        function next() {
            if ({{ $listcommentApprouved->count() }} > 0) {
                currentIndex = (currentIndex + 1) % {{ $listcommentApprouved->count() }};
                updateCarousel();
            }
        }

        function prev() {
            if ({{ $listcommentApprouved->count() }} > 0) {
                currentIndex = (currentIndex - 1 + {{ $listcommentApprouved->count() }}) %
                    {{ $listcommentApprouved->count() }};
                updateCarousel();
            }
        }

        function updateCarousel() {
            const items = document.querySelectorAll('.transition-feed');
            items.forEach((item, index) => {
                item.classList.remove('scale-75', 'translate-x-[-100%]', 'z-10', 'scale-100',
                    'translate-x-0', 'z-20', 'translate-x-[100%]', 'opacity-0', 'scale-50');
                if (currentIndex === index) {
                    item.classList.add('scale-75', 'translate-x-[-100%]', 'z-10');
                } else if (currentIndex === index - 1) {
                    item.classList.add('scale-100', 'translate-x-0', 'z-20');
                } else if (currentIndex === index - 2) {
                    item.classList.add('scale-75', 'translate-x-[100%]', 'z-10');
                } else {
                    item.classList.add('translate-x-0', 'opacity-0', 'scale-50');
                }
            });
        }

        window.next = next;
        window.prev = prev;

        // Initialisation du carrousel
        updateCarousel();
    });
</script>
