@props([
    'user' => null,
])



<div class="mx-2 my-2 w-[90%]">
    <!-- Bouton d'ouverture de la modale Pause -->
    <button data-modal-target="pauseProfile" data-modal-toggle="pauseProfile"
        class="border-supaGirlRose font-roboto-slab text-green-gs hover:bg-green-gs flex w-full cursor-pointer items-center justify-center gap-3 rounded-lg border bg-white p-1 text-sm shadow-sm transition duration-200 hover:text-white">
        <!-- Icône cerclée -->
        <div class="bg-supaGirlRosePastel flex items-center justify-center rounded-full p-1">
            @if ($user->is_profil_pause)
                <!-- Icône d’activation -->
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            @else
                <!-- Icône de pause -->
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6" />
                </svg>
            @endif
        </div>
        <!-- Texte -->
        <span>
            {{ $user->is_profil_pause ? __('gestionPause.active') : __('gestionPause.pause') }}
        </span>
    </button>

    <!-- Modale -->
    <div id="pauseProfile" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 flex hidden items-center justify-center overflow-y-auto bg-black/30 px-4 py-8">

        <div class="relative w-full max-w-3xl rounded-lg bg-white shadow-lg">
            <!-- Header -->
            <div
                class="font-roboto-slab flex items-center justify-between rounded-t border-b border-gray-200 px-6 py-4">
                <h3 class="text-green-gs text-xl font-semibold">
                    {{ $user->is_profil_pause ? __('gestionPause.active') : __('gestionPause.pause') }}
                </h3>
                <button type="button" data-modal-hide="pauseProfile"
                    class="hover:text-green-gs text-gray-400 transition">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Contenu du formulaire -->
            <form class="space-y-4 px-6 py-4" action="{{ route('profile.pause') }}" method="POST">
                @csrf
                <!-- Ajoute ici tes champs -->
                <p class="font-roboto-slab text-sm text-gray-600">
                    {{ $user->is_profil_pause ? __('gestionPause.contentmodalactive') : __('gestionPause.contentmodalpause') }}
                </p>

                <div class="flex justify-end gap-2">
                    <button type="button" data-modal-hide="pauseProfile"
                        class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-100">
                        {{ __('gestionPause.cancel') }}
                    </button>
                    <button type="submit"
                        class="bg-green-gs hover:bg-supaGirlRose rounded-md px-4 py-2 text-sm text-white transition">
                        {{ __('gestionPause.confirm') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bannière de réactivation -->
    <div id="reactivationBanner"
        class="bg-green-gs font-roboto-slab fixed left-0 right-0 top-0 z-50 flex hidden items-center justify-between px-6 py-4 text-sm text-white shadow-md">
        <div class="flex items-center gap-4">
            <span>
                {{ __('gestionPause.reactivationBanner') }}
            </span>
            <button data-modal-target="pauseProfile" data-modal-toggle="pauseProfile"
                class="text-green-gs hover:bg-supaGirlRose rounded-md bg-white px-3 py-1 text-xs font-semibold transition hover:text-white">
                {{ __('gestionPause.reactivationBannerButton') }}
            </button>
        </div>

        <!-- Bouton de fermeture -->
        <button onclick="document.getElementById('reactivationBanner').classList.add('hidden')"
            class="text-white transition hover:text-gray-200">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const user = @json(auth()->user());
            const banner = document.getElementById('reactivationBanner');
            const loader = document.getElementById('loader');

            const showBanner = () => {
                if (!user.is_profil_pause || !banner) return;

                const lastClosed = localStorage.getItem('reactivationBannerLastClosed');
                const now = Date.now();

                // Si jamais fermé, vérifier si 30 minutes sont passées
                if (!lastClosed || now - parseInt(lastClosed) > 30 * 60 * 1000) {
                    banner.classList.remove('hidden');

                    // Auto-hide après 10 secondes
                    setTimeout(() => {
                        banner.classList.add('hidden');
                        localStorage.setItem('reactivationBannerLastClosed', Date.now().toString());
                    }, 10000);
                }
            };

            if (loader && !loader.classList.contains('hidden')) {
                const observer = new MutationObserver(() => {
                    if (loader.classList.contains('hidden')) {
                        showBanner();
                        observer.disconnect();
                    }
                });

                observer.observe(loader, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            } else {
                showBanner();
            }
        });

        // Fonction appelée par le bouton de fermeture
        function closeReactivationBanner() {
            const banner = document.getElementById('reactivationBanner');
            if (banner) {
                banner.classList.add('hidden');
                localStorage.setItem('reactivationBannerLastClosed', Date.now().toString());
            }
        }
    </script>
@endpush
