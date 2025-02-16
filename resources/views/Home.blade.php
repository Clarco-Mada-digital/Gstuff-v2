@extends('layouts.base')
  @section('content')

      {{-- Hero content --}}
      <div class="relative flex items-center justify-center flex-col gap-8 w-full px-3 py-20 lg:h-[418px] bg-no-repeat" style="background: url('images/Hero image.jpeg') center center /cover;">
        <div class="w-full h-full z-0 absolute inset-0 to-0% right-0% bg-[#05595B]/74"></div>
        <div class="flex items-center justify-center flex-col z-10">
          <h2 class="[text-shadow:_2px_6px_9px_rgb(0_0_0_/_0.8)] lg:text-6xl md:text-5xl text-4xl text-center font-semibold text-white font-cormorant">Rencontres <span class="text-amber-400">élégantes et discrètes</span>  en Suisse</h2>
        </div>
        <div class="flex flex-col lg:flex-row gap-2 text-black">
          @foreach (['Escorte', 'Masseuse', 'Dominatrice', 'Trans'] as $item)
          <a href="#" class="flex items-center justify-center gap-1 z-10">
            <div class="w-64 lg:w-56 flex items-center justify-center gap-1.5 p-2.5 bg-white rounded-md hover:bg-green-800 hover:text-white">
              <img src="icons/{{$item}}_icon.svg" alt="icon trans presentation" srcset="icon trans">
              <span>{{$item}}</span>
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
      <div class="mt-10 container m-auto">

        <div x-data="{ viewEscorte: true }" x-cloak>
          <div class="sm:hidden m-4">
            <label for="tabs" class="sr-only">Select salon or escorte</label>
            <select id="tabs" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option>Top escortes du jour</option>
                <option>Les Salons</option>
            </select>
          </div>
          <ul class="hidden w-[50%] text-sm font-medium text-center text-gray-500 rounded-lg shadow-sm sm:flex sm:m-auto dark:divide-gray-700 dark:text-gray-400">
            <li class="w-full focus-within:z-10">
                <button  @click="viewEscorte = true" :class="viewEscorte ? 'btn-gs-gradient' : ''" class="inline-block w-full p-4 text-xs md:text-sm lg:text-base bg-white border-r font-bold border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50  rounded-s-lg focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-current="page">Top escortes du jour</button>
            </li>
            <li class="w-full focus-within:z-10">
                <button @click="viewEscorte = false" :class="viewEscorte ? '' : 'btn-gs-gradient' " class="inline-block w-full p-4 text-xs md:text-sm lg:text-base bg-white border-r font-bold border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50  rounded-e-lg focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Les salons</button>
            </li>
          </ul>
          <div x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 scale-90"
              x-transition:enter-end="opacity-100 scale-100"
              x-show="viewEscorte"
              class="w-[90%] mx-auto flex flex-col items-center justify-center mt-4">
            <h3 class="font-dm-serif text-green-800 font-bold text-4xl text-center">Nos nouvelles escortes</h3>
            <div class="w-full grid grid-cols-1 md:w-full md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mx-auto mt-5 mb-4 gap-1">
              @foreach ([1,2,3,4] as $item)
              <div class="relative flex flex-col justify-center w-[90%] mx-auto mb-2 p-1 md:w-72 lg:w-80 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="absolute flex items-center justify-center top-0 right-0 w-10 h-10 rounded-full bg-white m-2 text-green-700">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m22 9.24l-7.19-.62L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21L12 17.27L18.18 21l-1.63-7.03zM12 15.4l-3.76 2.27l1-4.28l-3.32-2.88l4.38-.38L12 6.1l1.71 4.04l4.38.38l-3.32 2.88l1 4.28z"/></svg>
                </div>
                <a class="m-auto w-full rounded-lg overflow-hidden" href="#">
                    <img class="w-full object-cover rounded-t-lg" src="images/girl_001.png" alt="" />
                </a>
                <div class="flex flex-col gap-2 mt-4">
                    <a class="flex items-center gap-1" href="#">
                        <h5 class="text-base tracking-tight text-gray-900 dark:text-white">Carrine</h5>
                        <div class="w-2 h-2 rounded-full bg-green-600"></div>
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
          </div>
          <div x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 scale-90"
              x-transition:enter-end="opacity-100 scale-100"
              x-show="!viewEscorte"
              class="w-[90%] mx-auto flex flex-col items-center justify-center mt-4">
            <h3 class="font-dm-serif text-green-800 font-bold text-4xl text-center">Nos salons</h3>
            <div class="w-full grid grid-cols-1 md:w-full md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mx-auto mt-5 mb-4 gap-1">
              @foreach ([1,2,3,4] as $item)
              <div class="relative flex flex-col justify-center w-[90%] mx-auto mb-2 p-1 md:w-72 lg:w-80 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="absolute flex items-center justify-center top-0 right-0 w-10 h-10 rounded-full bg-white m-2 text-green-700">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m22 9.24l-7.19-.62L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21L12 17.27L18.18 21l-1.63-7.03zM12 15.4l-3.76 2.27l1-4.28l-3.32-2.88l4.38-.38L12 6.1l1.71 4.04l4.38.38l-3.32 2.88l1 4.28z"/></svg>
                </div>
                <a class="m-auto w-full rounded-lg overflow-hidden" href="#">
                    <img class="w-full object-cover rounded-t-lg" src="images/girl_001.png" alt="" />
                </a>
                <div class="flex flex-col gap-2 mt-4">
                    <a class="flex items-center gap-1" href="#">
                        <h5 class="text-base tracking-tight text-gray-900 dark:text-white">Salon's dream</h5>
                        <div class="w-2 h-2 rounded-full bg-green-600"></div>
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
          </div>
        </div>

        <div class="w-[90%] mx-auto flex flex-col items-center justify-center mt-4">
          <h3 class="font-dm-serif text-green-800 font-bold text-3xl lg:text-4xl text-center">A la recherche d'un plaisir coquin ?</h3>
          <div class="w-[90%] grid grid-cols-1 md:w-full md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mx-auto mt-5 mb-4 gap-1">
            @foreach ([1,2,3,4] as $item)
            <div class="relative flex flex-col justify-center w-[90%] mx-auto mb-2 p-1 md:w-72 lg:w-80 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
              <div class="absolute flex items-center justify-center top-0 right-0 w-10 h-10 rounded-full bg-white m-2 text-yellow-600 z-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m12 17.27l4.15 2.51c.76.46 1.69-.22 1.49-1.08l-1.1-4.72l3.67-3.18c.67-.58.31-1.68-.57-1.75l-4.83-.41l-1.89-4.46c-.34-.81-1.5-.81-1.84 0L9.19 8.63l-4.83.41c-.88.07-1.24 1.17-.57 1.75l3.67 3.18l-1.1 4.72c-.2.86.73 1.54 1.49 1.08z"/></svg>
              </div>
              <a class="m-auto w-full rounded-lg overflow-hidden" href="#">
                  <img class="w-full object-cover rounded-t-lg" src="images/girl_001.png" alt="" />
              </a>
              <div class="flex flex-col gap-2 mt-4">
                  <a class="flex items-center gap-1" href="#">
                      <h5 class="text-base tracking-tight text-gray-900 dark:text-white">Carrine</h5>
                      <div class="w-2 h-2 rounded-full bg-green-600"></div>
                  </a>
                  <p class="font-normal text-gray-700 dark:text-gray-400">Suisse Allemanique</p>
              </div>
            </div>
            @endforeach
          </div>
          <div class="z-10 mb-6">
            <a href="#" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 text-center dark:focus:ring-blue-800">Tout voir <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/></svg>
            </a>
          </div>
        </div>

      </div>

      <div class="relative flex flex-col items-center justify-center py-10 w-full" style="background: url('images/girl_deco_image.jpg') center center /cover">
        <div class="bg-white/70 absolute top-0 right-0 w-full h-full z-0"></div>
          <h3 class="font-dm-serif text-green-800 text-2xl md:text-3xl lg:text-4xl xl:text-5xl my-4 mx-2 text-center font-bold z-10">Trouver des escortes, masseuses et plus encore sur Gstuff !</h3>
          <div class="flex flex-col w-full px-4 md:flex-row items-center justify-center gap-2 py-6 z-10">
          @foreach ([1, 2, 3] as $item)
          <div class="w-full lg:w-[367px] lg:h-[263px] bg-[#618E8D] p-3 flex flex-col text-white text-2xl lg:text-4xl font-bold items-center justify-center gap-3">
            <span class="text-center font-dm-serif w-[70%]">+ de 500 partenaires</span>
            <span class="text-center text-sm lg:text-base font-normal w-[75%] mx-auto">Profils vérifiés pour des rencontres authentiques</span>
          </div>
          @endforeach
        </div>
      </div>

      <div class="relative py-10 w-full">
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
      </div>

      <div class="bg-white py-10 w-full flex items-center justify-center flex-col gap-10">
        <h3 class="text-2xl md:text-4xl lg:text-5xl font-dm-serif text-green-900 font-bold">Comment devenir escorte sur Gstuff ?</h3>
        <p>Devenez escorte indépendante en 3 étapes !</p>
        <div class="relative grid grid-cols-3 gap-5 text-green-800 text-center text-lg text-wrap italic font-normal mt-20">
          <div class="absolute mx-20 top-[18%] col-span-3 w-[75%] h-1 bg-green-900 z-0"></div>
          @foreach ([1, 2, 3] as $items)
            <img class="w-20 h-20 mx-auto z-10" src="icons/icon_coeur.svg" alt="coeur image" srcset="coeur image">
          @endforeach
          <div class="w-52 font-light">Envoyer 5 selfies a <span class="text-amber-500">escort-gstuff@gstuff.ch</span></div>
          <div class="w-52"> Prenez rendez-vous pour le shooting photo</div>
          <div class="w-52">Publiez votre profil</div>
        </div>
      </div>

      <div class="relative flex flex-col items-start justify-center w-full h-[375px]" style="background: url('images/girl_deco_image_001.jpg') center center /cover">
        <div class="text-white flex flex-col gap-4 container mx-auto px-3">
          <h3 class="font-dm-serif text-2xl lg:text-5xl font-bold w-full lg:w-[40%]">Inscrivez vous dès aujourd'hui sur Gstuff ...</h3>
          <span class="font-dm-serif">La meilleure plateforme érotique en Suisse !</span>
          <div class="z-10 w-45">
            <a href="#" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 text-center dark:focus:ring-blue-800">S'inscrire <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/></svg>
            </a>
          </div>
        </div>

      </div>

      {{-- FAQ --}}
      <div class="flex flex-col items-center justify-center gap-10 container mx-auto py-20">
        <div class="flex flex-col justify-center gap-5 w-[1140px] h-[255px] px-20 text-white" style="background: url('images/girl_deco_contact.jpg') center center /cover">
          <h2 class="text-5xl font-dm-serif font-bold">Nous contacter</h2>
          <p>Besoin d'information ou de conseils ? Contactez-nous dès maintenat !</p>
          <div class="z-10 mt-5">
            <a href="#" type="button" class="w-52 flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg px-4 py-2 text-center dark:focus:ring-blue-800">Nous écrire <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/></svg>
            </a>
          </div>
        </div>
        <h3 class="text-5xl font-dm-serif text-green-900">Questions fréquentes</h3>
        <div id="accordion-collapse text-wrap w-[1140px] max-w-[1140px]" data-accordion="collapse">
          <h2 id="accordion-collapse-heading-1">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
              <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>What is Flowbite?</span>
              <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
              </svg>
            </button>
          </h2>
          <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
            <div class="p-5 border border-b-0 border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
              <p class="mb-2 text-gray-500 dark:text-gray-400">Flowbite is an open-source library of interactive components built on top of Tailwind CSS including buttons, dropdowns, modals, navbars, and more.</p>
              <p class="text-gray-500 dark:text-gray-400">Check out this guide to learn how to <a href="/docs/getting-started/introduction/" class="text-blue-600 dark:text-blue-500 hover:underline">get started</a> and start developing websites even faster with components on top of Tailwind CSS.</p>
            </div>
          </div>
          <h2 id="accordion-collapse-heading-2">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-2" aria-expanded="false" aria-controls="accordion-collapse-body-2">
              <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>Is there a Figma file available?</span>
              <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
              </svg>
            </button>
          </h2>
          <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
            <div class="p-5 border border-b-0 border-gray-200 bg-white dark:border-gray-700">
              <p class="mb-2 text-gray-500 dark:text-gray-400">Flowbite is first conceptualized and designed using the Figma software so everything you see in the library has a design equivalent in our Figma file.</p>
              <p class="text-gray-500 dark:text-gray-400">Check out the <a href="https://flowbite.com/figma/" class="text-blue-600 dark:text-blue-500 hover:underline">Figma design system</a> based on the utility classes from Tailwind CSS and components from Flowbite.</p>
            </div>
          </div>
          <h2 id="accordion-collapse-heading-3">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
              <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>What are the differences between Flowbite and Tailwind UI?</span>
              <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
              </svg>
            </button>
          </h2>
          <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
            <div class="p-5 border border-t-0 border-gray-200 bg-white dark:border-gray-700">
              <p class="mb-2 text-gray-500 dark:text-gray-400">The main difference is that the core components from Flowbite are open source under the MIT license, whereas Tailwind UI is a paid product.</p>
              <p class="mb-2 text-gray-500 dark:text-gray-400">However, we actually recommend using both Flowbite, Flowbite Pro, and even Tailwind UI as there is no technical reason stopping you from using the best of two worlds.</p>
              <p class="mb-2 text-gray-500 dark:text-gray-400">Learn more about these technologies:</p>
              <ul class="ps-5 text-gray-500 list-disc dark:text-gray-400">
                <li><a href="https://flowbite.com/pro/" class="text-blue-600 dark:text-blue-500 hover:underline">Flowbite Pro</a></li>
                <li><a href="https://tailwindui.com/" rel="nofollow" class="text-blue-600 dark:text-blue-500 hover:underline">Tailwind UI</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      {{-- Glossaire --}}
      <div class="container mx-auto my-10" >
        <div class="flex items-center justify-between my-10 px-20">
          <h3 class="font-dm-serif text-4xl text-green-800 font-bold">Articles du glossaire</h3>
          <div class="z-10 w-auto">
            <a href="#" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg px-4 py-2 text-center dark:focus:ring-blue-800">voir plus d'articles <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/></svg>
            </a>
          </div>
        </div>
        <div class="relative w-full">
          <div class="w-full flex items-center flex-nowrap gap-10 px-20 overflow-x-auto scroll-smooth" data-slider-wrapper style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
            @foreach ($glossaire as $item)
              <div class="bg-[#05595B] min-w-[375px] w-[375px] h-[232px] flex flex-col items-stretch gap-5 p-5 text-white rounded-lg py-10" style="scroll-snap-align: center" data-carousel-item >
                <h4 class="font-dm-serif text-2xl">{{ $item['title']['rendered'] }}</h4>
                {!! Str::limit($item['excerpt']['rendered'], 100, '...') !!}
                <svg class="w-10 my-3 text-amber-400"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12.7 17.925q-.35.2-.625-.062T12 17.25L14.425 13H3q-.425 0-.712-.288T2 12t.288-.712T3 11h11.425L12 6.75q-.2-.35.075-.612t.625-.063l7.975 5.075q.475.3.475.85t-.475.85z"/></svg>
              </div>
            @endforeach
          </div>
          <div class="absolute top-[40%] left-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-prev>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z"/></svg>
          </div>
          <div class="absolute top-[40%] right-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-next>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z"/></svg>
          </div>
        </div>

      </div>

    @stop
