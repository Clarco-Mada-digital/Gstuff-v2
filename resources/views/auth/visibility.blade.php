@extends('layouts.base')
@php use Carbon\Carbon; @endphp
@section('title', 'Paramètres de visibilité du profil')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">
            🌍 Visibilité du profil
        </h2>

        <form x-data="visibility()" method="POST" action="{{ route('profile.visibility.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                {{-- Option Public --}}
                <div class="relative flex items-start p-4 rounded-lg border-2 border-transparent hover:border-blue-100 transition-all duration-200 bg-gray-50">
                    <div class="flex items-center h-5">
                        <input type="radio" name="visibility" value="public"
                               @checked(auth()->user()->visibility === 'public')
                               class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                    </div>
                    <div class="ml-3 flex flex-col">
                        <span class="block text-sm font-medium text-gray-900">Profil public</span>
                        <span class="block text-sm text-gray-500 mt-1">Visible dans tous les pays sans restriction</span>
                    </div>
                </div>

                {{-- Option Private --}}
                <div class="relative flex items-start p-4 rounded-lg border-2 border-transparent hover:border-red-100 transition-all duration-200 bg-gray-50">
                    <div class="flex items-center h-5">
                        <input type="radio" name="visibility" value="private"
                               @checked(auth()->user()->visibility === 'private')
                               class="h-5 w-5 text-red-600 focus:ring-red-500 border-gray-300">
                    </div>
                    <div class="ml-3 flex flex-col">
                        <span class="block text-sm font-medium text-gray-900">Profil privé</span>
                        <span class="block text-sm text-gray-500 mt-1">Caché dans tous les pays</span>
                    </div>
                </div>

                {{-- Option Custom --}}
                <div class="relative flex items-start p-4 rounded-lg border-2 border-transparent hover:border-purple-100 transition-all duration-200 bg-gray-50">
                    <div class="flex items-center h-5">
                        <input type="radio" name="visibility" value="custom"
                               x-model="customVisibility"
                               @checked(auth()->user()->visibility === 'custom')
                               class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300">
                    </div>
                    <div class="ml-3 flex flex-col">
                        <span class="block text-sm font-medium text-gray-900">Visibilité personnalisée</span>
                        <span class="block text-sm text-gray-500 mt-1">Choisissez les pays où votre profil sera visible</span>
                    </div>
                </div>

                {{-- Country Selector --}}
                <div x-show="customVisibility" x-collapse class="mt-6 pl-8 border-l-4 border-purple-200 bg-purple-50 rounded-lg p-6 space-y-4">
                    <h3 class="text-lg font-semibold text-purple-800">
                        Sélection des pays autorisés
                    </h3>
                    <p class="text-sm text-purple-700">
                        Sélectionnez un ou plusieurs pays dans la liste ci-dessous
                    </p>

                    <div x-data="countrySelector({{ Js::from(config('countries')) }}, {{ Js::from(auth()->user()->visible_countries ?? []) }})" class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pays autorisés</label>

                        <div class="flex flex-wrap items-center border rounded-xl bg-white px-3 py-2 focus-within:ring-2 focus-within:ring-purple-500 shadow-sm min-h-[48px]">
                            <template x-for="(code, index) in selected" :key="code">
                                <div class="flex items-center bg-purple-100 text-purple-800 rounded-full px-3 py-1 mr-2 mb-2 text-sm">
                                    <span x-text="countries[code]"></span>
                                    <button type="button" @click="remove(code)" class="ml-1 text-purple-500 hover:text-purple-800">&times;</button>
                                    <input type="hidden" name="countries[]" :value="code">
                                </div>
                            </template>

                            <input
                                type="text"
                                x-model="search"
                                @focus="open = true"
                                @keydown.arrow-down.prevent="navigate('next')"
                                @keydown.arrow-up.prevent="navigate('prev')"
                                @keydown.enter.prevent="select(Object.keys(filtered)[highlightedIndex])"
                                @click.away="open = false"
                                class="flex-1 min-w-[120px] border-none focus:ring-0 text-sm placeholder-gray-400"
                                placeholder="Rechercher un pays..."
                            >
                        </div>

                        <div x-show="open && Object.keys(filtered).length > 0" class="absolute z-10 mt-2 w-full bg-white border border-gray-200 rounded-xl shadow-lg max-h-60 overflow-y-auto">
                            <template x-for="(name, code) in filtered" :key="code">
                                <div
                                    @click="select(code)"
                                    :class="{
                                        'bg-purple-100 text-purple-800': highlightedIndex === $index,
                                        'px-4 py-2 cursor-pointer hover:bg-purple-50': true
                                    }"
                                    @mouseenter="highlightedIndex = $index"
                                >
                                    <span x-text="name"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-200">
                <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-150">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
@stop

@section('extraScripts')
<script>
    function visibility() {
        return {
            customVisibility: {{ auth()->user()->visibility === 'custom' ? 'true' : 'false' }},
        };
    }

    function countrySelector(allCountries, initialSelected = []) {
        return {
            countries: allCountries,
            selected: [...initialSelected],
            search: '',
            open: false,
            highlightedIndex: 0,
            get filtered() {
                let results = {};
                const term = this.search.toLowerCase();
                for (const [code, name] of Object.entries(this.countries)) {
                    if (
                        name.toLowerCase().includes(term) &&
                        !this.selected.includes(code)
                    ) {
                        results[code] = name;
                    }
                }
                return results;
            },
            select(code) {
                if (!this.selected.includes(code)) {
                    this.selected.push(code);
                }
                this.search = '';
                this.open = false;
                this.highlightedIndex = 0;
            },
            remove(code) {
                this.selected = this.selected.filter(c => c !== code);
            },
            navigate(direction) {
                const keys = Object.keys(this.filtered);
                if (direction === 'next') {
                    this.highlightedIndex = (this.highlightedIndex + 1) % keys.length;
                } else if (direction === 'prev') {
                    this.highlightedIndex = (this.highlightedIndex - 1 + keys.length) % keys.length;
                }
            }
        };
    }
</script>
@endsection
