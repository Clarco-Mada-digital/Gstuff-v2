<?php 
use App\Models\Canton;
?>
<div>
    <div class="relative w-full min-h-[375px] bg-green-gs transition-all mt-10 z-30">
        <div
            class="flex flex-col items-center lg:flex-row justify-center lg:items-start gap-10 lg:gap-40 container mx-auto py-24 text-white text-sm xl:text-base">
            <div class="flex flex-col items-center justify-center w-full lg:w-auto lg:items-start gap-3">
                <a href="{{ route('home') }}" class="w-full">
                    <img class="mx-auto lg:m-0 w-60" src="{{ url('images/Logo_lg.svg') }}" alt="Logo gstuff" />
                </a>
                <p class="w-96 lg:text-start text-center">Votre portail suisse des rencontres érotique sécurisées et
                    inclusives.</p>
            </div>

            <div class="flex flex-col items-center lg:items-start gap-2">
                <h3 class="font-dm-serif text-4xl font-bold mb-3">Liens rapides</h3>
                @foreach (Canton::all()->slice(0, 5) as $canton)
                    <a href="{{ route('escortes') . '?selectedCanton=' . $canton->id }}">Escort girl
                        {{ $canton->nom }}</a>
                @endforeach
            </div>

            <div class="flex flex-col items-center lg:items-start gap-2">
                <h3 class="font-dm-serif text-4xl font-bold mb-3">Liens rapides</h3>
                <a href="{{ route('glossaires.index') }}">Glossaire</a>
                <a href="{{ route('faq') }}">FAQ</a>
                <a href="{{ route('about') }}">Qui sommes-nous ?</a>
                <a href="{{ route('static.cgv') }}">Conditions générales de vente (GGV)</a>
                <a href="{{ route('contact') }}">Contact</a>
            </div>

        </div>
    </div>
    <div
        class="relative flex items-center justify-center bg-black text-white text-xs lg:text-base py-7 transition-all z-30">
        Copyright {{ now()->year }} - <a href="{{ route('home') }}" class="text-yellow-500 mx-2"> Gstuff </a> -
        <a href="{{ route('static.pdc') }}" class="text-yellow-500 mx-2"> Politique de confidentialité </a>
    </div>
</div>
