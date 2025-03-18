@extends('layouts.base')

  @section('extraStyle')
  <style>
    .range-slider, .multi-range-slider {
      width: 100%;
      margin-left: auto;
      margin-right: auto;
      position: relative;
      margin-top: 2.5rem;
      margin-bottom: 2rem;
    }

    .multi-range-slider .range-slider {
      margin: 0;
    }

    .range {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      width: 100%;
    }

    .range:focus {
      outline: 0;
    }

    .range-slider::before, .range-slider::after,
    .multi-range-slider::before, .multi-range-slider::after {
      position: absolute;
      font-size: 0.875rem;
      line-height: 1;
      padding: 0.25rem;
      border-radius: 0.25rem;
      background-color: #d2d6dc;
      color: #4b5563;
      top: -2rem;
      z-index: 5;
    }

    .multi-range-slider .range-slider::before, .multi-range-slider .range-slider::after {
      content: none !important;
    }

    .range-slider::before, .multi-range-slider::before {
      left: 0;
      content: attr(data-min);
    }

    .range-slider::after, .multi-range-slider::after {
      right: 0;
      content: attr(data-max);
    }

    .range::-webkit-slider-runnable-track {
      width: 100%;
      height: 1rem;
      cursor: pointer;
      border-radius: 9999px;
      background-color: #cfd8e3;
      animate: 0.2s;
    }

    .range::-webkit-slider-thumb {
      z-index: 10;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      position: relative;
      -webkit-appearance: none;
      appearance: none;
      cursor: pointer;
      border-radius: 9999px;
      background-color: #ffffff;
      height: 1rem;
      width: 1rem;
      border-width: 1px;
      border-style: solid;
      border-color: green;
      transform: translateY(calc(-50% + 0.5rem));
    }

    .tooltip {
      position: absolute;
      display: block;
      text-align: center;
      color: #ffffff;
      line-height: 1;
      padding-left: 0.25rem;
      padding-right: 0.25rem;
      padding-top: 0.125rem;
      padding-bottom: 0.125rem;
      border-radius: 0.125rem;
      font-size: 1rem;
      --transform-translate-x: 0;
      --transform-translate-y: 0;
      --transform-rotate: 0;
      --transform-skew-x: 0;
      --transform-skew-y: 0;
      --transform-scale-x: 1;
      --transform-scale-y: 1;
      transform: translateX(var(--transform-translate-x)) translateY(var(--transform-translate-y)) rotate(var(--transform-rotate)) skewX(var(--transform-skew-x)) skewY(var(--transform-skew-y)) scaleX(var(--transform-scale-x)) scaleY(var(--transform-scale-y));
      --transform-translate-x: -50%;
      left: 50%;
      top: -2rem;
      background: green;
      z-index: 12;
    }

    .tooltip:before {
      position: absolute;
      --transform-translate-x: 0;
      --transform-translate-y: 0;
      --transform-rotate: 0;
      --transform-skew-x: 0;
      --transform-skew-y: 0;
      --transform-scale-x: 1;
      --transform-scale-y: 1;
      transform: translateX(var(--transform-translate-x)) translateY(var(--transform-translate-y)) rotate(var(--transform-rotate)) skewX(var(--transform-skew-x)) skewY(var(--transform-skew-y)) scaleX(var(--transform-scale-x)) scaleY(var(--transform-scale-y));
      --transform-translate-x: -50%;
      left: 50%;
      bottom: -0.5rem;
      width: 0;
      height: 0;
      border-width: 4px;
      border-style: solid;
      border-color: transparent;
      content: "";
      border-top-color: green;
    }

    .multi-range-slider .range-slider {
      position: absolute;
    }
  </style>
  @endsection

  @section('pageTitle')
    Escort
  @endsection

  @section('content')

    <div class="w-full min-h-72 flex flex-col items-center justify-center bg-[#E4F1F1]">
      <h1 class="font-dm-serif font-bold text-green-gs text-xl xl:text-4xl text-center mb-5">Découvrez les escortes de votre région</h1>
      <div class="w-full px-4 flex flex-col md:flex-row items-center justify-center text-sm xl:text-base gap-2 mb-3">
        <select id="small" class="block w-full xl:w-55 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <option selected hidden>Cantons</option>
          @foreach($cantons as $canton)
          <option value="{{$canton->id}}">{{$canton->nom}}</option>
          @endforeach
        </select>
        <select id="small" class="block w-full xl:w-55 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <option selected hidden>Villes</option>
        </select>
        <select id="small" class="block w-full xl:w-55 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <option selected hidden>Sexe</option>
          <option value="US">Femme</option>
          <option value="CA">Homme</option>
          <option value="FR">Trans</option>
          <option value="DE">Gay</option>
          <option value="DE">Lesbienne</option>
          <option value="DE">Bisexuelle</option>
          <option value="DE">Queer</option>
        </select>
      </div>
      <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm my-2 xl:text-base">
        @foreach($categories as $categorie)
        <div>
          <input class="hidden peer" type="checkbox" id="{{$categorie->id}}" name="trans" value="{{$categorie->id}}">
          <label for="{{$categorie->id}}" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:text-amber-400 peer-checked:bg-green-gs">{{$categorie->nom}}</label>
        </div>
        @endforeach
        {{-- <div>
          <input class="hidden peer" type="checkbox" id="dominatrice" name="dominatrice" value="dominatrice">
          <label for="dominatrice" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">Dominatrice BDSM</label>
        </div>
        <div>
          <input class="hidden peer" type="checkbox" id="masseuse" name="masseuse" value="masseuse">
          <label for="masseuse" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">Masseuse (no sex)</label>
        </div>
        <div>
          <input class="hidden peer" type="checkbox" id="escorte" name="escorte" value="escorte">
          <label for="escorte" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">Escort</label>
        </div> --}}
      </div>
      <button data-modal-target="search-escorte-modal" data-modal-toggle="search-escorte-modal" class="font-dm-serif text-gray-600 flex items-center gap-2 p-2 bg-white border border-gray-400 rounded-lg mt-5 hover:bg-green-gs hover:text-white group">
        Plus de filtres
        <svg class="w-5 h-5 p-1 bg-gray-300 rounded-full group-hover:bg-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><!-- Icon from All by undefined - undefined --><g fill="none" fill-rule="evenodd"><path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M16 15c1.306 0 2.418.835 2.83 2H20a1 1 0 1 1 0 2h-1.17a3.001 3.001 0 0 1-5.66 0H4a1 1 0 1 1 0-2h9.17A3 3 0 0 1 16 15m0 2a1 1 0 1 0 0 2a1 1 0 0 0 0-2M8 9a3 3 0 0 1 2.762 1.828l.067.172H20a1 1 0 0 1 .117 1.993L20 13h-9.17a3.001 3.001 0 0 1-5.592.172L5.17 13H4a1 1 0 0 1-.117-1.993L4 11h1.17A3 3 0 0 1 8 9m0 2a1 1 0 1 0 0 2a1 1 0 0 0 0-2m8-8c1.306 0 2.418.835 2.83 2H20a1 1 0 1 1 0 2h-1.17a3.001 3.001 0 0 1-5.66 0H4a1 1 0 0 1 0-2h9.17A3 3 0 0 1 16 3m0 2a1 1 0 1 0 0 2a1 1 0 0 0 0-2"/></g></svg>
      </button>
      <button data-modal-target="search-escorte-modal" data-modal-toggle="search-escorte-modal" class="font-dm-serif text-gray-600 flex items-center gap-2 p-2 bg-white border border-gray-400 rounded-lg my-2 hover:bg-green-gs hover:text-white group">
        Réinitialiser les filtres
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><!-- Icon from All by undefined - undefined --><path fill="currentColor" d="M22.448 21A10.86 10.86 0 0 0 25 14A10.99 10.99 0 0 0 6 6.466V2H4v8h8V8H7.332a8.977 8.977 0 1 1-2.1 8h-2.04A11.01 11.01 0 0 0 14 25a10.86 10.86 0 0 0 7-2.552L28.586 30L30 28.586Z"/></svg>
      </button>
    </div>

    <div class="container mx-auto py-20 px-2">
      <div class="font-dm-serif text-green-gs font-bold text-3xl mb-3">16 Résultats</div>
      <div class="grid xl:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-2">
        @foreach ($escorts->slice(0, 8) as $escort)
          <x-escort_card name="{{ $escort->nom }}" canton="{{$escort->canton->nom}}" ville="{{$escort->ville->nom}}" escortId="{{$escort->id}}" />
        @endforeach
      </div>
    </div>

    <x-feedback-section />

    <x-call-to-action-inscription />

    <!-- Recherche modal -->
    <div id="search-escorte-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-[95%] lg:w-[60%]  max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">

            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="w-full flex items-center justify-center text-3xl text-green-gs font-dm-serif font-bold">Plus de filtres</h3>
                <button type="button" class="end-2.5 text-green-gs bg-transparent hover:bg-gray-200 hover:text-amber-400 rounded-lg text-sm w-4 h-4 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="search-escorte-modal">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="relative flex flex-col gap-3 items-center justify-center p-4 md:p-5 md:pb-20">
              <h3 class="text-green-gs text-3xl font-dm-serif">Catégories de services</h3>
              <div class="flex items-center gap-4 flex-wrap">
                @foreach ($apiData['glossaires'] as $item)
                <div class="my-1">
                  <input id="services{{$item['id']}}" class="hidden peer" type="checkbox" name="service" value="service" />
                  <label for="services{{$item['id']}}" class="p-2 text-center border border-gray-400 rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">{{$item['title']['rendered']}}</label>
                </div>
                  @endforeach
              </div>
              <h3 class="text-green-gs text-3xl font-dm-serif">Autres filtres</h3>
              <div class="grid grid-cols-1 xl:grid-cols-3 w-full gap-3 justify-between items-center">
                <select id="small" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                  <option selected hidden>Origine</option>
                </select>
                <select id="small" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                  <option selected hidden>Mensurations</option>
                </select>
                <select id="small" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                  <option selected hidden>Orientation sexuels</option>
                </select>
                <select id="small" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                  <option selected hidden>Langue</option>
                </select>
                <select id="small" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                  <option selected hidden>Cheveux</option>
                </select>
                <select id="small" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                  <option selected hidden>Yeux</option>
                </select>
                <select id="small" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                  <option selected hidden>Etat de la poitrine</option>
                </select>
                <select id="small" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                  <option selected hidden>Poils pubis</option>
                </select>
                <select id="small" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                  <option selected hidden>Tatoo</option>
                </select>
                <select id="small" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                  <option selected hidden>Taille de la poitrine</option>
                </select>
                <select id="small" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                  <option selected hidden>Mobilité de l'escorte</option>
                </select>
              </div>

              <div class="grid grid-cols-1 xl:grid-cols-3 items-center justify-center gap-3 w-full">
                <div class="Quiz--component SliderRange" x-data="{ ageMin: 18, ageMax: 54 }">
                  <!-- Age Slider -->
                  <div class="range-container">
                    <h3 class="Quiz--description SliderRange--description">Age</h3>
                    <div class="multi-range-slider" wire:ignore data-min="18" data-max="54"
                         x-bind:style="'height: '+ (parseInt($refs.ageHeight.offsetHeight) + parseInt(getComputedStyle($refs.ageHeight).marginTop) + parseInt(getComputedStyle($refs.ageHeight).marginBottom)) +'px;'">
                      <style x-text="'.range::-webkit-slider-runnable-track { background: linear-gradient(90deg, #dee4ec calc('+ Number((ageMin - $refs.ageMin.min) * 100 / ($refs.ageMin.max - $refs.ageMin.min)) +'% + '+ Number(16 - (Number((ageMin - $refs.ageMin.min) * 100 / ($refs.ageMin.max - $refs.ageMin.min)) * 0.32)) +'px), green calc('+ Number((ageMin - $refs.ageMin.min) * 100 / ($refs.ageMin.max - $refs.ageMin.min)) +'% + '+ Number(16 - (Number((ageMin - $refs.ageMin.min) * 100 / ($refs.ageMin.max - $refs.ageMin.min)) * 0.32)) +'px), green calc('+ Number((ageMax - $refs.ageMax.min) * 100 / ($refs.ageMax.max - $refs.ageMax.min)) +'% + '+ Number(16 - (Number((ageMax - $refs.ageMax.min) * 100 / ($refs.ageMax.max - $refs.ageMax.min)) * 0.32)) +'px), #dee4ec calc('+ Number((ageMax - $refs.ageMax.min) * 100 / ($refs.ageMax.max - $refs.ageMax.min)) +'% + '+ Number(16 - (Number((ageMax - $refs.ageMax.min) * 100 / ($refs.ageMax.max - $refs.ageMax.min)) * 0.32)) +'px)) !important; }'">
                      </style>
                      <div class="range-slider" x-ref="ageHeight" id="age-min">
                        <div class="tooltip" x-html="parseInt(ageMin)"
                             x-bind:style="'left: calc('+ Number((ageMin - $refs.ageMin.min) * 100 / ($refs.ageMin.max - $refs.ageMin.min)) +'% + '+ Number(16 - (Number((ageMin - $refs.ageMin.min) * 100 / ($refs.ageMin.max - $refs.ageMin.min)) * 0.32)) +'px)'">
                        </div>
                        <input class="range" type="range" id="ageMin"
                               x-ref="ageMin"
                               x-on:input="if(Number(ageMax) <= Number($event.target.value) + 18) { $event.target.value = Number(ageMax) - 18; }"
                               x-model="ageMin"
                               step="1"
                               min="18"
                               max="54">
                      </div>
                      <div class="range-slider" id="age-max">
                        <div class="tooltip" x-html="parseInt(ageMax)"
                             x-bind:style="'left: calc('+ Number((ageMax - $refs.ageMax.min) * 100 / ($refs.ageMax.max - $refs.ageMax.min)) +'% + '+ Number(16 - (Number((ageMax - $refs.ageMax.min) * 100 / ($refs.ageMax.max - $refs.ageMax.min)) * 0.32)) +'px)'">
                        </div>
                        <input class="range" type="range"
                               x-ref="ageMax"
                               x-on:input.prevent="if(Number(ageMin) >= Number($event.target.value) - 18) { $event.target.value = Number(ageMin) + 18; } else { return false; }"
                               x-model="ageMax"
                               step="1"
                               min="18"
                               max="54">
                      </div>
                    </div>
                  </div>
                </div>
                {{-- <div class="Quiz--component SliderRange" x-data="{ salaryMin: 0, salaryMax: 800 }">
                  <!-- Salary Slider -->
                  <div class="range-container">
                    <h3 class="Quiz--description SliderRange--description">Paiement</h3>
                    <div class="multi-range-slider" wire:ignore data-min="0" data-max="800"
                         x-bind:style="'height: '+ (parseInt($refs.salaryHeight.offsetHeight) + parseInt(getComputedStyle($refs.salaryHeight).marginTop) + parseInt(getComputedStyle($refs.salaryHeight).marginBottom)) +'px;'">
                      <style x-text="'.range::-webkit-slider-runnable-track { background: linear-gradient(90deg, #dee4ec calc('+ Number((salaryMin - $refs.salaryMin.min) * 100 / ($refs.salaryMin.max - $refs.salaryMin.min)) +'% + '+ Number(16 - (Number((salaryMin - $refs.salaryMin.min) * 100 / ($refs.salaryMin.max - $refs.salaryMin.min)) * 0.32)) +'px), green calc('+ Number((salaryMin - $refs.salaryMin.min) * 100 / ($refs.salaryMin.max - $refs.salaryMin.min)) +'% + '+ Number(16 - (Number((salaryMin - $refs.salaryMin.min) * 100 / ($refs.salaryMin.max - $refs.salaryMin.min)) * 0.32)) +'px), green calc('+ Number((salaryMax - $refs.salaryMax.min) * 100 / ($refs.salaryMax.max - $refs.salaryMax.min)) +'% + '+ Number(16 - (Number((salaryMax - $refs.salaryMax.min) * 100 / ($refs.salaryMax.max - $refs.salaryMax.min)) * 0.32)) +'px), #dee4ec calc('+ Number((salaryMax - $refs.salaryMax.min) * 100 / ($refs.salaryMax.max - $refs.salaryMax.min)) +'% + '+ Number(16 - (Number((salaryMax - $refs.salaryMax.min) * 100 / ($refs.salaryMax.max - $refs.salaryMax.min)) * 0.32)) +'px)) !important; }'">
                      </style>
                      <div class="range-slider" x-ref="salaryHeight" id="salary-min">
                        <div class="tooltip" x-html="parseInt(salaryMin)"
                             x-bind:style="'left: calc('+ Number((salaryMin - $refs.salaryMin.min) * 100 / ($refs.salaryMin.max - $refs.salaryMin.min)) +'% + '+ Number(16 - (Number((salaryMin - $refs.salaryMin.min) * 100 / ($refs.salaryMin.max - $refs.salaryMin.min)) * 0.32)) +'px)'">
                        </div>
                        <input class="range" type="range" id="salaryMin"
                               x-ref="salaryMin"
                               x-on:input="if(Number(salaryMax) <= Number($event.target.value)) { $event.target.value = Number(salaryMax); }"
                               x-model="salaryMin"
                               step="50"
                               min="0"
                               max="800">
                      </div>
                      <div class="range-slider" id="salary-max">
                        <div class="tooltip" x-html="parseInt(salaryMax)"
                             x-bind:style="'left: calc('+ Number((salaryMax - $refs.salaryMax.min) * 100 / ($refs.salaryMax.max - $refs.salaryMax.min)) +'% + '+ Number(16 - (Number((salaryMax - $refs.salaryMax.min) * 100 / ($refs.salaryMax.max - $refs.salaryMax.min)) * 0.32)) +'px)'">
                        </div>
                        <input class="range" type="range"
                               x-ref="salaryMax"
                               x-on:input.prevent="if(Number(salaryMin) >= Number($event.target.value)) { $event.target.value = Number(salaryMin); } else { return false; }"
                               x-model="salaryMax"
                               step="50"
                               min="0"
                               max="800">
                      </div>
                    </div>
                  </div>
                </div> --}}
              </div>

          </div>
          
        </div>
      </div>
  </div>
  @endsection

  @section('extraScripts')

  @endsection
