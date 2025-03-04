@extends('layouts.base')
  @php
    use Carbon\Carbon;
  @endphp

  @section('pageTitle')
      Profile page
  @endsection

  @section('content')
  <div class="relative w-full min-h-[30vh]" style="background: url('images/Logo_lg.svg') center center /cover">
    {{-- <img class="w-full object-center object-cover" src="{{asset('images/girl_deco_image.jpg')}}" alt="Couverture image" srcset="couverture_image"> --}}
    <button class="absolute hidden shadow-xl p-2 rounded-md right-2 bottom-1 md:flex items-end gap-2 text-amber-300 hover:text-green-gs"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg> Modifier photo de couverture</button>
  </div>

  <div x-data="{pageSection: $persist('compte'), userType:'{{ Auth::user()->profile_type }}'}" class="container flex flex-col xl:flex-row justify-center mx-auto">

    <div class="min-w-1/4 flex flex-col items-center gap-3">

      <div class="w-55 h-55  -translate-y-[50%] rounded-full border-5 border-white mx-auto" style="background: url('{{ asset('images/icon_logo.png') }}') center center /cover">
      </div>
      <a href="#" class="flex md:hidden items-center gap-3 -mt-[25%] "><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>Modifier photo de couverture</a>
      <a href="#" class="flex items-center gap-3 md:-mt-[10%] xl:-mt-[25%]"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M15.275 12.475L11.525 8.7L14.3 5.95l-.725-.725L8.1 10.7L6.7 9.3l5.45-5.475q.6-.6 1.413-.6t1.412.6l.725.725l1.25-1.25q.3-.3.713-.3t.712.3L20.7 5.625q.3.3.3.713t-.3.712zM6.75 21H3v-3.75l7.1-7.125l3.775 3.75z"/></svg>Modifier photo de profil</a>
      <p class="font-bold">{{ Auth::user()->pseudo ?? Auth::user()->prenom ?? Auth::user()->nom_salon }}</p>
      <div class="flex items-center justify-center gap-2 text-green-gs">
        <a href="#" class="flex items-center gap-1"> <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="none"><path d="M4 13.2864C2.14864 14.1031 1 15.2412 1 16.5C1 18.9853 5.47715 21 11 21C16.5228 21 21 18.9853 21 16.5C21 15.2412 19.8514 14.1031 18 13.2864M17 7C17 11.0637 12.5 13 11 16C9.5 13 5 11.0637 5 7C5 3.68629 7.68629 1 11 1C14.3137 1 17 3.68629 17 7ZM12 7C12 7.55228 11.5523 8 11 8C10.4477 8 10 7.55228 10 7C10 6.44772 10.4477 6 11 6C11.5523 6 12 6.44772 12 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg> Suisse Alémanique</a>
        <a href="tel:0000000" class="flex items-center gap-1"> <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M19.95 21q-3.125 0-6.187-1.35T8.2 15.8t-3.85-5.55T3 4.05V3h5.9l.925 5.025l-2.85 2.875q.55.975 1.225 1.85t1.45 1.625q.725.725 1.588 1.388T13.1 17l2.9-2.9l5 1.025V21z"/></svg> 26155489635</a>
      </div>
      <hr class="w-full h-2">

      <button data-modal-target="addInfoProf" data-modal-toggle="addInfoProf" class="w-full p-2 text-green-gs text-sm rounded-lg border border-gray-400 cursor-pointer hover:bg-green-gs hover:text-white">Amelioré mon profile</button>

      <div x-show="userType=='invite'" class="w-full flex flex-col gap-0 items-center mb-5">
        <button x-on:click="pageSection='compte'" :class="pageSection == 'compte' ? 'bg-green-gs text-white rounded-md' : '' " class="w-full p-2 text-green-gs border-b border-gray-400 text-left font-bold cursor-pointer hover:bg-green-gs hover:text-white">Mon compte</button>
        <button x-on:click="pageSection='favoris'" :class="pageSection == 'favoris' ? 'bg-green-gs text-white rounded-md' : '' " class="w-full p-2 text-green-gs border-b border-gray-400 text-left font-bold cursor-pointer hover:bg-green-gs hover:text-white">Mes favoris</button>
        <button x-on:click="pageSection='discussion'" :class="pageSection == 'discussion' ? 'bg-green-gs text-white rounded-md' : '' " class="w-full p-2 text-green-gs border-b border-gray-400 text-left font-bold cursor-pointer hover:bg-green-gs hover:text-white">Discussion</button>
      </div>
      <div x-show="userType=='escorte'" class="w-full flex flex-col gap-0 items-center mb-5">
        <button x-on:click="pageSection='compte'" :class="pageSection == 'compte' ? 'bg-green-gs text-white rounded-md' : '' " class="w-full p-2 text-green-gs border-b border-gray-400 text-left font-bold cursor-pointer hover:bg-green-gs hover:text-white">Mon compte</button>
        <button x-on:click="pageSection='galerie'" :class="pageSection == 'galerie' ? 'bg-green-gs text-white rounded-md' : '' " class="w-full p-2 text-green-gs border-b border-gray-400 text-left font-bold cursor-pointer hover:bg-green-gs hover:text-white">Galerie</button>
        <button x-on:click="pageSection='discussion'" :class="pageSection == 'discussion' ? 'bg-green-gs text-white rounded-md' : '' " class="w-full p-2 text-green-gs border-b border-gray-400 text-left font-bold cursor-pointer hover:bg-green-gs hover:text-white">Discussion</button>
      </div>
      <div x-show="userType=='salon'" class="w-full flex flex-col gap-0 items-center mb-5">
        <button x-on:click="pageSection='compte'" :class="pageSection == 'compte' ? 'bg-green-gs text-white rounded-md' : '' " class="w-full p-2 text-green-gs border-b border-gray-400 text-left font-bold cursor-pointer hover:bg-green-gs hover:text-white">Mon compte</button>
        <button x-on:click="pageSection='galerie'" :class="pageSection == 'galerie' ? 'bg-green-gs text-white rounded-md' : '' " class="w-full p-2 text-green-gs border-b border-gray-400 text-left font-bold cursor-pointer hover:bg-green-gs hover:text-white">Galerie</button>
        <button x-on:click="pageSection='discussion'" :class="pageSection == 'discussion' ? 'bg-green-gs text-white rounded-md' : '' " class="w-full p-2 text-green-gs border-b border-gray-400 text-left font-bold cursor-pointer hover:bg-green-gs hover:text-white">Discussion</button>
      </div>

    </div>

    <div x-data="multiStepForm()" id="addInfoProf" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <!-- Modale -->
      <div class="bg-white rounded-lg shadow-lg p-6 w-[90vw] max-h-[90vh] xl:max-w-7xl overflow-y-auto">
        <!-- Étapes -->
        <div class="w-full flex justify-between gap-5 mb-6">
          <template class="w-full" x-for="(step, index) in steps" :key="index">
            <div :class="index < steps.length - 1 ? 'w-full':'w-auto xl:w-full'"  class="flex items-center justify-start">
              <div
                x-on:click="currentStep=index"
                class="w-8 h-8 flex mx-2 items-center justify-center rounded-full cursor-pointer"
                :class="{
                  'bg-amber-400 text-white': index < currentStep,
                  'bg-blue-500 text-white animate-bounce': index === currentStep,
                  'bg-gray-300 text-gray-600': index > currentStep
                }">
                <span x-text="index + 1"></span>
              </div>
              <span class="hidden xl:block" :class="{'text-amber-400': index < currentStep}" x-text="step"></span>
              <span :class="index < steps.length - 1 ? 'flex':'hidden'"  class="flex-1 w-16 h-1 bg-gray-300 md:mx-1"></span>
            </div>
          </template>
        </div>

        <!-- Contenu du formulaire -->
        <form @submit.prevent="submitForm" action="#" method="POST">
          <!-- Étape 1: Informations personnelles -->
          <div x-show="currentStep === 0">
            <h2 class="text-lg font-semibold mb-4">Informations personnelles</h2>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">intitule</label>
              <select name="intitule" id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{Auth::user()->intitule}}">
                <option hidden> -- </option>
                <option value="monsieur">monsieur</option>
                <option value="madame">madame</option>
                <option value="mademoiselle">mademoiselle</option>
                <option value="autre">autre</option>
              </select>
            </div>
            @if (Auth::user()->profile_type=='salon')
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nom du proprietaire</label>
                <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ Auth::user()->nom_proprietaire }}">
              </div>
            @endif
            @if (Auth::user()->profile_type=='escorte')
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Prenom</label>
                <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ Auth::user()->prenom }}">
              </div>
            @endif
            @if (Auth::user()->profile_type=='invite')
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Pseudo</label>
                <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ Auth::user()->pseudo }}">
              </div>
            @endif
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Email</label>
              <input type="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ Auth::user()->email }}">
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Numéro téléphone</label>
              <input type="tel" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Adresse</label>
              <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">NPA</label>
              <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Canton</label>
              <select name="intitule" id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
                @foreach ($apiData['cantons'] as $data)
                <option value="{{$data['title']['rendered']}}">{{$data['title']['rendered']}}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Ville</label>
              <select name="intitule" id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
          </div>

          <!-- Étape 2: Informations professionnelles -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5" :class="userType == 'invite' ? 'hidden':''" x-show="currentStep === 1">
            <h2 class="text-lg font-semibold mb-4 col-span-2">Informations professionnelles</h2>
            @if (Auth::user()->profile_type=='salon')
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Catégories</label>
              <select name="categorie" id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Recrutement</label>
              <select name="recrutement" id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
                <option value="monsieur">Ouvert</option>
                <option value="madame">Fermer</option>
              </select>
            </div>
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Numbre des filles</label>
              <input type="number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            @endif
            @if (Auth::user()->profile_type=='escorte')
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Categories</label>
              <select name="origine" id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Pratique sexuels</label>
              <select name="origine" id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Tailles</label>
              <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></input>
            </div>
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Origine</label>
              <select name="origine" id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Couleur des yeux</label>
              <select id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Couleur des cheveux</label>
              <select id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Mensuration</label>
              <select id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Poitrine</label>
              <select id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Taille de poitrine</label>
              <select id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Poils du pubis</label>
              <select id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Tatouages</label>
              <select id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Mobilité</label>
              <select id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
            @endif
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Tarif</label>
              <select id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
            <div class="mb-4 col-span-2 md:col-span-1">
              <label class="block text-sm font-medium text-gray-700">Moyen de paiement</label>
              <select id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option hidden> -- </option>
              </select>
            </div>
            <div class="mb-4 col-span-2">
              <label class="block text-sm font-medium text-gray-700">Apropos</label>
              <textarea class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
          </div>

          <!-- Étape 3: Informations complémentaires -->
          <div @if (Auth::user()->profile_type == 'invite')
              x-show="currentStep === 1"
              @else
              x-show="currentStep === 2"
              @endif >
            <h2 class="text-lg font-semibold mb-4">Informations complémentaires</h2>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Autre contact</label>
              <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Complement d'adresse</label>
              <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Lien site web</label>
              <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></input>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">localisation</label>
              <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="h-70 rounded-lg overflow-hidden">
              <img src="{{ asset('images/map_placeholder.png')}}" alt="map image" srcset="map image" class="w-full object-cover object-center">
            </div>
          </div>

          <!-- Boutons de navigation -->
          <div class="flex justify-between gap-2 mt-6 text-sm md:text-base">
            <button
              type="button"
              @click="prevStep"
              class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md"
              x-show="currentStep > 0"
            >
              Précédent
            </button>
            <button
              type="button"
              @click="saveAndQuit"
              class="px-4 py-2 bg-amber-500 text-white rounded-md"
              x-show="currentStep < steps.length - 1"
            >
              Enregister et quiter
            </button>
            <button
              type="button"
              @click="nextStep"
              class="px-4 py-2 bg-blue-500 text-white rounded-md"
              x-show="currentStep < steps.length - 1"
            >
              Suivant
            </button>
            <button
              id="addInfoSubmit"
              type="submit"
              class="px-4 py-2 bg-green-500 text-white rounded-md"
              x-show="currentStep === steps.length - 1"
            >
              Soumettre
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="min-w-3/4 px-5 py-5">
      <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Danger</span>
        <div class="text-dm-serif">
          <span class="font-bold">Votre profil est actuellement rempli à 10%.</span>
          <div class="my-1.5">
            Pour profiter pleinement des services offerts par Gstuff, nous vous recommandons vivement de compléter vos informations avec des données réelles. Chez Gstuff, nous nous engageons à respecter votre vie privée. Toutes les données collectées sont utilisées pour vous offrir une expérience optimale sur la plateforme. Consultez notre politique de confidentialité ici : <a class="font-bold" href="{{route('pdc')}}">Politique de confidentialité</a>
          </div>
          <button data-modal-target="addInfoProf" data-modal-toggle="addInfoProf" class="font-dm-serif font-bold border text-green-gs border-green-600 px-2 py-1 hover:bg-green-gs hover:text-white rounded-lg transition-all">Amelioré mon profile</button>
        </div>
      </div>

      <div x-show="userType=='invite'">

        {{-- Section mon compte --}}
        <section x-show="pageSection=='compte'">

          {{-- Information --}}
          <div class="flex items-center justify-between py-5">
            <h2 class="font-dm-serif font-bold text-2xl">Mes informations</h2>
            <button class="flex items-center gap-2 text-amber-400"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg> <span class="hidden md:block">Modifier mes informations</span> </button>
          </div>
          <div class="grid grid-cols-2 md:grid-cols-4 items-center gap-10">
            <span class="flex items-center gap-2"><svg class="w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5.85 17.1q1.275-.975 2.85-1.537T12 15t3.3.563t2.85 1.537q.875-1.025 1.363-2.325T20 12q0-3.325-2.337-5.663T12 4T6.337 6.338T4 12q0 1.475.488 2.775T5.85 17.1M12 13q-1.475 0-2.488-1.012T8.5 9.5t1.013-2.488T12 6t2.488 1.013T15.5 9.5t-1.012 2.488T12 13m0 9q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22"/></svg> {{ Auth::user()->pseudo }}</span>
            <span class="flex items-center gap-2"> <svg class="w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M14.5 8a6.5 6.5 0 1 1-13 0a6.5 6.5 0 0 1 13 0M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-9.75 2.5a.75.75 0 0 0 0 1.5h3.5a.75.75 0 0 0 0-1.5h-1V7H7a.75.75 0 0 0 0 1.5h.25v2zM8 6a1 1 0 1 0 0-2a1 1 0 0 0 0 2" clip-rule="evenodd"/></svg> {{ Carbon::parse(Auth::user()->date_naissance)->age }} ans</span>
            <span class="flex items-center gap-2"> <svg class="w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path fill="currentColor" d="M208 20h-40a12 12 0 0 0 0 24h11l-15.64 15.67A68 68 0 1 0 108 178.92V192H88a12 12 0 0 0 0 24h20v16a12 12 0 0 0 24 0v-16h20a12 12 0 0 0 0-24h-20v-13.08a67.93 67.93 0 0 0 46.9-100.84L196 61v11a12 12 0 0 0 24 0V32a12 12 0 0 0-12-12m-88 136a44 44 0 1 1 44-44a44.05 44.05 0 0 1-44 44"/></svg> Homme</span>
            <span class="flex items-center gap-2"> <svg class="w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M4.35 20.7q-.5.2-.925-.112T3 19.75v-14q0-.325.188-.575T3.7 4.8L9 3l6 2.1l4.65-1.8q.5-.2.925.113T21 4.25v8.425q-.875-1.275-2.187-1.975T16 10q-.5 0-1 .088t-1 .262v-3.5l-4-1.4v13.075zM20.6 22l-2.55-2.55q-.45.275-.962.413T16 20q-1.65 0-2.825-1.175T12 16t1.175-2.825T16 12t2.825 1.175T20 16q0 .575-.137 1.088t-.413.962L22 20.6zM16 18q.85 0 1.413-.5T18 16q.025-.85-.562-1.425T16 14t-1.425.575T14 16t.575 1.425T16 18"/></svg> Vaud - Bex</span>
          </div>

          {{-- Favoris --}}
          <div class="flex items-center justify-center md:justify-start py-5">
            <h2 class="font-dm-serif font-bold text-2xl">Mes favoris</h2>
          </div>
          <div class="grid grid-cols-1 xl:grid-cols-2 gap-10 w-full">
            <div class="xl:w-1/2 flex flex-col items-center justify-center gap-4 min-w-full">
              <h3 class="font-dm-serif text-xl text-green-gs">Mes escortes favoris</h3>
              <div>Aucun favoris escorte pour l'instant</div>
            </div>
            <div class="xl:w-1/2 flex flex-col items-center justify-center gap-4 min-w-full">
              <h3 class="font-dm-serif text-xl text-green-gs">Mes salons favoris</h3>
              <div>Aucun favoris salon pour l'instant</div>
            </div>
          </div>

          {{-- Filles près de chez toi --}}
          <div class="flex items-center justify-center md:justify-start py-5">
            <h2 class="font-dm-serif font-bold text-2xl">Les filles hot près de chez toi</h2>
          </div>
          <div class="w-full grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 items-center mb-4 gap-4">
            @foreach (array_slice($apiData['escorts'], 0, 4) as $escort)
              <div class="relative mx-auto flex flex-col justify-start min-w-[317px] w-[317px] min-h-[505px] mb-2 p-1 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700" style="scroll-snap-align: center">
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
                    <span>Suisse Allemanique</span>
                    <span>| Genève</span>
                  </p>
                </div>
              </div>
            @endforeach
          </div>

        </section>

        <section x-show="pageSection=='favoris'">
          <div class="flex items-center gap-5 py-5">
            <h2 class="font-dm-serif font-bold text-2xl">Mes favoris</h2>
            <div class="flex-1 w-full h-1 bg-green-gs"></div>
          </div>
          <div class="grid grid-cols- xl:grid-cols-2 w-full">
            <div class="xl:w-1/2 flex flex-col items-center justify-center gap-10 min-w-full">
              <h3 class="font-dm-serif text-xl text-green-gs">Mes escortes favoris</h3>
              <div>Aucun favoris escorte pour l'instant</div>
            </div>
            <div class="xl:w-1/2 flex flex-col items-center justify-center gap-10 min-w-full">
              <h3 class="font-dm-serif text-xl text-green-gs">Mes salons favoris</h3>
              <div>Aucun favoris salon pour l'instant</div>
            </div>
          </div>
        </section>

        <section x-show="pageSection=='discussion'">
          <div class="py-5">
            <h2 class="font-dm-serif font-bold text-2xl my-5">Discussions</h2>
            <div class="w-[90%] mx-auto h-1 bg-green-gs"></div>
          </div>
        </section>

      </div>

      <div x-show="userType=='escorte'">
        <div class="w-full p-5 rounded-xl flex items-center justify-between border border-green-gs text-green-gs">
          <p>Votre profil n'est pas vérifié, envoyé une demande de vérification</p>
          <button class="btn-gs-gradient text-black">Envoyer une demande</button>
        </div>

        {{-- Section mon compte --}}
        <section x-show="pageSection=='compte'">

          {{-- Storie --}}
          <div class="flex items-center justify-between gap-5 py-5">

            <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Stories</h2>
            <div class="flex-1 h-0.5 bg-green-gs"></div>
            <button class="flex items-center gap-2 text-amber-400">
              Ajouter
              <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
            </button>

          </div>
          <div class="flex items-center gap-10 flex-wrap">
            <span class="w-full text-center text-green-gs font-bold font-dm-serif">Aucun stories trovée !</span>
          </div>

          {{-- Galerie --}}
          <div class="flex items-center justify-between gap-5 py-5">

            <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Galerie</h2>
            <div class="flex-1 h-0.5 bg-green-gs"></div>
            <button class="flex items-center gap-2 text-amber-400">
              Ajouter
              <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
            </button>

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
                <img src="{{ asset('images/icons/age_icon.svg') }}" alt="age icon" srcset="age icon">
                <span>Age : {{ Carbon::parse(Auth::user()->date_naissance)->age }} ans</span>
              </div>
              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/origine_icon.svg') }}" alt="age icon" srcset="age icon">
                <span>Origine : Française </span>
              </div>
              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/langue_icon.svg') }}" alt="age icon" srcset="age icon">
                <span>Langue : Française, Anglais</span>
              </div>

              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/yeux_icon.svg') }}" alt="age icon" srcset="age icon">
                <span>Couleur des yeux : Marrons </span>
              </div>
              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/cheveux_icon.svg') }}" alt="age icon" srcset="age icon">
                <span>Couleur des cheveux : Rousse </span>
              </div>
              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/tarif_icon.svg') }}" alt="age icon" srcset="age icon">
                <span>Tarifs à partir de 250.-CHF </span>
              </div>

              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/taille_icon.svg') }}" alt="age icon" srcset="age icon">
                <span>Taille : +/- 175cm </span>
              </div>
              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/poitrine_icon.svg') }}" alt="age icon" srcset="age icon">
                <span>Poitrine : Améliorée </span>
              </div>
              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/mobilite.svg') }}" alt="age icon" srcset="age icon">
                <span>Mobilité : Je reçois</span>
              </div>

              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/mensuration.svg') }}" alt="age icon" srcset="age icon">
                <span>Mensurations : Normale</span>
              </div>
              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/taill_poit.svg') }}" alt="age icon" srcset="age icon">
                <span>Taille de poitrine : Bonnet D </span>
              </div>
              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/cart_icon.svg') }}" alt="age icon" srcset="age icon">
                <span>Moyen de paiement : CHF, Euros, Dollars</span>
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
            <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus repudiandae delectus molestias error tenetur dolores corrupti consequatur voluptates sequi, aspernatur voluptate blanditiis. Reprehenderit mollitia repellat porro deleniti dolor voluptates quo. </p>
          </div>

          {{-- Service --}}
          <div class="flex items-center justify-between gap-5 py-5">

            <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Services proposés</h2>
            <div class="flex-1 h-0.5 bg-green-gs"></div>

          </div>
          <div class="flex flex-col justify-center gap-5 flex-wrap">
            <div class="flex items-center gap-5 font-dm-serif font-bold text-green-gs">
              Catégories
              <button class="flex items-center gap-2 text-amber-400">
                Modifier
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
              </button>
            </div>
            <div class="flex items-center gap-5">
              <span class="px-2 border border-green-gs text-green-gs rounded-lg hover:bg-amber-300">Escort</span>
            </div>

            <div class="flex items-center gap-5 font-dm-serif font-bold text-green-gs">
              Services fournies
              <button class="flex items-center gap-2 text-amber-400">
                Modifier
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
              </button>
            </div>
            <div class="flex items-center gap-5">
              <span class="px-2 border border-green-gs text-green-gs rounded-lg hover:bg-amber-300">Gorge Profonde</span>
              <span class="px-2 border border-green-gs text-green-gs rounded-lg hover:bg-amber-300">Café Pipe</span>
              <span class="px-2 border border-green-gs text-green-gs rounded-lg hover:bg-amber-300">Duo</span>
            </div>

          </div>

          {{-- Salon associé --}}
          <div class="flex items-center justify-between gap-5 py-5">

            <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Salon associé</h2>
            <div class="flex-1 h-0.5 bg-green-gs"></div>
            <button class="flex items-center gap-2 text-amber-400">
              Modifier
              <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
            </button>

          </div>
          <div class="w-full flex items-center gap-10 flex-wrap">
            <span class="w-full text-center text-green-gs font-bold font-dm-serif">Aucun salon associé pour l'instant</span>
          </div>

           {{-- Galerie privée --}}
           <div class="flex items-center justify-between gap-5 py-5">

            <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Galerie privée</h2>
            <div class="flex-1 h-0.5 bg-green-gs"></div>
            <button class="flex items-center gap-2 text-amber-400">
              Modifier
              <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
            </button>

          </div>
          <div class="flex items-center gap-10 flex-wrap">
            <span class="w-full text-center text-green-gs font-bold font-dm-serif">Attention ! Vous n'avez droit qu'à 5 vidéos</span>
            <span class="w-full text-center text-green-gs font-bold font-dm-serif">Aucun vidéo pour l'instant</span>
          </div>

        </section>

        <section x-show="pageSection=='galerie'">
          {{-- Storie --}}
          <div class="flex items-center justify-between gap-5 py-5">

          <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Galerie</h2>
          <div class="flex-1 h-0.5 bg-green-gs"></div>
          <button class="flex items-center gap-2 text-amber-400">
            Ajouter/Modifier
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
          </button>

          </div>
          <div class="flex items-center gap-10 flex-wrap">
            <span class="w-full text-center text-green-gs font-bold font-dm-serif">Aucun galerie trovée !</span>
          </div>
        </section>

        <section x-show="pageSection=='discussion'">
          <div class="py-5">
            <h2 class="font-dm-serif font-bold text-2xl my-5">Discussions</h2>
            <div class="w-[90%] mx-auto h-1 bg-green-gs"></div>
          </div>
        </section>

      </div>

      <div x-show="userType=='salon'">

        {{-- Section mon compte --}}
        <section x-show="pageSection=='compte'">

          {{-- Galerie --}}
          <div class="flex items-center justify-between gap-5 py-5">

            <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Galerie</h2>
            <div class="flex-1 h-0.5 bg-green-gs"></div>
            <button class="flex items-center gap-2 text-amber-400">
              Ajouter
              <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
            </button>

          </div>
          <div class="flex items-center gap-10 flex-wrap">
            <span class="w-full text-center text-green-gs font-bold font-dm-serif">Aucun stories trovée !</span>
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
            <p class="text-justify text-sm xl:text-base">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus repudiandae delectus molestias error tenetur dolores corrupti consequatur voluptates sequi, aspernatur voluptate blanditiis. Reprehenderit mollitia repellat porro deleniti dolor voluptates quo. </p>
          </div>

          {{-- A propos de moi --}}
          <div class="flex items-center justify-between gap-5 py-5">

            <h2 class="font-dm-serif font-bold text-2xl text-green-gs">A propos de moi</h2>
            <div class="flex-1 h-0.5 bg-green-gs"></div>
            {{-- <button class="flex items-center gap-2 text-amber-400">
              Modifier
              <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
            </button> --}}

          </div>
          <div class="flex items-center gap-10 flex-wrap">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 w-full">
              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/origine_icon.svg') }}" alt="age icon" srcset="age icon">
                <span>Catégorie : Salon Erotique </span>
              </div>
              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/langue_icon.svg') }}" alt="age icon" srcset="age icon">
                <span>Nombre des filles : 5 à 15 filles</span>
              </div>
              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/yeux_icon.svg') }}" alt="age icon" srcset="age icon">
                <span>Autre contact : Whatsapp </span>
              </div>
              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/cheveux_icon.svg') }}" alt="age icon" srcset="age icon">
                <span>Adresse : Route de la crottaz, corseaux, Suisse </span>
              </div>
              <div class="w-full flex items-center gap-3 font-dm-serif">
                <img src="{{ asset('images/icons/tarif_icon.svg') }}" alt="age icon" srcset="age icon">
                <span>Tarifs à partir de 250.-CHF </span>
              </div>

            </div>
          </div>

          {{-- Service --}}
          <div class="flex items-center justify-between gap-5 py-5">

            <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Nos services</h2>
            <div class="flex-1 h-0.5 bg-green-gs"></div>

          </div>
          <div class="flex flex-col justify-center gap-5 flex-wrap">
            <div class="flex items-center gap-5 font-dm-serif font-bold text-green-gs">
              Catégories
              <button class="flex items-center gap-2 text-amber-400">
                Modifier
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
              </button>
            </div>
            <div class="flex items-center gap-5">
              <span class="px-2 border border-green-gs text-green-gs rounded-lg hover:bg-amber-300">Escort</span>
            </div>

            <div class="flex items-center gap-5 font-dm-serif font-bold text-green-gs">
              Services fournies
              <button class="flex items-center gap-2 text-amber-400">
                Modifier
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
              </button>
            </div>
            <div class="flex items-center gap-5">
              <span class="px-2 border border-green-gs text-green-gs rounded-lg hover:bg-amber-300">Gorge Profonde</span>
              <span class="px-2 border border-green-gs text-green-gs rounded-lg hover:bg-amber-300">Café Pipe</span>
              <span class="px-2 border border-green-gs text-green-gs rounded-lg hover:bg-amber-300">Duo</span>
            </div>

          </div>

          {{-- Escort associé --}}
          <div class="hidden xl:flex items-center justify-between flex-col xl:flex-row gap-5 py-5">

            <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Escorte du salon</h2>
            <div class="hidden xl:block flex-1 h-0.5 bg-green-gs"></div>
            <h2 class="font-dm-serif font-bold text-2xl text-green-gs">invitée du salon</h2>

          </div>
          <div class="mt-10 xl:mt-0 w-full flex items-center flex-col gap-2">
            <div class="w-full flex flex-col xl:flex-row items-center gap-2">
              <h2 class="font-dm-serif font-bold text-2xl text-green-gs xl:hidden">Escorte du salon</h2>
              <span class="w-[40%] text-sm xl:text-base text-center text-green-gs font-bold font-dm-serif">Aucun escort créer pour l'instant</span>
              <span class="hidden xl:block w-[10%] h-0.5 bg-green-gs"></span>
              <h2 class="font-dm-serif font-bold text-2xl text-green-gs xl:hidden">invitée du salon</h2>
              <span class="w-[40%] text-sm xl:text-base text-center text-green-gs font-bold font-dm-serif">Aucun escort associé pour l'instant</span>
            </div>
            <div class="w-full flex items-center justify-between pt-10">
              <button class="p-2 rounded-lg bg-green-gs text-sm xl:text-base text-white cursor-pointer hover:bg-green-800">Créer un escort</button>
              <button class="p-2 rounded-lg bg-green-gs text-sm xl:text-base text-white cursor-pointer hover:bg-green-800">Invité un escort</button>
            </div>
          </div>

          {{-- Galerie privée --}}
          <div class="flex items-center justify-between gap-5 py-5">

            <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Galerie privée</h2>
            <div class="flex-1 h-0.5 bg-green-gs"></div>
            <button class="flex items-center gap-2 text-amber-400">
              Modifier
              <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
            </button>

          </div>
          <div class="flex items-center gap-10 flex-wrap">
            <span class="w-full text-center text-green-gs font-bold font-dm-serif">Attention ! Vous n'avez droit qu'à 5 vidéos</span>
            <span class="w-full text-center text-green-gs font-bold font-dm-serif">Aucun vidéo pour l'instant</span>
          </div>

        </section>

        <section x-show="pageSection=='galerie'">
          <div class="flex items-center justify-between gap-5 py-5">

            <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Galerie</h2>
            <div class="flex-1 h-0.5 bg-green-gs"></div>
            <button class="flex items-center gap-2 text-amber-400">
              Ajouter/Modifier
              <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg>
            </button>

          </div>
          <div class="flex items-center gap-10 flex-wrap">
            <span class="w-full text-center text-green-gs font-bold font-dm-serif">Aucun galerie trovée !</span>
          </div>
        </section>

        <section x-show="pageSection=='discussion'">
          <div class="py-5">
            <h2 class="font-dm-serif font-bold text-2xl my-5">Discussions</h2>
            <div class="w-[90%] mx-auto h-1 bg-green-gs"></div>
          </div>
        </section>

      </div>

    </div>

  </div>
  @stop

  @section('extraScripts')
  <script>
    function multiStepForm() {
      return {
        steps: "{{ Auth::user()->profile_type }}"=='invite' ? ['Informations personnelles', 'Informations complémentaires'] : ['Informations personnelles', 'Informations professionnelles', 'Informations complémentaires'],
        currentStep: 0,
        nextStep() {
          if (this.currentStep < this.steps.length - 1) {
            this.currentStep++;
          }
        },
        prevStep() {
          if (this.currentStep > 0) {
            this.currentStep--;
          }
        },
        saveAndQuit(){
          document.getElementById('addInfoSubmit').click();
        },
        submitForm() {
          alert('Formulaire soumis avec succès !');
        }
      };
    }
  </script>
  @endsection
