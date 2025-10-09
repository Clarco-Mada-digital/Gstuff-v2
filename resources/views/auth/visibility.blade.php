@extends('layouts.base')

@php use Carbon\Carbon; @endphp

@section('pageTitle', __('visibility.title'))

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="rounded-xl bg-white p-6 shadow-lg sm:p-8">
            <h2 class="border-supaGirlRose text-green-gs font-roboto-slab mb-6 border-b-2 pb-4 text-2xl font-bold">
                {{ __('visibility.profile_visibility') }}
            </h2>

            <form x-data="visibility()" method="POST" action="{{ route('profile.visibility.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    {{-- Option Public --}}
                    <div
                        class="bg-fieldBg hover:border-supaGirlRose/50 relative flex items-start rounded-lg border-2 border-transparent p-4 transition-all duration-200">
                        <div class="flex h-5 items-center">
                            <input x-on:click="customVisibility=false" type="radio" name="visibility" value="public"
                                id="public-visibility" @checked(auth()->user()->visibility === 'public')
                                class="text-green-gs focus:ring-green-gs/50 h-5 w-5 border-gray-300">
                        </div>
                        <div class="ml-3 flex flex-col">
                            <label for="public-visibility"
                                class="text-green-gs font-roboto-slab block text-sm font-medium">{{ __('visibility.public.label') }}</label>
                            <span
                                class="text-textColorParagraph font-roboto-slab mt-1 block text-sm">{{ __('visibility.public.description') }}</span>
                        </div>
                    </div>

                    {{-- Option Private --}}
                    <div
                        class="bg-fieldBg hover:border-supaGirlRose/90 relative flex items-start rounded-lg border-2 border-transparent p-4 transition-all duration-200">
                        <div class="flex h-5 items-center">
                            <input x-on:click="customVisibility=false" type="radio" name="visibility" value="private"
                                id="private-visibility" @checked(auth()->user()->visibility === 'private')
                                class="text-green-gs focus:ring-green-gs/50 h-5 w-5 border-gray-300">
                        </div>
                        <div class="ml-3 flex flex-col">
                            <label for="private-visibility"
                                class="text-green-gs font-roboto-slab block text-sm font-medium">{{ __('visibility.private.label') }}</label>
                            <span
                                class="text-textColorParagraph font-roboto-slab mt-1 block text-sm">{{ __('visibility.private.description') }}</span>
                        </div>
                    </div>

                    {{-- Option Custom --}}
                    <div
                        class="bg-fieldBg hover:border-supaGirlRose/90 relative flex items-start rounded-lg border-2 border-transparent p-4 transition-all duration-200">
                        <div class="flex h-5 items-center">
                            <input type="radio" name="visibility" value="custom" id="custom-visibility"
                                x-model="customVisibility" @checked(auth()->user()->visibility === 'custom')
                                class="text-green-gs focus:ring-green-gs/50 h-5 w-5 border-gray-300">
                        </div>
                        <div class="ml-3 flex flex-col">
                            <label for="custom-visibility"
                                class="text-green-gs font-roboto-slab block text-sm font-medium">{{ __('visibility.custom.label') }}</label>
                            <span
                                class="text-textColorParagraph font-roboto-slab mt-1 block text-sm">{{ __('visibility.custom.description') }}</span>
                        </div>
                    </div>

                    {{-- Country Selector --}}
                    <div x-show="customVisibility" x-collapse
                        class="border-green-gs/50 bg-fieldBg mt-6 space-y-4 rounded-lg border-l-4 p-6 pl-8">
                        <h3 class="text-green-gs font-roboto-slab text-lg font-semibold">
                            {{ __('visibility.country_selector.title') }}
                        </h3>
                        <p class="text-textColorParagraph font-roboto-slab text-sm">
                            {{ __('visibility.country_selector.description') }}
                        </p>

                        <div x-data="countrySelector({{ Js::from(config('countries')) }}, {{ Js::from(auth()->user()->visible_countries ?? []) }})" class="relative">
                            <label
                                class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">{{ __('visibility.country_selector.title') }}</label>

                            <div
                                class="border-green-gs/50 focus-within:ring-green-gs/50 flex min-h-[48px] flex-wrap items-center rounded-xl border border-2 bg-white px-3 py-2 shadow-sm focus-within:ring-2">
                                <template x-for="(code, index) in selected" :key="code">
                                    <div
                                        class="bg-fieldBg text-green-gs mb-2 mr-2 flex items-center rounded-full px-3 py-1 text-sm">
                                        <span x-text="countries[code]"></span>
                                        <button type="button" @click="remove(code)"
                                            class="text-green-gs hover:text-green-gs ml-1">&times;</button>
                                        <input type="hidden" name="countries[]" :value="code">
                                    </div>
                                </template>

                                <input type="text" x-model="search" @focus="open = true"
                                    @keydown.arrow-down.prevent="navigate('next')"
                                    @keydown.arrow-up.prevent="navigate('prev')"
                                    @keydown.enter.prevent="select(Object.keys(filtered)[highlightedIndex])"
                                    @click.away="open = false"
                                    class="font-roboto-slab min-w-[120px] flex-1 border-none text-sm text-sm placeholder-gray-400 focus:ring-0"
                                    placeholder="{{ __('visibility.country_selector.placeholder') }}">
                            </div>

                            <div x-show="open && Object.keys(filtered).length > 0"
                                class="absolute z-10 mt-2 max-h-60 w-full overflow-y-auto rounded-xl border border-gray-200 bg-white px-5 shadow-lg">
                                <template x-for="(name, code) in filtered" :key="code">
                                    <div @click="select(code)"
                                        :class="{
                                            'bg-fieldBg text-green-gs': highlightedIndex === $index,
                                            'px-4 py-3 cursor-pointer hover:bg-fieldBg': true
                                        }"
                                        @mouseenter="highlightedIndex = $index">
                                        <span x-text="name"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap justify-between border-t border-gray-200 pt-6">
                    <button type="submit"
                        class="font-roboto-slab from-green-gs to-green-gs hover:from-green-gs/50 hover:to-green-gs/50 focus:ring-green-gs/50 inline-flex w-full items-center justify-center rounded-md border border-transparent bg-gradient-to-r px-6 py-3 text-white shadow-sm transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ __('visibility.save') }}
                    </button>

                    <a href="{{ route('profile.index') }}"
                        class="font-roboto-slab text-green-gs hover:bg-green-gs/50 focus:ring-green-gs/50 inline-flex w-full items-center justify-center rounded-md border border-transparent bg-white px-6 py-3 shadow-sm transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:w-auto">
                        {{ __('visibility.back') }}
                    </a>
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
