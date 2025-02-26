@extends('layouts.base')

  @section('pageTitle')
      Home
  @endsection

  @section('content')

  {{-- @foreach ($apiData['users'] as $salon)
     {{ dd($salon)}}
  @endforeach --}}

    {{-- Hero content --}}
    <div class="relative flex items-center justify-center flex-col gap-8 w-full px-3 py-20 lg:h-[418px] bg-no-repeat" style="background: url('images/Hero image.jpeg') center center /cover;">
      <div class="w-full h-full z-0 absolute inset-0 to-0% right-0% bg-green-gs/65"></div>
      <div class="flex items-center justify-center flex-col z-10">
        <h2 class="[text-shadow:_2px_6px_9px_rgb(0_0_0_/_0.8)] lg:text-6xl md:text-5xl text-4xl text-center font-semibold text-white font-cormorant">Rencontres <span class="text-amber-400">élégantes et discrètes</span>  en Suisse</h2>
      </div>
      <div class="flex flex-col lg:flex-row gap-2 text-black transition-all">
        @foreach ($apiData['services'] as $service)
        <a href="#" class="flex items-center justify-center gap-1 z-10 transition-all">
          <div class="w-64 lg:w-56 flex items-center justify-center gap-1.5 p-2.5 bg-white border border-amber-400 rounded-md hover:bg-green-gs hover:text-white transition-all">
            <img src="{{ asset('icons/'. $service['post_name'] .'_icon.svg') }}" alt="icon service {{ $service['post_name'] }}" srcset="icon service {{ $service['post_name'] }}">
            <span>{{ $service['post_title'] }}</span>
          </div>
        </a>
        @endforeach
      </div>
      <div class="z-10">
        <a href="#" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 text-center dark:focus:ring-blue-800">Tout voir <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/></svg>
        </a>
      </div>
    </div>

    {{-- Main content --}}
    <div class="mt-10 container m-auto px-5 overflow-hidden">

      <div x-data="{ viewEscorte: true }" x-cloak>

        {{-- Switch salon escort Btn --}}
        <ul class="w-full lg:w-[50%] text-xs lg:text-xl font-medium text-center text-gray-500 rounded-lg shadow-sm flex mx-auto dark:divide-gray-700 dark:text-gray-400">
          <li class="w-full focus-within:z-10">
              <button  @click="viewEscorte = true" :class="viewEscorte ? 'btn-gs-gradient' : ''" class="inline-block w-full p-4 text-xs md:text-sm lg:text-base bg-white border-r font-bold border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50  rounded-s-lg focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-current="page">Top escortes du jour</button>
          </li>
          <li class="w-full focus-within:z-10">
              <button @click="viewEscorte = false" :class="viewEscorte ? '' : 'btn-gs-gradient' " class="inline-block w-full p-4 text-xs md:text-sm lg:text-base bg-white border-r font-bold border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50  rounded-e-lg focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Les salons</button>
          </li>
        </ul>

        {{-- Section listing Escort --}}
        <div x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-show="viewEscorte"
            class="relative w-full mx-auto flex flex-col items-center justify-center mt-4">
          <h3 class="font-dm-serif text-green-gs font-bold text-4xl text-center">Nos nouvelles escortes</h3>
          <div id="NewEscortContainer" class="w-full flex items-center justify-start overflow-x-auto flex-nowrap mt-5 mb-4 px-10 gap-4" style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
            @foreach (array_slice($apiData['escorts'], 0, 4) as $escort)
            <div class="relative flex flex-col justify-start min-w-[317px] min-h-[505px] mx-auto mb-2 p-1 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700" style="scroll-snap-align: center">
              <div class="absolute flex items-center justify-center top-0 right-0 w-10 h-10 rounded-full bg-white m-2 text-green-gs">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m22 9.24l-7.19-.62L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21L12 17.27L18.18 21l-1.63-7.03zM12 15.4l-3.76 2.27l1-4.28l-3.32-2.88l4.38-.38L12 6.1l1.71 4.04l4.38.38l-3.32 2.88l1 4.28z"/></svg>
              </div>
              <a class="m-auto w-full rounded-lg overflow-hidden" href="#">
                  <img class="w-full object-cover rounded-t-lg" src="images/girl_001.png" alt="" />
              </a>
              <div class="flex flex-col gap-2 mt-4">
                  <a class="flex items-center gap-1" href="#">
                      <h5 class="text-base tracking-tight text-gray-900 dark:text-white">{{ $escort['data']['display_name'] }}</h5>
                      <div class="w-2 h-2 rounded-full bg-green-gs"></div>
                  </a>
                  <p class="font-normal text-gray-700 dark:text-gray-400">
                    <span>
                    Suisse Allemanique
                    </span>
                    <span>
                    | Genève
                    </span>
                  </p>
              </div>
            </div>
            @endforeach
          </div>
          <div id="arrowEscortScrollRight" class="absolute 2xl:hidden top-[40%] left-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-prev>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z"/></svg>
          </div>
          <div id="arrowEscortScrollLeft" class="absolute 2xl:hidden top-[40%] right-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-next>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z"/></svg>
          </div>
        </div>

        {{-- Section listing Salon --}}
        <div x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-show="!viewEscorte"
            class="relative w-full mx-auto flex flex-col items-center justify-center mt-4">
          <h3 class="font-dm-serif text-green-gs font-bold text-4xl text-center">Nos salons</h3>
          <div id="OurSalonContainer" class="w-full flex items-center justify-start overflow-x-auto flex-nowrap mt-5 mb-4 px-10 gap-4" style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
            @foreach (array_slice($apiData['salons'], 0, 4) as $salon)
            <div class="relative flex flex-col justify-center min-w-[317px] min-h-[505px] mx-auto mb-2 p-1 md:w-72 lg:w-80 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700" style="scroll-snap-align: center">
              <div class="absolute flex items-center justify-center top-0 right-0 w-10 h-10 rounded-full bg-white m-2 text-green-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m22 9.24l-7.19-.62L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21L12 17.27L18.18 21l-1.63-7.03zM12 15.4l-3.76 2.27l1-4.28l-3.32-2.88l4.38-.38L12 6.1l1.71 4.04l4.38.38l-3.32 2.88l1 4.28z"/></svg>
              </div>
              <a class="m-auto w-full rounded-lg overflow-hidden" href="#">
                  <img class="w-full object-cover rounded-t-lg" src="images/girl_001.png" alt="" />
              </a>
              <div class="flex flex-col gap-2 mt-4">
                  <a class="flex items-center gap-1" href="#">
                      <h5 class="text-base tracking-tight text-gray-900 dark:text-white">{{ $salon['data']['display_name'] }}</h5>
                      <div class="w-2 h-2 rounded-full bg-green-gs"></div>
                  </a>
                  <p class="font-normal text-gray-700 dark:text-gray-400">
                    <span>
                    Suisse Allemanique
                    </span>
                    <span>
                    | Genève
                    </span>
                  </p>
              </div>
            </div>
            @endforeach
          </div>
          <div id="arrowSalonScrollRight" class="absolute 2xl:hidden top-[40%] left-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-prev>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z"/></svg>
          </div>
          <div id="arrowSalonScrollLeft" class="absolute 2xl:hidden top-[40%] right-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-next>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z"/></svg>
          </div>
        </div>
      </div>

      {{-- Section listing escort --}}
      <div class="relative w-full mx-auto flex flex-col items-center justify-center mt-4">
        <h3 class="font-dm-serif text-green-gs font-bold text-3xl lg:text-4xl text-center">A la recherche d'un plaisir coquin ?</h3>
        <div id="listingContainer" class="relative w-full flex items-center justify-start overflow-x-auto flex-nowrap mt-5 mb-4 px-10 gap-4" style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
          @foreach (array_slice($apiData['escorts'], 0, 8) as $escort)
          <div class="relative flex flex-col justify-center min-w-[317px] min-h-[505px] mx-auto mb-2 p-1 md:w-72 lg:w-80 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700" style="scroll-snap-align: center">
            <div class="absolute flex items-center justify-center top-0 right-0 w-10 h-10 rounded-full bg-white m-2 text-yellow-600 z-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m12 17.27l4.15 2.51c.76.46 1.69-.22 1.49-1.08l-1.1-4.72l3.67-3.18c.67-.58.31-1.68-.57-1.75l-4.83-.41l-1.89-4.46c-.34-.81-1.5-.81-1.84 0L9.19 8.63l-4.83.41c-.88.07-1.24 1.17-.57 1.75l3.67 3.18l-1.1 4.72c-.2.86.73 1.54 1.49 1.08z"/></svg>
            </div>
            <a class="m-auto w-full rounded-lg overflow-hidden" href="#">
                <img class="w-full object-cover rounded-t-lg" src="images/girl_001.png" alt="" />
            </a>
            <div class="flex flex-col gap-2 mt-4">
                <a class="flex items-center gap-1" href="#">
                    <h5 class="text-base tracking-tight text-gray-900 dark:text-white">{{ $escort['data']['display_name'] }}</h5>
                    <div class="w-2 h-2 rounded-full bg-green-gs"></div>
                </a>
                <p class="font-normal text-gray-700 dark:text-gray-400">Suisse Allemanique</p>
            </div>
          </div>
          @endforeach
        </div>
        <div id="arrowListScrollRight" class="absolute top-[40%] left-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-prev>
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z"/></svg>
        </div>
        <div id="arrowListScrollLeft" class="absolute top-[40%] right-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-next>
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z"/></svg>
        </div>
        <div class="z-10 mb-6">
          <a href="#" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 text-center dark:focus:ring-blue-800">Tout voir <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/></svg>
          </a>
        </div>
      </div>

    </div>

    <div class="relative flex flex-col items-center justify-center py-10 w-full" style="background: url('images/girl_deco_image.jpg') center center /cover">
      <div class="bg-white/70 absolute top-0 right-0 w-full h-full z-0"></div>
        <h3 class="font-dm-serif text-green-gs text-2xl md:text-3xl lg:text-4xl xl:text-5xl my-4 mx-2 text-center font-bold z-10">Trouver des escortes, masseuses et plus encore sur Gstuff !</h3>
        <div class="flex flex-col w-full px-4 md:flex-row items-center justify-center gap-2 py-6 z-10">
        @foreach ([1, 2, 3] as $item)
        <div class="w-full lg:w-[367px] lg:h-[263px] bg-[#618E8D] p-3 flex flex-col text-white text-2xl lg:text-4xl font-bold items-center justify-center gap-3">
          <span class="text-center font-dm-serif w-[70%]">+ de 500 partenaires</span>
          <span class="text-center text-sm lg:text-base font-normal w-[75%] mx-auto">Profils vérifiés pour des rencontres authentiques</span>
        </div>
        @endforeach
      </div>
    </div>

    {{-- <div class="relative py-10 w-full overflow-hidden">
      <div class="bg-[#E4F1F1] absolute top-0 right-0 w-full h-full z-0"></div>
      <div class="w-full flex items-center justify-center gap-5 flex-nowrap overflow-hidden">
      @foreach ([1, 2, 3] as $item)
      <div class=" @if ($item==2) scale-100 @else scale-75 @endif min-w-[300px] lg:w-[625px] h-[250px] p-5 bg-white rounded-lg flex flex-col items-center justify-center gap-4 text-xl lg:text-3xl z-10">
        <span class="text-center w-[80%] mx-auto">"Amazing experience i love it a lot. Thanks to the team that dreams come true, great!"</span>
        <div class="flex items-center w-full justify-center gap-4">
          <img class="w-12 h-12 rounded-full" src="icons/user_icon.svg" alt="user_default icon" srcset="user icon">
          <div class="flex flex-col font-bold">
            <span class="font-dm-serif text-base lg:text-2xl text-green-800">Lassy Chester</span>
            <span class="text-sm lg:text-base">Escort</span>
          </div>
        </div>
      </div>
      @endforeach
      </div>
    </div> --}}
    <x-FeedbackSection />

    <div class="bg-white py-10 w-full overflow-x-hidden flex items-center justify-center flex-col gap-10">
      <h3 class="text-xl md:text-4xl lg:text-5xl font-dm-serif text-green-gs font-bold">Comment devenir escorte sur Gstuff ?</h3>
      <p>Devenez escorte indépendante en 3 étapes !</p>
      <div class="relative grid grid-cols-3 gap-5 text-green-gs  text-xs lg:text-lg text-wrap italic font-normal mt-20 mx-0 px-2">
        <div class="absolute mx-20 top-[20%] col-span-3 w-[70%] h-1 bg-green-gs z-0"></div>
        @foreach ([1, 2, 3] as $items)
          <img class="w-20 h-20 mx-auto z-10" src="{{ asset('icons/icon_coeur.svg') }}" alt="coeur image" srcset="coeur image">
        @endforeach
        <div class="lg:w-52 w-30 text-wrap text-center">Envoyer 5 selfies a <a href="http://escort-gstuff@gstuff.ch" class="text-amber-500">escort-gstuff@gstuff.ch</a></div>
        <div class="lg:w-52 w-30 text-wrap text-center"> Prenez rendez-vous pour le shooting photo</div>
        <div class="lg:w-52 w-30 text-wrap text-center">Publiez votre profil</div>
      </div>
    </div>

    {{-- <div class="relative flex flex-col items-start justify-center w-full h-[375px]" style="background: url('images/girl_deco_image_001.jpg') center center /cover">
      <div class="text-white flex flex-col gap-4 container mx-auto px-3">
        <h3 class="font-dm-serif text-3xl lg:text-5xl font-bold w-full lg:w-[40%]">Inscrivez vous dès aujourd'hui sur Gstuff ...</h3>
        <span class="font-dm-serif">La meilleure plateforme érotique en Suisse !</span>
        <div class="z-10 w-45">
          <a href="#" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 text-center dark:focus:ring-blue-800">S'inscrire <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/></svg>
          </a>
        </div>
      </div>

    </div> --}}
    <x-CallToActionInscription />

    {{-- Nou contactez --}}
    {{-- <div class="flex flex-col items-center justify-center gap-10 lg:container mx-auto py-20">
      <div class="flex flex-col justify-center gap-5 w-full lg:w-[1140px] h-[255px] px-10 lg:px-20 text-white" style="background: url('images/girl_deco_contact.jpg') center center /cover">
        <h2 class="text-3xl lg:text-5xl font-dm-serif font-bold">Nous contacter</h2>
        <p>Besoin d'information ou de conseils ? Contactez-nous dès maintenat !</p>
        <div class="z-10 mt-5">
          <a href="#" type="button" class="w-52 flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg px-4 py-2 text-center text-sm lg:text-base dark:focus:ring-blue-800">Nous écrire <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/></svg>
          </a>
        </div>
      </div>

      <h3 id="FAQ" class="text-3xl lg:text-5xl font-dm-serif text-green-gs">Questions fréquentes</h3>
      <div id="accordion-collapse text-wrap w-full lg:min-w-[1114px]" data-accordion="collapse">
        <h2 id="accordion-collapse-heading-1" class="w-full lg:min-w-[1114px]">
          <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
            <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>Est-ce que le shooting photo est obligatoire?</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
          <div class="p-5 border border-b-0 border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            <p class="mb-2 text-gray-500 dark:text-gray-400">Oui, c’est ce qui rend la plateforme si unique. Toutes les photos publiées sur GStuff ont été réalisées par notre équipe.</p>
          </div>
        </div>
        <h2 id="accordion-collapse-heading-2" class="w-full lg:min-w-[1114px]">
          <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-2" aria-expanded="false" aria-controls="accordion-collapse-body-2">
            <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>Avez-vous des appartements à louer?</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
          <div class="p-5 border border-b-0 border-gray-200 bg-white dark:border-gray-700">
            <p class="mb-2 text-gray-500 dark:text-gray-400">FNous ne louons pas d’appartements pour les escorts.</p>
          </div>
        </div>
        <h2 id="accordion-collapse-heading-3" class="w-full lg:min-w-[1114px]">
          <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
            <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>Combien puis-je gagner?</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
          <div class="p-5 border border-t-0 border-gray-200 bg-white dark:border-gray-700">
            <p class="mb-2 text-gray-500 dark:text-gray-400">Le revenu mensuel des escortes sur Gstuff dépend de nombreux critères mais il peut atteindre plusieurs dizaines de milliers de francs suisses par mois</p>
          </div>
        </div>
      </div>
    </div> --}}

    <x-CallToActionContact />

    {{-- FAQ --}}
    <div class="container mx-auto flex flex-col items-center justify-center gap-10">
      <h3 id="FAQ" class="text-3xl lg:text-5xl font-dm-serif text-green-gs">Questions fréquentes</h3>
      <div id="accordion-collapse text-wrap w-full lg:min-w-[1114px]" data-accordion="collapse">
        <h2 id="accordion-collapse-heading-1" class="w-full lg:min-w-[1114px]">
          <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
            <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>Est-ce que le shooting photo est obligatoire?</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
          <div class="p-5 border border-b-0 border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            <p class="mb-2 text-gray-500 dark:text-gray-400">Oui, c’est ce qui rend la plateforme si unique. Toutes les photos publiées sur GStuff ont été réalisées par notre équipe.</p>
          </div>
        </div>
        <h2 id="accordion-collapse-heading-2" class="w-full lg:min-w-[1114px]">
          <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-2" aria-expanded="false" aria-controls="accordion-collapse-body-2">
            <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>Avez-vous des appartements à louer?</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
          <div class="p-5 border border-b-0 border-gray-200 bg-white dark:border-gray-700">
            <p class="mb-2 text-gray-500 dark:text-gray-400">Nous ne louons pas d’appartements pour les escorts.</p>
          </div>
        </div>
        <h2 id="accordion-collapse-heading-3" class="w-full lg:min-w-[1114px]">
          <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
            <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>Combien puis-je gagner?</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
          </button>
        </h2>
        <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
          <div class="p-5 border border-t-0 border-gray-200 bg-white dark:border-gray-700">
            <p class="mb-2 text-gray-500 dark:text-gray-400">Le revenu mensuel des escortes sur Gstuff dépend de nombreux critères mais il peut atteindre plusieurs dizaines de milliers de francs suisses par mois</p>
          </div>
        </div>
      </div>
    </div>

    {{-- Glossaire --}}
    <div class="lg:container mx-auto my-10" >
      <div class="flex items-center justify-between my-10 px-5 lg:px-20">
        <h3 class="font-dm-serif text-2xl lg:text-4xl text-green-800 font-bold">Articles du glossaire</h3>
        <div class="z-10 w-auto">
          <a href="#" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg px-4 py-2 text-center text-sm lg:text-base dark:focus:ring-blue-800">voir plus d'articles <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/></svg>
          </a>
        </div>
      </div>
      {{-- <div class="relative w-full">
        <div id="glossaire-container" class="w-full flex items-center flex-nowrap gap-10 px-20 overflow-x-auto scroll-smooth" data-slider-wrapper style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
          @foreach ($apiData['glossaires'] as $item)
            <a href="{{ route('glossaire', $item['id']) }}">
              <div class="bg-green-gs min-w-[375px] w-[375px] h-[232px] flex flex-col items-stretch gap-5 p-5 text-white rounded-lg py-10" style="scroll-snap-align: center" data-carousel-item >
                <h4 class="font-dm-serif text-2xl">{{ $item['title']['rendered'] }}</h4>
                {!! Str::limit($item['excerpt']['rendered'], 100, '...') !!}
                <svg class="w-10 my-3 text-amber-400"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12.7 17.925q-.35.2-.625-.062T12 17.25L14.425 13H3q-.425 0-.712-.288T2 12t.288-.712T3 11h11.425L12 6.75q-.2-.35.075-.612t.625-.063l7.975 5.075q.475.3.475.85t-.475.85z"/></svg>
              </div>
            </a>
          @endforeach
        </div>
        <div id="arrowScrollRight" class="absolute top-[40%] left-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-prev>
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z"/></svg>
        </div>
        <div id="arrowScrollLeft" class="absolute top-[40%] right-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-next>
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z"/></svg>
        </div>
      </div> --}}
      <x-GlossaireSection />

    </div>

    @section('extraScripts')
      <script>
        const EscortrightBtn = document.getElementById('arrowEscortScrollRight')
        const EscortleftBtn = document.getElementById('arrowEscortScrollLeft')
        const Escortcontainer = document.getElementById('NewEscortContainer')
        const SalonrightBtn = document.getElementById('arrowSalonScrollRight')
        const SalonleftBtn = document.getElementById('arrowSalonScrollLeft')
        const Saloncontainer = document.getElementById('OurSalonContainer')
        const ListrightBtn = document.getElementById('arrowListScrollRight')
        const ListleftBtn = document.getElementById('arrowListScrollLeft')
        const Listcontainer = document.getElementById('listingContainer')

        EscortrightBtn.addEventListener('click', ()=>{scrollByPercentage(Escortcontainer, false, 35)})
        EscortleftBtn.addEventListener('click', ()=>{scrollByPercentage(Escortcontainer, true, 35)})
        SalonrightBtn.addEventListener('click', ()=>{scrollByPercentage(Saloncontainer, false, 35)})
        SalonleftBtn.addEventListener('click', ()=>{scrollByPercentage(Saloncontainer, true, 35)})
        ListrightBtn.addEventListener('click', ()=>{scrollByPercentage(Listcontainer, false)})
        ListleftBtn.addEventListener('click', ()=>{scrollByPercentage(Listcontainer)})
      </script>
    @endsection
  @stop
