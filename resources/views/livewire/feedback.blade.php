<div class="mt-5 flex w-full flex-col gap-10 rounded-lg bg-gray-200 p-4">
    <div class="flex flex-col items-center justify-between gap-2 md:flex-row">
        <span
            class="font-dm-serif text-green-gs text-center text-xl font-bold md:text-start">{{ __('feedback.recommendations_likes_rating') }}</span>
        <span class="hidden items-center md:flex">
            <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z" />
            </svg>
            <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z" />
            </svg>
            <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z" />
            </svg>
            <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z" />
            </svg>
            <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z" />
            </svg>
        </span>
    </div>

    {{-- List des commentaire --}}
    @foreach ($feedbacks as $feedback)
        <div class="flex items-center gap-5 border-b border-gray-400 pb-2">
            <a
                @if ($feedback->userFromId?->profile_type == 'salon') href="{{ route('show_salon', $feedback->userFromId->id) }}"
    @else
    href="{{ route('show_escort', $feedback->userFromId->id) }}" @endif>
                <img class="w-15 h-15 rounded-full object-cover object-center"
                    @if ($avatar = $feedback->userFromId->avatar) src="{{ asset('storage/avatars/' . $avatar) }}"
      @else
      src="{{ asset('images/icon_logo.png') }}" @endif
                    alt="{{ __('feedback.profile_image') }}" />
            </a>
            <div class="flex flex-col justify-center gap-2">
                <div
                    class="text-green-gs flex flex-col justify-center gap-2 font-bold md:flex-row md:items-center md:justify-start">
                    <a
                        @if ($feedback->userFromId->profile_type == 'salon') href="{{ route('show_salon', $feedback->userFromId->id) }}"
          @else
          href="{{ route('show_escort', $feedback->userFromId->id) }}" @endif>
                        {{ $feedback->userFromId->user_name ?? ($feedback->userFromId->name ?? ($feedback->userFromId->nom_salon ?? '')) }}
                    </a>
                    <span class="flex items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" class="text-xl">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="{{ $i <= $feedback->rating ? 'currentColor' : 'none' }}" stroke="currentColor"
                                    class="h-5 w-5 text-yellow-500" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </button>
                        @endfor
                    </span>
                </div>
                <p>{{ $feedback->comment }}</p>
            </div>
        </div>
    @endforeach
    @auth
        <div class="flex flex-col justify-center gap-3">
            <h1>{{ __('feedback.rating_given') }}</h1>

            <!-- Affichage des messages de succès -->
            @if (session()->has('success'))
                <div class="mb-4 rounded bg-green-100 p-2 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Sélection des étoiles -->
            <div class="flex items-center gap-1">
                @for ($i = 1; $i <= 5; $i++)
                    <button type="button" wire:click="$set('rating', {{ $i }})" class="text-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= $rating ? 'currentColor' : 'none' }}"
                            stroke="currentColor" class="h-6 w-6 text-yellow-500" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    </button>
                @endfor
            </div>

            <!-- Champ de commentaire -->
            <div class="mb-4 w-full rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">
                <div class="rounded-t-lg bg-white px-4 py-2 dark:bg-gray-800">
                    <label for="comment" class="sr-only">{{ __('feedback.your_comment') }}</label>
                    <textarea wire:model="comment" id="comment" rows="4"
                        class="w-full border-0 bg-white px-0 text-sm text-gray-900 focus:ring-0 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400"
                        placeholder="{{ __('feedback.write_your_comment') }}" required></textarea>
                </div>

                <!-- Bouton de soumission -->
                <div class="flex items-center justify-end border-t border-gray-200 px-3 py-2 dark:border-gray-600">
                    <button wire:click="submit" type="submit"
                        class="btn-gs-gradient inline-flex items-center rounded-lg px-4 py-2.5 text-center text-xs font-medium focus:ring-0">
                        {{ __('feedback.send_comment') }}
                    </button>
                </div>
            </div>
        </div>
    @endauth
</div>
