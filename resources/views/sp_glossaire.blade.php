@extends('layouts.base')

  @section('pageTitle')
    {{ $glossaire->title }}
  @endsection
  
  @section('content')

  <div class="w-full min-h-72 flex items-center justify-center" style="background: url('../images/girl_deco_sp.jpg') center center /cover">
    <h1 class="font-dm-serif font-bold text-white text-6xl text-center">{{ $glossaire->title }}</h1>
  </div>

  <div class="container mx-auto px-60 flex justify-center gap-5 my-20">
    <div class="w-2/3 text-justify">
      {!! $glossaire->content !!}
    </div>
    <div class="w-1/3">
      <div id="accordion-collapse text-wrap w-full" data-accordion="collapse">
        <h2 id="accordion-collapse-heading-1" class="w-full">
          <button type="button" class="flex items-center justify-between w-full text-3xl font-dm-serif font-bold p-5 rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
            <span class="flex items-center">Glossaire</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
          <div class="p-5 border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            <ul class="mb-2 text-gray-500 flex flex-col justify-center gap-3 dark:text-gray-400">
              @foreach ($glossaires as $glossaire)
                  <li> <a href="{{ route('glossaires.show', $glossaire->slug) }}"> {{ $glossaire->title }} </a> </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container mx-auto my-5 flex flex-col gap-5">

    <div class="flex items-center justify-between px-60">
      <h3 class="font-dm-serif text-green-gs text-5xl font-bold">Glossaire</h3>
      <div class="z-10 w-auto">
        <a href="#" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:outline-none rounded-lg text-sm px-4 py-2 text-center ">Retour au glossaire <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/></svg>
        </a>
      </div>
    </div>

    <x-GlossaireSection />

  </div>

  @endsection
