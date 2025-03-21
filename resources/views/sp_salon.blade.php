@extends('layouts.base')

  @php
    use Carbon\Carbon;
  @endphp

  @section('pageTitle')
    {{$salon->nom_salon}}
  @endsection

  @section('content')
    <div x-data="{}" x-on:click="$dispatch('img-modal', {  imgModalSrc: '{{$couverture_image = $salon->couverture_image}}' ? '{{asset('storage/couvertures/'.$couverture_image)}}' : '{{asset('images/Logo_lg.svg')}}', imgModalDesc: '' })" class="relative w-full max-h-[30vh] min-h-[30vh] overflow-hidden" style="background: url({{ $salon->couverture_image ? asset('storage/couvertures/'.$salon->couverture_image) : asset('images/Logo_lg.svg')}}) center center /cover;">
    </div>

    <div class="container flex flex-col xl:flex-row justify-center mx-auto">

      <div class="min-w-1/4 flex flex-col items-center gap-3">

        <div x-data="{}" class="w-55 h-55  -translate-y-[50%] rounded-full border-5 border-white mx-auto">
          <img  x-on:click="$dispatch('img-modal', {  imgModalSrc:'{{ $avatar = $salon->avatar}}' ? '{{ asset('storage/avatars/'.$avatar) }}' : '{{asset('images/icon_logo.png')}}', imgModalDesc: '' })" class="w-full h-full rounded-full object-center object-cover"
          @if($avatar = $salon->avatar)
          src="{{ asset('storage/avatars/'.$avatar) }}"
          @else
          src="{{ asset('images/icon_logo.png') }}"
          @endif
          alt="image profile"
          />
        </div>
        <p class="font-bold -mt-[25%] md:-mt-[10%] xl:-mt-[25%]">{{Str::ucfirst($salon->nom_salon)}}</p>
        <span class="flex items-center gap-2 font-bold font-dm-serif">({{Str::ucfirst($salon->categorie['nom'] ?? '')}})</span>
        <a href="tel:0000000" class="flex items-center gap-2 font-bold font-dm-serif"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M19.95 21q-3.125 0-6.187-1.35T8.2 15.8t-3.85-5.55T3 4.05V3h5.9l.925 5.025l-2.85 2.875q.55.975 1.225 1.85t1.45 1.625q.725.725 1.588 1.388T13.1 17l2.9-2.9l5 1.025V21zM16.5 11q-.425 0-.712-.288T15.5 10t.288-.712T16.5 9t.713.288t.287.712t-.288.713T16.5 11"/></svg>{{$salon->telephone ?? 'Pas de téléphone'}}</a>
        <div class="flex items-center justify-center gap-2 text-green-gs">
          <a href="#" class="flex items-center gap-1"> <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="none"><path d="M4 13.2864C2.14864 14.1031 1 15.2412 1 16.5C1 18.9853 5.47715 21 11 21C16.5228 21 21 18.9853 21 16.5C21 15.2412 19.8514 14.1031 18 13.2864M17 7C17 11.0637 12.5 13 11 16C9.5 13 5 11.0637 5 7C5 3.68629 7.68629 1 11 1C14.3137 1 17 3.68629 17 7ZM12 7C12 7.55228 11.5523 8 11 8C10.4477 8 10 7.55228 10 7C10 6.44772 10.4477 6 11 6C11.5523 6 12 6.44772 12 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg> {{$salon->canton->nom ?? ''}}</a>
          <a href="#" class="flex items-center gap-1"> <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.5m3 0H10m3 0h6m-6 6l6-6m-6-6l6 6"/></svg></svg> {{$salon->ville->nom ?? ''}}</a>
        </div>
        <div class="flex items-center justify-center gap-2 text-green-gs">
          <span class="flex items-center gap-1">Recrutement : {{$salon->recrutement ?? ''}}</span>
        </div>
        <hr class="w-full h-2">

        <button class="flex items-center justify-center gap-2 w-full p-2 text-green-gs text-sm rounded-lg border border-gray-400 cursor-pointer hover:bg-green-gs hover:text-white">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><!-- Icon from All by undefined - undefined --><path fill="currentColor" fill-rule="evenodd" d="M5.624 4.424C3.965 5.182 2.75 6.986 2.75 9.137c0 2.197.9 3.891 2.188 5.343c1.063 1.196 2.349 2.188 3.603 3.154q.448.345.885.688c.526.415.995.778 1.448 1.043s.816.385 1.126.385s.674-.12 1.126-.385c.453-.265.922-.628 1.448-1.043q.437-.344.885-.687c1.254-.968 2.54-1.959 3.603-3.155c1.289-1.452 2.188-3.146 2.188-5.343c0-2.15-1.215-3.955-2.874-4.713c-1.474-.673-3.41-.568-5.304 1.088L14.53 6.97a.75.75 0 1 1-1.06 1.061l-2-1.999l-.01-.01c-2.058-2.14-4.224-2.335-5.836-1.598M12 4.46C9.688 2.39 7.099 2.1 5 3.059C2.786 4.074 1.25 6.426 1.25 9.138c0 2.665 1.11 4.699 2.567 6.339c1.166 1.313 2.593 2.412 3.854 3.382q.43.33.826.642c.513.404 1.063.834 1.62 1.16s1.193.59 1.883.59s1.326-.265 1.883-.59c.558-.326 1.107-.756 1.62-1.16q.396-.312.826-.642c1.26-.97 2.688-2.07 3.854-3.382c1.457-1.64 2.567-3.674 2.567-6.339c0-2.712-1.535-5.064-3.75-6.077c-2.099-.96-4.688-.67-7 1.399" clip-rule="evenodd"/></svg>
          {{-- <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from All by undefined - undefined --><path fill="currentColor" d="M2 9.137C2 14 6.02 16.591 8.962 18.911C10 19.729 11 20.5 12 20.5s2-.77 3.038-1.59C17.981 16.592 22 14 22 9.138S16.5.825 12 5.501C7.5.825 2 4.274 2 9.137"/></svg> --}}
          Ajouter au favoris
        </button>
        <button class="flex items-center justify-center gap-2 w-full p-2 text-green-gs text-sm rounded-lg border border-gray-400 cursor-pointer hover:bg-green-gs hover:text-white">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 3c5.5 0 10 3.58 10 8s-4.5 8-10 8c-1.24 0-2.43-.18-3.53-.5C5.55 21 2 21 2 21c2.33-2.33 2.7-3.9 2.75-4.5C3.05 15.07 2 13.13 2 11c0-4.42 4.5-8 10-8m5 9v-2h-2v2zm-4 0v-2h-2v2zm-4 0v-2H7v2z"/></svg>
          Ecrire un message
        </button>
        <button class="flex items-center justify-center gap-2 w-full p-2 text-green-gs text-sm rounded-lg border border-gray-400 cursor-pointer hover:bg-green-gs hover:text-white">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 448c141.4 0 256-93.1 256-208S397.4 32 256 32S0 125.1 0 240c0 45.1 17.7 86.8 47.7 120.9c-1.9 24.5-11.4 46.3-21.4 62.9c-5.5 9.2-11.1 16.6-15.2 21.6c-2.1 2.5-3.7 4.4-4.9 5.7c-.6.6-1 1.1-1.3 1.4l-.3.3c-4.6 4.6-5.9 11.4-3.4 17.4s8.3 9.9 14.8 9.9c28.7 0 57.6-8.9 81.6-19.3c22.9-10 42.4-21.9 54.3-30.6c31.8 11.5 67 17.9 104.1 17.9zM96 212.8c0-20.3 16.5-36.8 36.8-36.8H152c8.8 0 16 7.2 16 16s-7.2 16-16 16h-19.2c-2.7 0-4.8 2.2-4.8 4.8c0 1.6.8 3.1 2.2 4l29.4 19.6c10.3 6.8 16.4 18.3 16.4 30.7c0 20.3-16.5 36.8-36.8 36.8l-27.2.1c-8.8 0-16-7.2-16-16s7.2-16 16-16h27.2c2.7 0 4.8-2.2 4.8-4.8c0-1.6-.8-3.1-2.2-4l-29.4-19.6c-10.2-6.9-16.4-18.4-16.4-30.8M372.8 176H392c8.8 0 16 7.2 16 16s-7.2 16-16 16h-19.2c-2.7 0-4.8 2.2-4.8 4.8c0 1.6.8 3.1 2.2 4l29.4 19.6c10.2 6.8 16.4 18.3 16.4 30.7c0 20.3-16.5 36.8-36.8 36.8l-27.2.1c-8.8 0-16-7.2-16-16s7.2-16 16-16h27.2c2.7 0 4.8-2.2 4.8-4.8c0-1.6-.8-3.1-2.2-4l-29.4-19.6c-10.2-6.8-16.4-18.3-16.4-30.7c0-20.3 16.5-36.8 36.8-36.8zm-152 6.4l35.2 46.9l35.2-46.9c4.1-5.5 11.3-7.8 17.9-5.6S320 185.1 320 192v96c0 8.8-7.2 16-16 16s-16-7.2-16-16v-48l-19.2 25.6c-3 4-7.8 6.4-12.8 6.4s-9.8-2.4-12.8-6.4L224 240v48c0 8.8-7.2 16-16 16s-16-7.2-16-16v-96c0-6.9 4.4-13 10.9-15.2s13.7.1 17.9 5.6"/></svg>
          Pas de contact sms
        </button>
        <button class="flex items-center justify-center gap-2 w-full p-2 text-green-gs text-sm rounded-lg border border-gray-400 cursor-pointer hover:bg-green-gs hover:text-white">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2.546 20.2A1.01 1.01 0 0 0 3.8 21.454l3.032-.892A9.96 9.96 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2M9.738 14.263c2.023 2.022 3.954 2.289 4.636 2.314c1.037.038 2.047-.754 2.44-1.673a.7.7 0 0 0-.088-.703c-.548-.7-1.289-1.203-2.013-1.703a.71.71 0 0 0-.973.158l-.6.915a.23.23 0 0 1-.305.076c-.407-.233-1-.629-1.426-1.055s-.798-.992-1.007-1.373a.23.23 0 0 1 .067-.291l.924-.686a.71.71 0 0 0 .12-.94c-.448-.656-.97-1.49-1.727-2.043a.7.7 0 0 0-.684-.075c-.92.394-1.716 1.404-1.678 2.443c.025.682.292 2.613 2.314 4.636"/></g></svg>
          Pas de contact whatsapp
        </button>
        <a href="mailto:{{$salon->email}}" class="flex items-center justify-center gap-2 w-full p-2 text-green-gs text-sm rounded-lg border border-gray-400 cursor-pointer hover:bg-green-gs hover:text-white">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10h5v-2h-5c-4.34 0-8-3.66-8-8s3.66-8 8-8s8 3.66 8 8v1.43c0 .79-.71 1.57-1.5 1.57s-1.5-.78-1.5-1.57V12c0-2.76-2.24-5-5-5s-5 2.24-5 5s2.24 5 5 5c1.38 0 2.64-.56 3.54-1.47c.65.89 1.77 1.47 2.96 1.47c1.97 0 3.5-1.6 3.5-3.57V12c0-5.52-4.48-10-10-10m0 13c-1.66 0-3-1.34-3-3s1.34-3 3-3s3 1.34 3 3s-1.34 3-3 3"/></svg>
          {{$salon->email ?? ''}}
        </a>

      </div>

      <div class="min-w-3/4 px-5 py-5">
        <div class="text-right w-full text-green-gs font-dm-serif font-bold"> <a href="#">{{Str::ucfirst($salon->categorie->nom ?? '')}}</a>  / <a href="#">{{Str::ucfirst($salon->canton->nom ?? '')}}</a> / {{Str::ucfirst($salon->profile_type ?? '')}} / {{Str::ucfirst($salon->nom_salon)}}</div>

        <div>

          <section>

            {{-- Galerie --}}
            <div class="flex items-center justify-between gap-5 py-5">

              <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Galerie</h2>
              <div class="flex-1 h-0.5 bg-green-gs"></div>

            </div>
            <div class="flex items-center gap-10 flex-wrap">
              <span class="w-full text-center text-green-gs font-bold font-dm-serif">Aucun stories trovée !</span>
            </div>

            {{-- A propos de moi --}}
            <div class="flex items-center justify-between gap-5 py-5">

              <h2 class="font-dm-serif font-bold text-2xl text-green-gs">A propos de moi</h2>
              <div class="flex-1 h-0.5 bg-green-gs"></div>

            </div>
            <div class="flex items-center gap-10 flex-wrap">
              <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 w-full">
                
                <div class="w-full flex items-center gap-3 font-dm-serif">
                  <img src="{{ asset('images/icons/escort_icon.svg') }}" alt="age icon" />
                  <span>Nombre des filles : {{$salon->nombre_filles ?? '-'}} filles</span>
                </div>
                <div class="w-full flex items-center gap-3 font-dm-serif">
                  <img src="{{ asset('images/icons/langue_icon.svg') }}" alt="age icon" />
                  <span>Langue : {{$salon->langue ?? '-'}}</span>
                </div>
                <div class="w-full flex items-center gap-3 font-dm-serif">
                  <img src="{{ asset('images/icons/tarif_icon.svg') }}" alt="age icon" />
                  @if($salon->tarif)
                  <span>Tarifs à partir de {{$salon->tarif ?? '-'}}.-CHF </span>
                  @else
                  <span>Contacter-nous pour connaitre nos tarifs</span>
                  @endif
                </div>
                <div class="w-full flex items-center gap-3 font-dm-serif">
                  <img src="{{ asset('images/icons/cart_icon.svg') }}" alt="age icon" />
                  <span>Moyen de paiement : {{$salon->paiement ?? '-'}}</span>
                </div>
                <div class="w-full flex items-center gap-3 font-dm-serif">
                  <img src="{{ asset('images/icons/cart_icon.svg') }}" alt="age icon" />
                  <span>Autre contact : {{$salon->autre_contact ?? '-'}}</span>
                </div>

              </div>
            </div>

            {{-- Description --}}
            <div class="flex items-center justify-between gap-5 py-5">

              <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Description</h2>
              <div class="flex-1 h-0.5 bg-green-gs"></div>
              {{-- <button class="flex items-center gap-2 text-amber-400">
                Modifier
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
              </button> --}}

            </div>
            <div class="flex items-center gap-10 flex-wrap">
              <p class="text-justify">{{$salon->apropos ?? '-'}}</p>
            </div>

            {{-- Escort associé --}}
            <div class="flex items-center justify-between gap-5 py-5">

              <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Nos professionels</h2>
              <div class="flex-1 h-0.5 bg-green-gs"></div>

            </div>
            <div class="w-full flex items-center gap-10 flex-wrap">
              <span class="w-full text-center text-green-gs font-bold font-dm-serif">Aucun escort associé pour l'instant</span>
            </div>

            {{-- Galerie privée --}}
            @guest
            <div class="w-full flex flex-col items-center justify-center font-dm-serif gap-5 text-green-gs my-3">
              <svg class="w-25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M6 7.5a5.5 5.5 0 1 1 11 0a5.5 5.5 0 0 1-11 0M18 14c.69 0 1.25.56 1.25 1.25V16h-2.5v-.75c0-.69.56-1.25 1.25-1.25m3.25 2v-.75a3.25 3.25 0 0 0-6.5 0V16h-1.251v6.5h9V16zm-9.75 6H2v-2a6 6 0 0 1 6-6h3.5z"/></svg>
              <p class="font-extrabold text-3xl text-center">Connectez-vous pour voir le contenu privée de Daniela</p>
              <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="font-dm-serif font-bold btn-gs-gradient rounded-lg">Se connecter / s'inscrire</button>
            </div>
            @endguest
            @auth
            <div class="flex items-center justify-between gap-5 py-5">

              <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Galerie privée</h2>
              <div class="flex-1 h-0.5 bg-green-gs"></div>

            </div>
            <div class="flex items-center gap-10 flex-wrap">
              <span class="w-full text-center text-green-gs font-bold font-dm-serif">Attention ! Vous n'avez droit qu'à 5 vidéos</span>
              <span class="w-full text-center text-green-gs font-bold font-dm-serif">Aucun vidéo pour l'instant</span>
            </div>
            @endauth

            {{-- Feed-back et note --}}            
            <livewire:feedback :userToId=$salon />

          </section>

        </div>

      </div>

    </div>

  @stop
