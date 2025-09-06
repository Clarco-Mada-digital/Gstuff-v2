@extends('layouts.base')

@section('pageTitle', $glossaire->title)

@section('content')
    <div class="relative flex min-h-72 w-full items-center justify-center bg-cover bg-center"
        style="background-image: url('../images/girl_deco_sp.jpg')">
        <div class="absolute inset-0 opacity-50"
            style="background: linear-gradient(to right, var(--color-supaGirlRose), var(--color-green-gs));"></div>
        <h1 class="font-roboto-slab relative z-10 px-4 text-center text-4xl font-bold text-white sm:text-5xl md:text-6xl">
            {{ $glossaire->title }}</h1>
    </div>

    <div
        class="container mx-auto my-10 flex flex-col justify-center gap-6 px-4 sm:my-16 sm:px-6 md:my-20 md:px-16 lg:flex-row lg:px-60">
        <div class="font-roboto-slab w-full text-justify lg:w-2/3">
            {!! $glossaire->content !!}
        </div>
        <div class="w-full lg:w-1/3">
            <div id="accordion-collapse" data-accordion="collapse">
                <h2 id="accordion-collapse-heading-1">
                    <button type="button"
                        class="font-roboto-slab border-b-1 border-supaGirlRosePastel text-green-gs hover:bg-supaGirlRose/10 hover:text-green-gs bg-supaGirlRose flex w-full items-center justify-between gap-3 rounded-t-xl border p-4 text-xl font-bold sm:text-2xl md:text-3xl"
                        data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
                        aria-controls="accordion-collapse-body-1">
                        <span>{{ __('glossary.glossary') }}</span>
                        <svg data-accordion-icon class="h-3 w-3 shrink-0 rotate-180 sm:h-4 sm:w-4" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
                    <div class="border-supaGirlRosePastel bg-fieldBg text-green-gs border p-4">
                        <ul class="text-green-gs mb-2 flex flex-col gap-3">
                            @foreach ($glossaires as $glossaire)
                                <li class="hover:bg-supaGirlRose/10 p-2"><a
                                        href="{{ route('glossaires.show', $glossaire->slug) }}"
                                        class="font-roboto-slab hover:text-green-gs text-sm font-bold">{{ $glossaire->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto my-8 flex flex-col gap-6 sm:my-10">
        <div class="flex flex-col items-center justify-between px-4 sm:flex-row sm:px-6 md:px-16 lg:px-60">
            <h3 class="font-roboto-slab text-green-gs mb-4 text-3xl font-bold sm:mb-0 sm:text-4xl md:text-5xl">
                {{ __('glossary.glossary') }}</h3>
            <div class="z-10">
                <x-btn href="{{ route('glossaires.index') }}" text="{{ __('glossary.back_to_glossary') }}" />
            </div>
        </div>

        <x-GlossaireSection />
    </div>
@endsection
