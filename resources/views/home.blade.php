@extends('layouts.base')

@section('pageTitle')
Home
@endsection

@section('content')

{{-- Hero content --}}
<div class="relative flex items-center justify-center flex-col gap-8 w-full px-3 py-20 lg:h-[418px] bg-no-repeat" style="background: url('images/Hero image.jpeg') center center /cover;">
    <div class="w-full h-full z-0 absolute inset-0 to-0% right-0% bg-green-gs/65"></div>
    <div class="flex items-center justify-center flex-col z-10">
        <h2 class="[text-shadow:_2px_6px_9px_rgb(0_0_0_/_0.8)] lg:text-6xl md:text-5xl text-4xl text-center font-semibold text-white font-cormorant">Rencontres <span class="text-amber-400">élégantes et discrètes</span> en Suisse</h2>
    </div>
    <div class="flex flex-col lg:flex-row gap-2 text-black transition-all">
        @foreach ($categories as $categorie)
        <a href="{{route('escortes')}}?selectedCategories=[{{$categorie->id}}]" class="flex items-center justify-center gap-1 z-10 transition-all">
            <div class="w-64 lg:w-56 flex items-center justify-center gap-1.5 p-2.5 bg-white border border-amber-400 rounded-md hover:bg-green-gs hover:text-white transition-all">
                <img src="{{ asset('images/icons/'. $categorie['display_name'] .'_icon.svg') }}" alt="icon service {{ $categorie['display_name'] }}" />
                <span>{{ $categorie['nom'] }}</span>
            </div>
        </a>
        @endforeach
    </div>
    <div class="z-10">
        <a href="{{ route('escortes') }}" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 text-center dark:focus:ring-blue-800">Tout voir <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z" /></svg>
        </a>
    </div>
</div>

{{-- Main content --}}
<div class="mt-10 container m-auto px-5 overflow-hidden">

    <div x-data="{ viewEscorte: true }" x-cloak>

        {{-- Switch salon escort Btn --}}
        <ul class="w-full lg:w-[50%] text-xs lg:text-xl font-medium text-center text-gray-500 rounded-lg shadow-sm flex mx-auto dark:divide-gray-700 dark:text-gray-400">
            <li class="w-full focus-within:z-10">
                <button @click="viewEscorte = true" :class="viewEscorte ? 'btn-gs-gradient' : ''" class="inline-block w-full p-4 text-xs md:text-sm lg:text-base bg-white border-r font-bold border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50  rounded-s-lg focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-current="page">Top escortes du jour</button>
            </li>
            <li class="w-full focus-within:z-10">
                <button @click="viewEscorte = false" :class="viewEscorte ? '' : 'btn-gs-gradient' " class="inline-block w-full p-4 text-xs md:text-sm lg:text-base bg-white border-r font-bold border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50  rounded-e-lg focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Les salons</button>
            </li>
        </ul>

        {{-- Section listing Escort --}}
        <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-show="viewEscorte" class="relative w-full mx-auto flex flex-col items-center justify-center mt-4">
            <h3 class="font-dm-serif text-green-gs font-bold text-4xl text-center">Nos nouvelles escortes</h3>
            <div id="NewEscortContainer" class="w-full flex items-center justify-start overflow-x-auto flex-nowrap mt-5 mb-4 px-10 gap-4" style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
                @foreach ($escorts as $escort)
                @if ($escort->canton && $escort->ville &&  $escort->prenom)
                <livewire:escort-card name="{{ $escort->prenom }}" canton="{{ $escort->canton['nom'] }}" ville="{{ $escort->ville['nom'] }}" avatar="{{ $escort->avatar }}" escortId="{{ $escort->id }}" />
                @endif
                @endforeach
            </div>
            <div id="arrowEscortScrollRight" class="absolute top-[40%] left-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-prev>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" /></svg>
            </div>
            <div id="arrowEscortScrollLeft" class="absolute top-[40%] right-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-next>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z" /></svg>
            </div>
        </div>

        {{-- Section listing Salon --}}
        <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-show="!viewEscorte" class="relative w-full mx-auto flex flex-col items-center justify-center mt-4">
            <h3 class="font-dm-serif text-green-gs font-bold text-4xl text-center">Nos salons</h3>
            <div id="OurSalonContainer" class="w-full min-h-30 flex items-center justify-start overflow-x-auto flex-nowrap mt-5 mb-4 px-10 gap-4" style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
                @foreach ($salons as $salon)

                @if ($salon->canton && $salon->ville && $salon->nom_salon )
                <livewire:salon-card name="{{ $salon->nom_salon }}" canton="{{ $salon->canton['nom'] }}" ville="{{ $salon->ville['nom'] }}" salonId="{{ $salon->id }}" avatar="{{ $salon->avatar }}" />
                @endif @endforeach
                @if($salons == '[]')
                <h3 class="w-full font-dm-serif text-3xl text-center text-green-gs">Aucun salon pour l'instant !</h3>
                @else

                @endif
            </div>
            <div id="arrowSalonScrollRight" class="absolute top-[40%] left-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-prev>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" /></svg>
            </div>
            <div id="arrowSalonScrollLeft" class="absolute top-[40%] right-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-next>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z" /></svg>
            </div>
        </div>
    </div>

    {{-- Section listing escort --}}
    <div class="relative w-full mx-auto flex flex-col items-center justify-center mt-4">
        <h3 class="font-dm-serif text-green-gs font-bold text-3xl lg:text-4xl text-center">A la recherche d'un plaisir coquin ?</h3>
        <div id="listingContainer" class="relative w-full flex items-center justify-start overflow-x-auto flex-nowrap mt-5 mb-4 px-10 gap-4" style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
            @foreach ($escorts as $escort)
            @if ($escort->canton && $escort->ville &&  $escort->prenom)
            <livewire:escort-card name="{{ $escort->prenom }}" canton="{{ $escort->canton['nom'] }}" ville="{{ $escort->ville['nom'] }}" avatar="{{ $escort->avatar }}" escortId="{{ $escort->id }}" />
            @endif
            @endforeach
        </div>
        <div id="arrowListScrollRight" class="absolute top-[40%] left-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-prev>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                <path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" /></svg>
        </div>
        <div id="arrowListScrollLeft" class="absolute top-[40%] right-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-next>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                <path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z" /></svg>
        </div>
        <div class="z-10 mb-6">
            <a href="{{ route('escortes') }}" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 text-center dark:focus:ring-blue-800">Tout voir <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z" /></svg>
            </a>
        </div>
    </div>

</div>

<div class="relative flex flex-col items-center justify-center py-10 w-full" style="background: url('images/girl_deco_image.jpg') center center /cover">
    <div class="bg-white/70 absolute top-0 right-0 w-full h-full z-0"></div>
    <h3 class="font-dm-serif text-green-gs text-2xl md:text-3xl lg:text-4xl xl:text-5xl my-4 mx-2 text-center font-bold z-10">Trouver des escortes, masseuses et plus encore sur Gstuff !</h3>
    <div class="flex flex-col w-full px-4 md:flex-row items-center justify-center gap-2 py-6 z-10">

        <div class="w-full lg:w-[367px] lg:h-[263px] bg-[#618E8D] p-3 flex flex-col text-white text-2xl lg:text-4xl font-bold items-center justify-center gap-3">
            <span class="text-center font-dm-serif w-[70%]">+ de 500 partenaires</span>
            <span class="text-center text-sm lg:text-base font-normal w-[75%] mx-auto">Profils vérifiés pour des rencontres authentiques.</span>
        </div>
        <div class="w-full lg:w-[367px] lg:h-[263px] bg-[#618E8D] p-3 flex flex-col text-white text-2xl lg:text-4xl font-bold items-center justify-center gap-3">
            <span class="text-center font-dm-serif w-[70%]">+ de 300 amateurs</span>
            <span class="text-center text-sm lg:text-base font-normal w-[75%] mx-auto">Expériences coquines avec des amateurs dédiés.</span>
        </div>
        <div class="w-full lg:w-[367px] lg:h-[263px] bg-[#618E8D] p-3 flex flex-col text-white text-2xl lg:text-4xl font-bold items-center justify-center gap-3">
            <span class="text-center font-dm-serif w-[70%]">+ de 200 salons professionnels</span>
            <span class="text-center text-sm lg:text-base font-normal w-[75%] mx-auto">Offres variées dans des cadres professionnels sécurisés.</span>
        </div>

    </div>
</div>
<x-FeedbackSection />

<div class="bg-white py-10 w-full overflow-x-hidden flex items-center justify-center flex-col gap-10">
    <h3 class="text-xl md:text-4xl lg:text-5xl font-dm-serif text-green-gs font-bold">Comment devenir escorte sur Gstuff ?</h3>
    <p>Devenez escorte indépendante en 3 étapes !</p>
    <div class="relative grid grid-cols-3 gap-5 text-green-gs  text-xs lg:text-lg text-wrap italic font-normal mt-20 mx-0 px-2">
        <div class="absolute mx-20 top-[20%] col-span-3 w-[70%] h-1 bg-green-gs z-0"></div>
        @foreach ([1, 2, 3] as $items)
        <img class="w-20 h-20 mx-auto z-10" src="{{ asset('images/icons/icon_coeur.svg') }}" alt="coeur image" />
        @endforeach
        <div class="lg:w-52 w-30 text-wrap text-center">Envoyer 5 selfies a <a href="http://escort-gstuff@gstuff.ch" class="text-amber-500">escort-gstuff@gstuff.ch</a></div>
        <div class="lg:w-52 w-30 text-wrap text-center"> Prenez rendez-vous pour le shooting photo</div>
        <div class="lg:w-52 w-30 text-wrap text-center">Publiez votre profil</div>
    </div>
</div>

<x-CallToActionInscription />

<x-CallToActionContact />

{{-- FAQ --}}
<div class="container mx-auto flex flex-col items-center justify-center gap-10">
    <h3 id="FAQ" class="text-3xl lg:text-5xl font-dm-serif text-green-gs">Questions fréquentes</h3>
    <div id="accordion-collapse text-wrap w-full lg:min-w-[1114px]" data-accordion="collapse">
        <h2 id="accordion-collapse-heading-1" class="w-full lg:min-w-[1114px]">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
                <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>Est-ce que le shooting photo est obligatoire?</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
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
                <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>Avez-vous des appartements à louer?</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
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
                <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>Combien puis-je gagner?</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
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
@if ($glossaires != '[]')
<div class="lg:container mx-auto my-10">
    <div class="flex items-center justify-between my-10 px-5 lg:px-20">
        <h3 class="font-dm-serif text-2xl lg:text-4xl text-green-800 font-bold">Articles du glossaire</h3>
        <div class="z-10 w-auto">
            <a href="#" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg px-4 py-2 text-center text-sm lg:text-base dark:focus:ring-blue-800">voir plus d'articles <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z" /></svg>
            </a>
        </div>
    </div>
    <x-GlossaireSection />
</div>

@endif


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

    EscortrightBtn.addEventListener('click', () => {
        scrollByPercentage(Escortcontainer, false, 35)
    })
    EscortleftBtn.addEventListener('click', () => {
        scrollByPercentage(Escortcontainer, true, 35)
    })
    SalonrightBtn.addEventListener('click', () => {
        scrollByPercentage(Saloncontainer, false, 35)
    })
    SalonleftBtn.addEventListener('click', () => {
        scrollByPercentage(Saloncontainer, true, 35)
    })
    ListrightBtn.addEventListener('click', () => {
        scrollByPercentage(Listcontainer, false)
    })
    ListleftBtn.addEventListener('click', () => {
        scrollByPercentage(Listcontainer)
    })

</script>
@endsection

@stop
