<div class="relative group">
    <div class=" bg-supaGirlRosePastel rounded-full flex items-center justify-center">
        <!-- Icône de pause -->
        <svg class="w-6 h-6 text-green-gs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6" />
        </svg>
    </div>

    <!-- Tooltip -->
    <div class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 
                bg-supaGirlRose text-white text-xs rounded py-1 px-2 opacity-0 
                group-hover:opacity-100 transition-opacity duration-300 z-10 whitespace-nowrap">
        {{ __('gestionPause.badgePause') }}
    </div>
</div>