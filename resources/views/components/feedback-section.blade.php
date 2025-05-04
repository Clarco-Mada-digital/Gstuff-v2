<!-- resources/views/components/feedback-section.blade.php -->
<div class="relative py-10 w-full min-h-90 overflow-hidden flex items-center justify-center">
    <div class="bg-[#E4F1F1] absolute top-0 right-0 w-full h-full z-0"></div>
    <div class="w-full flex items-center justify-center gap-5 flex-nowrap overflow-hidden">
        @foreach($listcommentApprouved as $index => $item)
            <div class="min-w-[400px] w-full lg:w-[625px] h-[250px] p-5 bg-white rounded-lg flex flex-col items-center justify-center gap-7 text-xl lg:text-3xl duration-500 flex-shrink-0 md:w-1/3 absolute transition-feed
                {{ $currentIndex === $index ? 'scale-75 translate-x-[-100%] z-10' : '' }}
                {{ $currentIndex === $index - 1 ? 'scale-100 translate-x-0 z-20' : '' }}
                {{ $currentIndex === $index - 2 ? 'scale-75 translate-x-[100%] z-10' : '' }}
                {{ $currentIndex !== $index && $currentIndex !== $index - 1 && $currentIndex !== $index - 2 ? 'translate-x-0 opacity-0 scale-50' : '' }}">
                <p class="text-center w-[80%] mx-auto mb-10">{{ $item->content }}</p>
                <div class="flex flex-col xl:flex-row items-center w-full justify-center gap-4">
                    <!-- Affichage de l'avatar de l'utilisateur -->
                    <img class="w-12 h-12 rounded-full"
                        src="{{ get_gravatar($item->user->email) }}"
                         {{-- src="{{ $item->user->avatar ? asset('storage/avatars/' . $item->user->avatar) : asset('images/icons/user_icon.svg') }}" --}}
                         alt="Avatar"/>
                    <div class="flex flex-col font-bold">
                        <span class="font-dm-serif text-base lg:text-2xl text-green-800">{{ $item->user->prenom }}</span>
                        <span class="text-sm text-center xl:text-start lg:text-base">{{ $item->user->profile_type }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button onclick="prev()"
            class="absolute left-1 xl:left-10 top-1/2 transform -translate-y-1/2 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer z-40">
        ←
    </button>
    <button onclick="next()"
            class="absolute right-1 xl:right-10 top-1/2 transform -translate-y-1/2 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer z-40">
        →
    </button>
</div>

<style>
    .transition-feed {
        transition: all 1.5s ease-in-out;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentIndex = {{ $currentIndex }};

        function next() {
            if ({{ $listcommentApprouved->count() }} > 0) {
                currentIndex = (currentIndex + 1) % {{ $listcommentApprouved->count() }};
                updateCarousel();
            }
        }

        function prev() {
            if ({{ $listcommentApprouved->count() }} > 0) {
                currentIndex = (currentIndex - 1 + {{ $listcommentApprouved->count() }}) % {{ $listcommentApprouved->count() }};
                updateCarousel();
            }
        }

        function updateCarousel() {
            const items = document.querySelectorAll('.transition-feed');
            items.forEach((item, index) => {
                item.classList.remove('scale-75', 'translate-x-[-100%]', 'z-10', 'scale-100', 'translate-x-0', 'z-20', 'translate-x-[100%]', 'opacity-0', 'scale-50');
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
