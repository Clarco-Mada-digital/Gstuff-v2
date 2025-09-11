<div
    class="bg-supaGirlRosePastel border-supaGirlRose group relative flex items-center gap-2 rounded-lg border md:px-3 px-2 md:py-2 py-1 shadow-sm">
    <!-- Certified text -->
    <span class="text-green-gs font-roboto-slab text-xs md:text-sm font-bold tracking-wide">
        {{ __('common.certified') }}
    </span>

    <!-- Icon -->
    <img src="{{ asset('images/icons/certifier.png') }}"
        alt="{{ __('common.certified') }}" class="h-4 w-4 sm:h-5 sm:w-5">

    <!-- Tooltip -->
    <div
        class="bg-green-gs pointer-events-none absolute bottom-full left-1/2 z-10 mb-2 -translate-x-1/2 whitespace-nowrap rounded px-2 py-1 text-xs text-white opacity-0 transition-opacity duration-200 group-hover:opacity-100">
        {{ __('common.certified_tooltip') }}
    </div>
</div>
