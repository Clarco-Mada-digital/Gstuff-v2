@props([
    'cantons' => [],
    'villes' => [],
    'selectedCanton' => null,
    'selectedVille' => null,
    'cantonName' => 'canton',
    'villeName' => 'ville',
    'cantonLabel' => 'Canton',
    'villeLabel' => 'Ville',
    'required' => false,
    'containerClass' => 'space-y-4',
])

<div class="{{ $containerClass }}" x-data="{
    selectedCanton: '{{ $selectedCanton }}',
    selectedVille: '{{ $selectedVille }}',
    villes: {{ json_encode($villes) }},
    availableVilles: {{ json_encode($villes) }},
    updateVilles() {
        this.villes = this.availableVilles.filter(ville =>
            this.selectedCanton ? (ville.canton_id == this.selectedCanton) : true
        );

        // Si une ville est déjà sélectionnée mais n'est pas dans la liste filtrée, on la réinitialise
        if (this.selectedVille && !this.villes.some(v => v.id == this.selectedVille)) {
            this.selectedVille = '';
        }
    },
    init() {
        // Filtrer les villes en fonction du canton sélectionné au chargement
        if (this.selectedCanton) {
            this.villes = this.availableVilles.filter(
                ville => ville.canton_id == this.selectedCanton
            );
        } else {
            this.villes = [];
        }

        // Mettre à jour les villes quand le canton change
        this.$watch('selectedCanton', (newVal) => {
            this.updateVilles();

            // Si le canton change, on réinitialise la ville sélectionnée
            if (newVal !== '{{ $selectedCanton }}') {
                this.selectedVille = '';
            }
        });
    }
}">
    <x-form.select x-model="selectedCanton" :name="$cantonName" :label="$cantonLabel" :selected="$selectedCanton"
        {{ $attributes->merge(['class' => 'w-full']) }}>
        <option value="">--</option>
        @foreach ($cantons as $canton)
            <option value="{{ $canton['id'] }}" {{ $selectedCanton == $canton['id'] ? 'selected' : '' }}>
                {{ $canton['nom'] }}
            </option>
        @endforeach
    </x-form.select>

    <x-form.select :name="$villeName" :label="$villeLabel" x-model="selectedVille" x-bind:disabled="!selectedCanton"
        {{ $attributes->merge(['class' => 'w-full']) }}
        x-on:change="localStorage.setItem('villeNom', $event.target.options[$event.target.selectedIndex].text)">
        <option value="">--</option>
        <template x-for="ville in villes" :key="ville.id">
            <option :value="ville.id" x-text="ville.nom" :selected="selectedVille == ville.id"></option>
        </template>
    </x-form.select>
</div>
