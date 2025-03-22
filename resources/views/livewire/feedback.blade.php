<div class="rounded-lg bg-gray-200 w-full flex flex-col p-4 mt-5 gap-10">
  <div class="flex flex-col md:flex-row items-center gap-2 justify-between">
    <span class="font-dm-serif text-green-gs font-bold text-xl text-center md:text-start">Recommandations & Likes + Note attribuée</span>
    <span class="items-center hidden md:flex">
      <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z"/></svg>
      <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z"/></svg>
      <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z"/></svg>
      <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z"/></svg>
      <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z"/></svg>
    </span>
  </div>
  {{-- List des commentaire --}}
  @foreach ($feedbacks as $feedback)
  <div class="flex items-center gap-5 pb-2 border-b border-gray-400">
    <a
    @if ($feedback->userFromId->profile_type == 'salon')
    href="{{route('show_salon', $feedback->userFromId->id)}}"
    @else
    href="{{route('show_escort', $feedback->userFromId->id)}}"
    @endif >
    <img class="w-15 h-15 rounded-full object-center object-cover"
      @if($avatar = $feedback->userFromId->avatar)
      src="{{ asset('storage/avatars/'.$avatar) }}"
      @else
      src="{{ asset('images/icon_logo.png') }}"
      @endif
      alt="image profile" />
    </a>
    <div class="flex flex-col justify-center gap-2">
      <div class="flex flex-col  md:flex-row justify-center md:justify-start md:items-center gap-2 text-green-gs font-bold">
        <a  @if ($feedback->userFromId->profile_type == 'salon')
          href="{{route('show_salon', $feedback->userFromId->id)}}"
          @else
          href="{{route('show_escort', $feedback->userFromId->id)}}"
          @endif >
          {{$feedback->userFromId->user_name ?? $feedback->userFromId->name ?? $feedback->userFromId->nom_salon ?? ''}}
        </a>
        <span class="flex items-center">
          @for ($i = 1; $i <= 5; $i++)
        <button type="button" class="text-xl">
            <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= $feedback->rating ? 'currentColor' : 'none' }}" stroke="currentColor" class="w-5 h-5 text-yellow-500" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
            </svg>
        </button>
        @endfor
        </span>
      </div>
      <p>{{$feedback->comment}}</p>
    </div>
  </div>
  @endforeach
  @auth
    <div class="flex flex-col gap-3 justify-center">
      <h1>Note attribuée</h1>

      <!-- Affichage des messages de succès -->
      @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
          {{ session('success') }}
        </div>
      @endif

      <!-- Sélection des étoiles -->
      <div class="flex items-center gap-1">
        @for ($i = 1; $i <= 5; $i++)
        <button type="button" wire:click="$set('rating', {{ $i }})" class="text-xl">
            <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= $rating ? 'currentColor' : 'none' }}" stroke="currentColor" class="w-6 h-6 text-yellow-500" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
            </svg>
        </button>
        @endfor
      </div>

        <!-- Champ de commentaire -->
      <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
          <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
              <label for="comment" class="sr-only">Your comment</label>
              <textarea wire:model="comment" id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Ecrire votre commentaire..." required ></textarea>
          </div>

          <!-- Bouton de soumission -->
          <div class="flex items-center justify-end px-3 py-2 border-t dark:border-gray-600 border-gray-200">
              <button wire:click="submit" type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center btn-gs-gradient rounded-lg focus:ring-0 ">
                  Envoyer le commentaire
              </button>
          </div>
      </div>
    </div>
  @endauth
</div>
