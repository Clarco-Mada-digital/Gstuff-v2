<div 
    x-data="{
        showSuccess: false,
        showError: false,
        errorMessage: '',
        successMessage: '',
        extractMessage(event) {
            // Si c'est un objet avec une propriété detail qui contient un tableau
            if (event.detail && Array.isArray(event.detail) && event.detail[0]?.message) {
                return event.detail[0].message;
            }
            // Si c'est un objet avec une propriété detail qui contient un message
            if (event.detail?.message) {
                return event.detail.message;
            }
            // Si c'est directement un tableau avec un message
            if (Array.isArray(event) && event[0]?.message) {
                return event[0].message;
            }
            // Si c'est directement un objet avec un message
            if (event?.message) {
                return event.message;
            }
            // Si c'est une chaîne JSON, on essaie de la parser
            if (typeof event === 'string') {
                try {
                    const parsed = JSON.parse(event);
                    if (parsed.message) return parsed.message;
                    if (Array.isArray(parsed) && parsed[0]?.message) return parsed[0].message;
                } catch (e) {
                    // Ce n'est pas du JSON valide, on continue
                }
            }
            // Sinon, on convertit en chaîne
            return String(event);
        },
        init() {
            // Écoute les événements Livewire
            Livewire.on('showSuccess', (event) => {
                this.successMessage = this.extractMessage(event);
                this.showSuccess = true;
                this.hideAfterDelay('success');
            });
            
            Livewire.on('showError', (event) => {
                this.errorMessage = this.extractMessage(event);
                this.showError = true;
                this.hideAfterDelay('error');
            });
            
            // Gère les messages de session au chargement
            @if(session()->has('success'))
                this.successMessage = '{{ addslashes(session('success')) }}';
                this.showSuccess = true;
                this.hideAfterDelay('success');
            @endif
            
            @error('rating')
                this.errorMessage = '{{ addslashes($message) }}';
                this.showError = true;
                this.hideAfterDelay('error');
            @enderror
            
            @error('comment')
                this.errorMessage = '{{ addslashes($message) }}';
                this.showError = true;
                this.hideAfterDelay('error');
            @enderror
        },
        hideAfterDelay(type) {
            setTimeout(() => {
                if (type === 'success') this.showSuccess = false;
                if (type === 'error') this.showError = false;
            }, 5000);
        }
    }"
    class="mt-5 flex w-full flex-col gap-10 rounded-lg bg-fieldBg p-1 sm:p-4 relative"
>
    <!-- Notifications flottantes -->
    <div 
        x-show="showSuccess"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition-opacity duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-4 right-4 max-w-sm w-full bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-lg z-50 flex items-start"
        role="alert"
    >
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-green-800" x-text="successMessage"></p>
        </div>
        <div class="ml-4 flex-shrink-0 flex">
            <button @click="showSuccess = false" class="inline-flex text-green-400 hover:text-green-500 focus:outline-none">
                <span class="sr-only">Fermer</span>
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    </div>

    <div 
        x-show="showError"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition-opacity duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-4 right-4 max-w-sm w-full bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-lg z-50 flex items-start"
        role="alert"
    >
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-red-800" x-text="errorMessage"></p>
        </div>
        <div class="ml-4 flex-shrink-0 flex">
            <button @click="showError = false" class="inline-flex text-red-400 hover:text-red-500 focus:outline-none">
                <span class="sr-only">Fermer</span>
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    </div>
    <div class="flex flex-col items-center justify-between gap-2 md:flex-row font-roboto-slab bg-fieldBg">
        <span
            class="font-roboto-slab text-green-gs text-center text-xl font-bold md:text-start">{{ __('feedback.recommendations_likes_rating') }}</span>
        <span class="hidden items-center md:flex">
            <svg class="h-5 w-5 text-supaGirlRose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z" />
            </svg>
            <svg class="h-5 w-5 text-supaGirlRose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z" />
            </svg>
            <svg class="h-5 w-5 text-supaGirlRose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z" />
            </svg>
            <svg class="h-5 w-5 text-supaGirlRose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21z" />
            </svg>
            <svg class="h-5 w-5 text-supaGirlRose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
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
                                    fill="{{ $i <= $feedback->rating ? '#FDA5D6' : 'none' }}" stroke="#FDA5D6"
                                    class="h-5 w-5 text-supaGirlRose" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </button>
                        @endfor
                    </span>
                </div>
                <p class="font-roboto-slab text-textColorParagraph text-sm">{{ $feedback->comment }}</p>
            </div>
        </div>
    @endforeach
    @auth
        <div class="flex flex-col justify-center gap-4 p-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h2 class="text-xl font-bold text-green-gs mb-2 px-2 sm:px-0">{{ __('feedback.rating_given') }}</h2>
            <p class="text-sm text-textColorParagraph mb-4 px-2 sm:px-0">
                {{ __('feedback.rating_help') }}
            </p>

            <!-- Les messages sont maintenant affichés dans des notifications flottantes en bas à droite -->

            <!-- Sélection des étoiles avec effet de survol -->
            <div class="mb-1">
                <div class="flex items-center gap-1 mb-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <button 
                            type="button" 
                            wire:click="$set('rating', {{ $i }})" 
                            class="p-1 transition-transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-supaGirlRose focus:ring-opacity-50 rounded-full"
                            aria-label="{{ __('feedback.rate_star', ['rating' => $i]) }}"
                        >
                            <svg 
                                xmlns="http://www.w3.org/2000/svg" 
                                fill="{{ $i <= $rating ? 'currentColor' : 'none' }}"
                                stroke="{{ $i <= $rating ? 'currentColor' : '#FDA5D6' }}" 
                                class="h-8 w-8 {{ $i <= $rating ? 'text-supaGirlRose' : 'text-gray-300' }}" 
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ $i <= $rating ? '0' : '2' }}" 
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </button>
                    @endfor
                </div>
               
            </div>

            <!-- Champ de commentaire avec sélecteur d'émojis -->
            <div class="w-full mb-4 transition-all duration-200 ease-in-out hover:shadow-lg p-2 rounded-sm "
                 x-data="{
                    showEmojiPicker: false,
                    activeCategory: 'smileys_emotion',
                    searchQuery: '',
                    searchResults: [],
                    allEmojis: [
                        @if(isset($emojiCategories) && count($emojiCategories) > 0)
                            @foreach($emojiCategories as $category)
                                @foreach($category['emojis'] as $emoji)
                                    {
                                        char: '{{ $emoji['char'] }}',
                                        name: '{{ $emoji['name'] }}',
                                        slug: '{{ $category['slug'] }}',
                                        category: '{{ $category['name'] }}'
                                    },
                                @endforeach
                            @endforeach
                        @endif
                    ],
                    init() {
                        this.$watch('showEmojiPicker', value => {
                            if (value) {
                                this.searchQuery = '';
                                this.searchResults = [];
                            }
                        });
                    },
                    search() {
                        if (!this.searchQuery.trim()) {
                            this.searchResults = [];
                            return;
                        }
                        
                        const query = this.searchQuery.toLowerCase().trim();
                        this.searchResults = this.allEmojis.filter(emoji => 
                            emoji.name.toLowerCase().includes(query)
                        );
                    },
                    insertEmoji(emoji) {
                        const textarea = this.$refs.commentTextarea;
                        const start = textarea.selectionStart;
                        const end = textarea.selectionEnd;
                        const currentComment = this.$wire.get('comment') || '';
                        const before = currentComment.substring(0, start);
                        const after = currentComment.substring(end, currentComment.length);
                        const newComment = before + emoji + after;
                        
                        // Mise à jour de la valeur via Livewire
                        this.$wire.set('comment', newComment, true);
                        
                        // Mise à jour de la position du curseur
                        this.$nextTick(() => {
                            const newPos = start + emoji.length;
                            textarea.focus();
                            textarea.setSelectionRange(newPos, newPos);
                        });
                        
                        this.showEmojiPicker = false;
                    },
                    filteredEmojis() {
                        if (this.searchQuery) {
                            return this.searchResults;
                        }
                        return this.allEmojis.filter(emoji => 
                            emoji.slug === this.activeCategory
                        );
                    }
                }">
                <div class="relative">
                    <label for="comment" class="block text-sm font-medium text-green-gs/80 mb-1 font-roboto-slab">
                        {{ __('feedback.your_comment') }}
                    </label>
                    <div class="relative">
                        <textarea 
                            wire:model.debounce.500ms="comment" 
                            x-ref="commentTextarea"
                            id="comment" 
                            rows="4"
                            class="w-full px-4 py-3 pr-10 font-roboto-slab text-textColorParagraph bg-white border border-supaGirlRose rounded-lg focus:ring-2 focus:ring-supaGirlRose focus:border-supaGirlRose transition duration-200"
                            placeholder="{{ __('feedback.write_your_comment_placeholder') }}"
                            aria-describedby="comment-help"
                        ></textarea>
                        
                        <!-- Bouton du sélecteur d'émojis -->
                        <button 
                            type="button" 
                            @click="showEmojiPicker = !showEmojiPicker"
                            class="absolute right-2 bottom-2 text-supaGirlRose hover:text-green-gs focus:outline-none"
                            :class="{ 'text-green-gs': showEmojiPicker }"
                            :title="__('Select emoji')"
                        >
                            <i class="far fa-smile text-lg"></i>
                        </button>

                        <!-- Sélecteur d'émojis -->
                        <div 
                            x-show="showEmojiPicker" 
                            @click.away="showEmojiPicker = false"
                            class="absolute bottom-full right-0 z-10 mb-2 w-80 rounded-lg border border-supaGirlRose bg-white shadow-lg"
                            style="display: none;"
                            x-cloak
                        >
                            <!-- Barre de recherche -->
                            <div class="border-b border-supaGirlRosePastel p-2">
                                <input 
                                    type="text" 
                                    x-model="searchQuery" 
                                    @input="search()"
                                    placeholder="{{ __('Search emojis...') }}"
                                    class="w-full rounded-md border border-supaGirlRosePastel px-3 py-1.5 text-sm focus:border-green-gs focus:outline-none focus:ring-1 focus:ring-green-gs"
                                >
                            </div>

                            <!-- Catégories -->
                            <div class="flex overflow-x-auto border-b border-gray-200 bg-fieldBg px-2" x-show="!searchQuery">
                                @if(isset($emojiCategories) && count($emojiCategories) > 0)
                                    @foreach($emojiCategories as $category)
                                        <button 
                                            type="button"
                                            @click="activeCategory = '{{ $category['slug'] }}'"
                                            :class="{ 'border-b-2 border-green-gs text-green-gs': activeCategory === '{{ $category['slug'] }}', 'text-gray-600 hover:text-gray-800': activeCategory !== '{{ $category['slug'] }}' }"
                                            class="flex-shrink-0 whitespace-nowrap px-4 py-2 text-sm font-medium transition-colors"
                                            :title="'{{ $category['name'] }}'"
                                        >
                                            {{ $category['emojis'][0]['char'] ?? '' }}
                                        </button>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Grille d'émojis -->
                            <div class="h-64 overflow-y-auto p-2">
                                <template x-if="searchQuery">
                                    <div class="search-results grid grid-cols-8 gap-1">
                                        <template x-for="emoji in searchResults" :key="emoji.char">
                                            <button 
                                                type="button"
                                                @click="insertEmoji(emoji.char)"
                                                class="flex h-8 w-8 items-center justify-center rounded-md text-xl hover:bg-gray-100"
                                                :title="emoji.name"
                                            >
                                                <span x-text="emoji.char"></span>
                                            </button>
                                        </template>
                                        <div x-show="searchResults.length === 0" class="col-span-8 p-4 text-center text-gray-500">
                                            {{ __('No emojis found for') }} "<span x-text="searchQuery"></span>"
                                        </div>
                                    </div>
                                </template>

                                <template x-if="!searchQuery">
                                    <div class="emoji-category">
                                        @if(isset($emojiCategories) && count($emojiCategories) > 0)
                                            @foreach($emojiCategories as $category)
                                                <div x-show="activeCategory === '{{ $category['slug'] }}'" class="space-y-2">
                                                    <h3 class="text-xs font-semibold text-gray-500">{{ $category['name'] }}</h3>
                                                    <div class="grid grid-cols-8 gap-1">
                                                        @foreach($category['emojis'] as $emoji)
                                                            <button 
                                                                type="button"
                                                                @click="insertEmoji('{{ $emoji['char'] }}')"
                                                                class="flex h-8 w-8 items-center justify-center rounded-md text-xl hover:bg-gray-100"
                                                                title="{{ $emoji['name'] }}"
                                                            >
                                                                {{ $emoji['char'] }}
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    
                    <div id="comment-help" class="mt-1 text-xs text-textColorParagraph hidden sm:block font-roboto-slab">
                        {{ __('feedback.comment_help') }}
                    </div>
                    <div class="absolute bottom-2 right-2 text-xs text-textColorParagraph hidden sm:block font-roboto-slab">
                        <span x-text="$wire.comment ? $wire.comment.length : 0"></span>/500
                    </div>
                </div>
            </div>

            <!-- Bouton de soumission -->
            <div class="flex justify-center sm:justify-end">
                @php
                    $commentLength = strlen($comment ?? '');
                    $isDisabled = !$rating || $commentLength > 500;
                @endphp
                <button 
                    wire:click="submit" 
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-70 cursor-not-allowed"
                    type="button"
                    class=" font-roboto-slab inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-green-gs to-green-gs hover:from-green-gs hover:to-green-gs rounded-lg focus:ring-4 focus:ring-green-gs focus:border-green-gs transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:from-green-gs disabled:to-green-gs"
                    @if($isDisabled) disabled @endif
                >
                    <span wire:loading.remove wire:target="submit">
                        {{ __('feedback.send_comment') }}
                    </span>
                    <span wire:loading wire:target="submit" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#FDA5D6" stroke-width="4"></circle>
                            <path class="opacity-75" fill="#FDA5D6" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ __('feedback.sending') }}...
                    </span>
                </button>
            </div>

            <!-- Les erreurs de validation sont maintenant affichées dans des notifications flottantes en bas à droite -->
        </div>
    @endauth
</div>
