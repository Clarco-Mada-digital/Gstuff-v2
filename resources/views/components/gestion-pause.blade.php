@props([
    'user' => null,
])



<div class="w-[90%] mx-2 my-2">
    <!-- Bouton d'ouverture de la modale Pause -->
    <button 
        data-modal-target="pauseProfile" 
        data-modal-toggle="pauseProfile"
        class="w-full  flex items-center justify-center gap-3 cursor-pointer rounded-lg border border-supaGirlRose bg-white p-1 text-sm font-roboto-slab text-green-gs transition duration-200 hover:bg-green-gs hover:text-white shadow-sm">
        <!-- Icône cerclée -->
        <div class="p-1 bg-supaGirlRosePastel rounded-full flex items-center justify-center">
            @if ($user->is_profil_pause)
                <!-- Icône d’activation -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            @else
                <!-- Icône de pause -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    <div 
        id="pauseProfile" 
        tabindex="-1" 
        aria-hidden="true"
        class="fixed inset-0 z-50 hidden flex items-center justify-center overflow-y-auto bg-black/30 px-4 py-8">

        <div class="relative w-full max-w-3xl rounded-lg bg-white shadow-lg">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 rounded-t font-roboto-slab">
                <h3 class="text-xl font-semibold text-green-gs">
                    {{ $user->is_profil_pause ? __('gestionPause.active') : __('gestionPause.pause') }}
                </h3>
                <button 
                    type="button" 
                    data-modal-hide="pauseProfile" 
                    class="text-gray-400 hover:text-green-gs transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Contenu du formulaire -->
            <form class="px-6 py-4 space-y-4" action="{{ route('profile.pause') }}" method="POST">
                @csrf
                <!-- Ajoute ici tes champs -->
                <p class="text-sm text-gray-600 font-roboto-slab">
                    {{ $user->is_profil_pause ? __('gestionPause.contentmodalactive') : __('gestionPause.contentmodalpause') }}
                </p>

                <div class="flex justify-end gap-2">
                    <button type="button" data-modal-hide="pauseProfile"
                        class="px-4 py-2 rounded-md border border-gray-300 text-sm text-gray-700 hover:bg-gray-100 transition">
                        {{ __('gestionPause.cancel') }}
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-md bg-green-gs text-white text-sm hover:bg-supaGirlRose transition">
                        {{ __('gestionPause.confirm') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bannière de réactivation -->
    <div id="reactivationBanner" class="hidden fixed top-0 left-0 right-0 z-50 bg-green-gs text-white px-6 py-4 shadow-md flex items-center justify-between font-roboto-slab text-sm">
        <div class="flex items-center gap-4">
            <span>
                {{ __('gestionPause.reactivationBanner') }}
            </span>
            <button 
                data-modal-target="pauseProfile" 
                data-modal-toggle="pauseProfile"
                class="bg-white text-green-gs px-3 py-1 rounded-md text-xs font-semibold hover:bg-supaGirlRose hover:text-white transition">
                {{ __('gestionPause.reactivationBannerButton') }}
            </button>
        </div>

        <!-- Bouton de fermeture -->
        <button onclick="document.getElementById('reactivationBanner').classList.add('hidden')" 
            class="text-white hover:text-gray-200 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div> 
</div>
                
                
@push('scripts')
    
             
<script>
    document.addEventListener('DOMContentLoaded', function () {
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

                observer.observe(loader, { attributes: true, attributeFilter: ['class'] });
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