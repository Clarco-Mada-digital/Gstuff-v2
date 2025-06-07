@extends('layouts.base')

@section('pageTitle', $glossaire->title)

@section('content')
    <div class="flex min-h-72 w-full items-center justify-center bg-cover bg-center"
        style="background-image: url('../images/girl_deco_sp.jpg')">
        <h1 class="font-dm-serif px-4 text-center text-4xl font-bold text-white sm:text-5xl md:text-6xl">
            {{ $glossaire->title }}</h1>
    </div>

    <div
        class="container mx-auto my-10 flex flex-col justify-center gap-6 px-4 sm:my-16 sm:px-6 md:my-20 md:px-16 lg:flex-row lg:px-60">
        <div class="w-full text-justify lg:w-2/3">
            {!! $glossaire->content !!}
        </div>
        <div class="w-full lg:w-1/3">
            <div id="accordion-collapse" data-accordion="collapse">
                <h2 id="accordion-collapse-heading-1">
                    <button type="button"
                        class="font-dm-serif border-b-1 flex w-full items-center justify-between gap-3 rounded-t-xl border border-gray-200 p-4 text-xl font-bold text-gray-500 hover:bg-gray-100 sm:text-2xl md:text-3xl dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800"
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
                    <div class="border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900">
                        <ul class="mb-2 flex flex-col gap-3 text-gray-500 dark:text-gray-400">
                            @foreach ($glossaires as $glossaire)
                                <li><a href="{{ route('glossaires.show', $glossaire->slug) }}"
                                        class="text-sm hover:underline sm:text-base">{{ $glossaire->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto my-8 flex flex-col gap-6 sm:my-10">
        <div class="flex flex-col items-center justify-between px-4 sm:flex-row sm:px-6 md:px-16 lg:px-60">
            <h3 class="font-dm-serif text-green-gs mb-4 text-3xl font-bold sm:mb-0 sm:text-4xl md:text-5xl">{{ __('glossary.glossary') }}</h3>
            <div class="z-10">
                <a href="{{ route('glossaires.index') }}" type="button"
                    class="btn-gs-gradient flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-center text-sm font-bold text-black focus:outline-none">
                    {{ __('glossary.back_to_glossary') }}
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z" />
                    </svg>
                </a>
            </div>
        </div>

        <x-GlossaireSection />
    </div>
@endsection
