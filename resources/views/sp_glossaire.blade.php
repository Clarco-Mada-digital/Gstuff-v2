@extends('layouts.base')

@section('pageTitle', $glossaire->title)

@section('content')
    <div class="w-full min-h-72 flex items-center justify-center bg-cover bg-center" style="background-image: url('../images/girl_deco_sp.jpg')">
        <h1 class="font-dm-serif font-bold text-white text-4xl sm:text-5xl md:text-6xl text-center px-4">{{ $glossaire->title }}</h1>
    </div>

    <div class="container mx-auto px-4 sm:px-6 md:px-16 lg:px-60 flex flex-col lg:flex-row justify-center gap-6 my-10 sm:my-16 md:my-20">
        <div class="w-full lg:w-2/3 text-justify">
            {!! $glossaire->content !!}
        </div>
        <div class="w-full lg:w-1/3">
            <div id="accordion-collapse" data-accordion="collapse">
                <h2 id="accordion-collapse-heading-1">
                    <button type="button" class="flex items-center justify-between w-full text-xl sm:text-2xl md:text-3xl font-dm-serif font-bold p-4 text-gray-500 border border-b-1 border-gray-200 rounded-t-xl dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
                        <span>Glossaire</span>
                        <svg data-accordion-icon class="w-3 h-3 sm:w-4 sm:h-4 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
                    <div class="p-4 border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                        <ul class="mb-2 text-gray-500 flex flex-col gap-3 dark:text-gray-400">
                            @foreach ($glossaires as $glossaire)
                                <li><a href="{{ route('glossaires.show', $glossaire->slug) }}" class="text-sm sm:text-base hover:underline">{{ $glossaire->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto my-8 sm:my-10 flex flex-col gap-6">
        <div class="flex flex-col sm:flex-row items-center justify-between px-4 sm:px-6 md:px-16 lg:px-60">
            <h3 class="font-dm-serif text-green-gs text-3xl sm:text-4xl md:text-5xl font-bold mb-4 sm:mb-0">Glossaire</h3>
            <div class="z-10">
                <a href="{{ route('glossaires.index') }}" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:outline-none rounded-lg text-sm px-4 py-2 text-center">
                    Retour au glossaire
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/>
                    </svg>
                </a>
            </div>
        </div>

        <x-GlossaireSection />
    </div>
@endsection