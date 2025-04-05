<div>
    <div class="flex items-center justify-center md:justify-start py-5">
        <h2 class="font-dm-serif font-bold text-2xl">Les filles hot près de chez toi</h2>
    </div>
    @if ($escorts)
        <div class="w-full grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 items-center mb-4 gap-4">
            @foreach ($escorts as $escort)
                <livewire:escort-card 
                    name="{{ $escort['escort']['prenom'] }}" 
                    canton="{{ $escort['canton']['nom'] }}" 
                    ville="{{ $escort['ville']['nom'] }}" 
                    avatar="{{ $escort['escort']['avatar'] }}" 
                    escortId="{{ $escort['escort']['id'] }}" 
                />
            @endforeach
        </div>
    @else
        <div class="flex items-center justify-center py-10">
            <p class="text-gray-500 text-lg">Aucun résultat trouvé.</p>
        </div>
    @endif
</div>
