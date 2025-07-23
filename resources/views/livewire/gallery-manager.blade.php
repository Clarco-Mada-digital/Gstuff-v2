<div class="w-full my-10" x-data="gallery()" x-init="initGallery()" x-cloak @keydown.left="if(fullscreen) navigateMedia(-1)"
    @keydown.right="if(fullscreen) navigateMedia(1)">
    <!-- Header -->

    @php
        $isConnected = auth()->check() && $user->id == auth()->user()->id;
    @endphp

    <div >
    <!-- Si le gallery est public -->
    @if ($isPublic)
        @if ($isConnected)
            <div class="text-green-gs mb-6 flex items-center justify-between gap-3">
                <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('gallery_manage.gallery_title') }} @if ($isPublic == false)
                        {{ __('gallery_manage.private') }}
                    @endif
                </h2>
                <div class="bg-green-gs h-0.5 flex-1"></div>
                <div class="flex space-x-3">
                    <!-- Boutons de vue -->
                    <button @click="viewMode = 'grid'"
                        :class="{ 'text-green-gs bg-supaGirlRose': viewMode === 'grid', 'text-green-gs ': viewMode !== 'grid' }"
                        class="rounded-lg p-2 transition-colors hover:bg-gray-100">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button @click="viewMode = 'list'"
                        :class="{ 'text-green-gs bg-supaGirlRose': viewMode === 'list', 'text-green-gs ': viewMode !== 'list' }"
                        class="rounded-lg p-2 transition-colors hover:bg-gray-100">
                        <i class="fas fa-list"></i>
                    </button>

                    <!-- Bouton ajout (seulement pour le propriétaire) -->
                    @if (auth()->id() === $user->id && $isPublic)
                       
                        <x-modal-gallery />


                    @endif
                </div>
            </div>

            
            @if (!$isPublic && $user->id == auth()->user()->id)
                <span
                    class="text-green-gs font-roboto-slab w-full text-center font-bold">{{ __('gallery_manage.video_limit_warning') }}</span>
            @endif

            <!-- Gallery Content -->
            <template x-if="viewMode === 'grid'">
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                    @foreach ($galleries as $media)
                        <div
                            class="group relative aspect-square overflow-hidden rounded-lg shadow-md transition-shadow duration-300 hover:shadow-lg">
                            @if ($media->type === 'image')
                                <img src="{{ $media->thumbnail_url ?? $media->url }}" alt="{{ $media->title }}"
                                    class="h-full w-full cursor-pointer object-cover"
                                    @click="currentMedia = { 
                                type: 'image', 
                                url: '{{ $media->url }}', 
                                title: '{{ $media->title }}',
                                description: '{{ $media->description }}'
                            }; fullscreen = true">
                            @else
                                <div class="relative flex h-full w-full cursor-pointer items-center justify-center bg-gray-800"
                                    @click="currentMedia = { 
                                type: 'video', 
                                url: '{{ $media->url }}', 
                                title: '{{ $media->title }}',
                                description: '{{ $media->description }}'
                            }; fullscreen = true">
                                    <i class="fas fa-play text-4xl text-white"></i>
                                    <img src="{{ $media->thumbnail_url ?? asset('images/icon_logo.png') }}"
                                        alt="{{ $media->title }}"
                                        class="absolute inset-0 h-full w-full object-cover opacity-70">
                                </div>
                            @endif

                            <div
                                class="pointer-events-none absolute inset-0 flex items-end bg-gradient-to-t from-black/60 to-transparent p-3 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                <div class="text-white">
                                    <h3 class="truncate font-medium">{{ $media->title }}</h3>
                                    <p class="truncate text-xs text-gray-300">{{ $media->description }}</p>
                                </div>
                            </div>

                            <!-- Actions (owner only) -->
                            @if (auth()->id() === $user->id)
                                <div
                                    class="absolute right-2 top-2 flex space-x-1 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                    <button @click.stop="$wire.openModal({{ $media->id }})"
                                        class="rounded-full bg-white/80 p-1 hover:bg-white">
                                        <i class="fas fa-edit text-sm text-gray-800"></i>
                                    </button>
                                    <button
                                        @click.stop="mediaToDelete = {{ $media->id }}; deleteModalTitle = '{{ __('gallery_manage.delete') }} {{ addslashes($media->title) }}'; showDeleteModal = true"
                                        class="rounded-full bg-white/80 p-1 hover:bg-white">
                                        <i class="fas fa-trash text-sm text-red-600"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    @if ($galleries->isEmpty())
                        <div class="col-span-full py-12 text-center text-gray-500 font-roboto-slab">
                            <i class="fas fa-images mb-3 text-4xl text-supaGirlRose"></i>
                            <p>{{ __('gallery_manage.no_media') }}</p>
                        </div>
                    @endif
                </div>
            </template>

            <!-- Mode Liste -->
            <template x-if="viewMode === 'list'">
                <div class="flex flex-wrap items-center gap-2">
                    @foreach ($galleries as $media)
                        <div
                            class="w-1/3 group flex items-center rounded-lg bg-white p-3 shadow transition-shadow duration-300 hover:shadow-md">
                            <div class="h-16 w-16 flex-shrink-0 cursor-pointer overflow-hidden rounded-md"
                                @click="currentMedia = { 
                                type: '{{ $media->type }}', 
                                url: '{{ $media->url }}', 
                                title: '{{ $media->title }}',
                                description: '{{ $media->description }}'
                            }; fullscreen = true">
                                @if ($media->type === 'image')
                                    <img src="{{ $media->thumbnail_url ?? $media->url }}" alt="{{ $media->title }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gray-800">
                                        <i class="fas fa-play text-lg text-white"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="ml-4 min-w-0 flex-1">
                                <h3 class="truncate text-sm font-medium text-gray-900">{{ $media->title }}</h3>
                                <p class="truncate text-xs text-gray-500">
                                    {{ $media->description ?: ''}}</p>
                                <div class="mt-1 flex items-center text-xs text-gray-400">
                                    <span class="flex items-center">
                                        <i class="fas fa-{{ $media->type === 'image' ? 'image' : 'video' }} mr-1"></i>
                                        {{ $media->type === 'image' ? __('gallery_manage.image') : __('gallery_manage.video') }}
                                    </span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $media->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            <!-- Actions (owner only) -->
                            @if (auth()->id() === $user->id)
                                <div class="flex space-x-2 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                    <button @click.stop="$wire.openModal({{ $media->id }})"
                                        class="p-2 text-gray-500 hover:text-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        @click.stop="mediaToDelete = {{ $media->id }}; deleteModalTitle = '{{ __('gallery_manage.delete') }} {{ addslashes($media->title) }}'; showDeleteModal = true"
                                        class="p-2 text-gray-500 hover:text-red-600">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    @if ($galleries->isEmpty())
                        <div class="py-12 w-full text-center text-gray-500 font-roboto-slab">
                            <i class="fas fa-images mb-3 text-4xl text-supaGirlRose"></i>
                            <p>{{ __('gallery_manage.no_media') }}</p>
                                
                        </div>
                    @endif
                </div>
            </template>



        @elseif ( $galleries->isNotEmpty())
            <div class="text-green-gs mb-6 flex items-center justify-between gap-3">
                <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('gallery_manage.gallery_title') }} @if ($isPublic == false)
                        {{ __('gallery_manage.private') }}
                    @endif
                </h2>
                <div class="bg-green-gs h-0.5 flex-1"></div>
                <div class="flex space-x-3">
                    <!-- Boutons de vue -->
                    <button @click="viewMode = 'grid'"
                        :class="{ 'text-green-gs bg-supaGirlRose': viewMode === 'grid', 'text-green-gs bg-green-gs/50': viewMode !== 'grid' }"
                        class="rounded-lg p-2 transition-colors hover:bg-gray-100">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button @click="viewMode = 'list'"
                        :class="{ 'text-green-gs bg-supaGirlRose': viewMode === 'list', 'text-green-gs bg-green-gs/50': viewMode !== 'list' }"
                        class="rounded-lg p-2 transition-colors hover:bg-gray-100">
                        <i class="fas fa-list"></i>
                    </button>

                    <!-- Bouton ajout (seulement pour le propriétaire) -->
                    @if (auth()->id() === $user->id && $isPublic)
                        <x-modal-gallery /> 
                    @endif
                </div>
            </div>

             
            @if (!$isPublic && $user->id == auth()->user()->id)
                <span
                    class="text-green-gs font-roboto-slab w-full text-center font-bold">{{ __('gallery_manage.video_limit_warning') }}</span>
            @endif

            <!-- Gallery Content -->
            <template x-if="viewMode === 'grid'">
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                    @foreach ($galleries as $media)
                        <div
                            class="group relative aspect-square overflow-hidden rounded-lg shadow-md transition-shadow duration-300 hover:shadow-lg">
                            @if ($media->type === 'image')
                                <img src="{{ $media->thumbnail_url ?? $media->url }}" alt="{{ $media->title }}"
                                    class="h-full w-full cursor-pointer object-cover"
                                    @click="currentMedia = { 
                                type: 'image', 
                                url: '{{ $media->url }}', 
                                title: '{{ $media->title }}',
                                description: '{{ $media->description }}'
                            }; fullscreen = true">
                            @else
                                <div class="relative flex h-full w-full cursor-pointer items-center justify-center bg-gray-800"
                                    @click="currentMedia = { 
                                type: 'video', 
                                url: '{{ $media->url }}', 
                                title: '{{ $media->title }}',
                                description: '{{ $media->description }}'
                            }; fullscreen = true">
                                    <i class="fas fa-play text-4xl text-white"></i>
                                    <img src="{{ $media->thumbnail_url ?? asset('images/icon_logo.png') }}"
                                        alt="{{ $media->title }}"
                                        class="absolute inset-0 h-full w-full object-cover opacity-70">
                                </div>
                            @endif

                            <div
                                class="pointer-events-none absolute inset-0 flex items-end bg-gradient-to-t from-black/60 to-transparent p-3 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                <div class="text-white">
                                    <h3 class="truncate font-medium">{{ $media->title }}</h3>
                                    <p class="truncate text-xs text-gray-300">{{ $media->description }}</p>
                                </div>
                            </div>

                            <!-- Actions (owner only) -->
                            @if (auth()->id() === $user->id)
                                <div
                                    class="absolute right-2 top-2 flex space-x-1 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                    <button @click.stop="$wire.openModal({{ $media->id }})"
                                        class="rounded-full bg-white/80 p-1 hover:bg-white">
                                        <i class="fas fa-edit text-sm text-gray-800"></i>
                                    </button>
                                    <button
                                        @click.stop="mediaToDelete = {{ $media->id }}; deleteModalTitle = '{{ __('gallery_manage.delete') }} {{ addslashes($media->title) }}'; showDeleteModal = true"
                                        class="rounded-full bg-white/80 p-1 hover:bg-white">
                                        <i class="fas fa-trash text-sm text-red-600"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </template>

            <!-- Mode Liste -->
            <template x-if="viewMode === 'list'">
                <div class="flex flex-wrap items-center gap-2">
                    @foreach ($galleries as $media)
                        <div
                            class="w-1/3 group flex items-center rounded-lg bg-white p-3 shadow transition-shadow duration-300 hover:shadow-md">
                            <div class="h-16 w-16 flex-shrink-0 cursor-pointer overflow-hidden rounded-md"
                                @click="currentMedia = { 
                                type: '{{ $media->type }}', 
                                url: '{{ $media->url }}', 
                                title: '{{ $media->title }}',
                                description: '{{ $media->description }}'
                            }; fullscreen = true">
                                @if ($media->type === 'image')
                                    <img src="{{ $media->thumbnail_url ?? $media->url }}" alt="{{ $media->title }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gray-800">
                                        <i class="fas fa-play text-lg text-white"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="ml-4 min-w-0 flex-1">
                                <h3 class="truncate text-sm font-medium text-gray-900">{{ $media->title }}</h3>
                                <p class="truncate text-xs text-gray-500">
                                    {{ $media->description ?: ' ' }}</p>
                                <div class="mt-1 flex items-center text-xs text-gray-400">
                                    <span class="flex items-center">
                                        <i class="fas fa-{{ $media->type === 'image' ? 'image' : 'video' }} mr-1"></i>
                                        {{ $media->type === 'image' ? __('gallery_manage.image') : __('gallery_manage.video') }}
                                    </span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $media->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            <!-- Actions (owner only) -->
                            @if (auth()->id() === $user->id)
                                <div class="flex space-x-2 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                    <button @click.stop="$wire.openModal({{ $media->id }})"
                                        class="p-2 text-gray-500 hover:text-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        @click.stop="mediaToDelete = {{ $media->id }}; deleteModalTitle = '{{ __('gallery_manage.delete') }} {{ addslashes($media->title) }}'; showDeleteModal = true"
                                        class="p-2 text-gray-500 hover:text-red-600">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </template>
        @endif

    <!-- Si le gallery est privé -->
    @else
    <!-- Si le gallery est privé et que l'utilisateur est connecté -->
        @if ($isConnected)
            <div class="text-green-gs mb-6 flex items-center justify-between gap-3">
                <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('gallery_manage.gallery_title') }} @if ($isPublic == false)
                        {{ __('gallery_manage.private') }}
                    @endif
                </h2>
                <div class="bg-green-gs h-0.5 flex-1"></div>
                <div class="flex space-x-3">
                    <!-- Boutons de vue -->
                    <button @click="viewMode = 'grid'"
                        :class="{ 'text-green-gs bg-supaGirlRose': viewMode === 'grid', 'text-green-gs bg-green-gs/50': viewMode !== 'grid' }"
                        class="rounded-lg p-2 transition-colors hover:bg-gray-100">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button @click="viewMode = 'list'"
                        :class="{ 'text-green-gs bg-supaGirlRose': viewMode === 'list', 'text-green-gs bg-green-gs/50': viewMode !== 'list' }"
                        class="rounded-lg p-2 transition-colors hover:bg-gray-100">
                        <i class="fas fa-list"></i>
                    </button>

                    <!-- Bouton ajout (seulement pour le propriétaire) -->
                    @if (auth()->id() === $user->id && $isPublic)
                        <x-modal-gallery />
                    @endif
                </div>
            </div>

            
            @if (!$isPublic && $user->id == auth()->user()->id)
                <span
                    class="text-green-gs font-roboto-slab w-full text-center font-bold">{{ __('gallery_manage.video_limit_warning') }}</span>
            @endif

            <!-- Gallery Content -->
            <template x-if="viewMode === 'grid'">
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                    @foreach ($galleries as $media)
                        <div
                            class="group relative aspect-square overflow-hidden rounded-lg shadow-md transition-shadow duration-300 hover:shadow-lg">
                            @if ($media->type === 'image')
                                <img src="{{ $media->thumbnail_url ?? $media->url }}" alt="{{ $media->title }}"
                                    class="h-full w-full cursor-pointer object-cover"
                                    @click="currentMedia = { 
                                type: 'image', 
                                url: '{{ $media->url }}', 
                                title: '{{ $media->title }}',
                                description: '{{ $media->description }}'
                            }; fullscreen = true">
                            @else
                                <div class="relative flex h-full w-full cursor-pointer items-center justify-center bg-gray-800"
                                    @click="currentMedia = { 
                                type: 'video', 
                                url: '{{ $media->url }}', 
                                title: '{{ $media->title }}',
                                description: '{{ $media->description }}'
                            }; fullscreen = true">
                                    <i class="fas fa-play text-4xl text-white"></i>
                                    <img src="{{ $media->thumbnail_url ?? asset('images/icon_logo.png') }}"
                                        alt="{{ $media->title }}"
                                        class="absolute inset-0 h-full w-full object-cover opacity-70">
                                </div>
                            @endif

                            <div
                                class="pointer-events-none absolute inset-0 flex items-end bg-gradient-to-t from-black/60 to-transparent p-3 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                <div class="text-white">
                                    <h3 class="truncate font-medium">{{ $media->title }}</h3>
                                    <p class="truncate text-xs text-gray-300">{{ $media->description }}</p>
                                </div>
                            </div>

                            <!-- Actions (owner only) -->
                            @if (auth()->id() === $user->id)
                                <div
                                    class="absolute right-2 top-2 flex space-x-1 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                    <button @click.stop="$wire.openModal({{ $media->id }})"
                                        class="rounded-full bg-white/80 p-1 hover:bg-white">
                                        <i class="fas fa-edit text-sm text-gray-800"></i>
                                    </button>
                                    <button
                                        @click.stop="mediaToDelete = {{ $media->id }}; deleteModalTitle = '{{ __('gallery_manage.delete') }} {{ addslashes($media->title) }}'; showDeleteModal = true"
                                        class="rounded-full bg-white/80 p-1 hover:bg-white">
                                        <i class="fas fa-trash text-sm text-red-600"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    @if ($galleries->isEmpty())
                        <div class="col-span-full py-12 text-center text-gray-500 font-roboto-slab">
                            <i class="fas fa-images mb-3 text-4xl text-supaGirlRose"></i>
                            <p>{{ __('gallery_manage.no_media') }}</p>
                            
                        </div>
                    @endif
                </div>
            </template>

            <!-- Mode Liste -->
            <template x-if="viewMode === 'list'">
                <div class="flex flex-wrap items-center gap-2">
                    @foreach ($galleries as $media)
                        <div
                            class="w-1/3 group flex items-center rounded-lg bg-white p-3 shadow transition-shadow duration-300 hover:shadow-md">
                            <div class="h-16 w-16 flex-shrink-0 cursor-pointer overflow-hidden rounded-md"
                                @click="currentMedia = { 
                                type: '{{ $media->type }}', 
                                url: '{{ $media->url }}', 
                                title: '{{ $media->title }}',
                                description: '{{ $media->description }}'
                            }; fullscreen = true">
                                @if ($media->type === 'image')
                                    <img src="{{ $media->thumbnail_url ?? $media->url }}" alt="{{ $media->title }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gray-800">
                                        <i class="fas fa-play text-lg text-white"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="ml-4 min-w-0 flex-1">
                                <h3 class="truncate text-sm font-medium text-gray-900">{{ $media->title }}</h3>
                                <p class="truncate text-xs text-gray-500">
                                    {{ $media->description ?: ' ' }}</p>
                                <div class="mt-1 flex items-center text-xs text-gray-400">
                                    <span class="flex items-center">
                                        <i class="fas fa-{{ $media->type === 'image' ? 'image' : 'video' }} mr-1"></i>
                                        {{ $media->type === 'image' ? __('gallery_manage.image') : __('gallery_manage.video') }}
                                    </span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $media->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            <!-- Actions (owner only) -->
                            @if (auth()->id() === $user->id)
                                <div class="flex space-x-2 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                    <button @click.stop="$wire.openModal({{ $media->id }})"
                                        class="p-2 text-gray-500 hover:text-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        @click.stop="mediaToDelete = {{ $media->id }}; deleteModalTitle = '{{ __('gallery_manage.delete') }} {{ addslashes($media->title) }}'; showDeleteModal = true"
                                        class="p-2 text-gray-500 hover:text-red-600">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    @if ($galleries->isEmpty())
                        <div class="py-12 w-full text-center text-gray-500 font-roboto-slab">
                            <i class="fas fa-images mb-3 text-4xl text-supaGirlRose"></i>
                            <p>{{ __('gallery_manage.no_media') }}</p>
                            
                        </div>
                    @endif
                </div>
            </template>
        
        
        
        @else
        <!-- Si le gallery est privé et que l'utilisateur n'est pas connecté et que le gallery n'est pas vide -->
            @if($galleries->isNotEmpty())
                <div class="text-green-gs mb-6 flex items-center justify-between gap-3">
                    <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('gallery_manage.gallery_title') }} @if ($isPublic == false)
                            {{ __('gallery_manage.private') }}
                        @endif
                    </h2>
                    <div class="bg-green-gs h-0.5 flex-1"></div>
                    <div class="flex space-x-3">
                        <!-- Boutons de vue -->
                        <button @click="viewMode = 'grid'"
                            :class="{ 'text-green-gs bg-supaGirlRose': viewMode === 'grid', 'text-green-gs bg-green-gs/50': viewMode !== 'grid' }"
                            class="rounded-lg p-2 transition-colors hover:bg-gray-100">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button @click="viewMode = 'list'"
                            :class="{ 'text-green-gs bg-supaGirlRose': viewMode === 'list', 'text-green-gs bg-green-gs/50': viewMode !== 'list' }"
                            class="rounded-lg p-2 transition-colors hover:bg-gray-100">
                            <i class="fas fa-list"></i>
                        </button>

                        <!-- Bouton ajout (seulement pour le propriétaire) -->
                        @if (auth()->id() === $user->id && $isPublic)
                            <!-- <button @click="$wire.openModal()" class="flex items-center gap-2 text-supaGirlRose hover:text-green-gs hover:bg-supaGirlRose px-5 py-2 bg-fieldBg rounded-md cursor-pointer">
                                <i class="fas fa-plus mr-2"></i> {{ __('gallery_manage.add') }}
                            </button> -->
                            <x-modal-gallery />
                        @endif
                    </div>
                </div>

                
                @if (!$isPublic && $user->id == auth()->user()->id)
                    <span
                        class="text-green-gs font-roboto-slab w-full text-center font-bold">{{ __('gallery_manage.video_limit_warning') }}</span>
                @endif

                <!-- Gallery Content -->
                <template x-if="viewMode === 'grid'">
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                        @foreach ($galleries as $media)
                            <div
                                class="group relative aspect-square overflow-hidden rounded-lg shadow-md transition-shadow duration-300 hover:shadow-lg">
                                @if ($media->type === 'image')
                                    <img src="{{ $media->thumbnail_url ?? $media->url }}" alt="{{ $media->title }}"
                                        class="h-full w-full cursor-pointer object-cover"
                                        @click="currentMedia = { 
                                    type: 'image', 
                                    url: '{{ $media->url }}', 
                                    title: '{{ $media->title }}',
                                    description: '{{ $media->description }}'
                                }; fullscreen = true">
                                @else
                                    <div class="relative flex h-full w-full cursor-pointer items-center justify-center bg-gray-800"
                                        @click="currentMedia = { 
                                    type: 'video', 
                                    url: '{{ $media->url }}', 
                                    title: '{{ $media->title }}',
                                    description: '{{ $media->description }}'
                                }; fullscreen = true">
                                        <i class="fas fa-play text-4xl text-white"></i>
                                        <img src="{{ $media->thumbnail_url ?? asset('images/icon_logo.png') }}"
                                            alt="{{ $media->title }}"
                                            class="absolute inset-0 h-full w-full object-cover opacity-70">
                                    </div>
                                @endif

                                <div
                                    class="pointer-events-none absolute inset-0 flex items-end bg-gradient-to-t from-black/60 to-transparent p-3 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                    <div class="text-white">
                                        <h3 class="truncate font-medium">{{ $media->title }}</h3>
                                        <p class="truncate text-xs text-gray-300">{{ $media->description }}</p>
                                    </div>
                                </div>

                                <!-- Actions (owner only) -->
                                @if (auth()->id() === $user->id)
                                    <div
                                        class="absolute right-2 top-2 flex space-x-1 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                        <button @click.stop="$wire.openModal({{ $media->id }})"
                                            class="rounded-full bg-white/80 p-1 hover:bg-white">
                                            <i class="fas fa-edit text-sm text-gray-800"></i>
                                        </button>
                                        <button
                                            @click.stop="mediaToDelete = {{ $media->id }}; deleteModalTitle = '{{ __('gallery_manage.delete') }} {{ addslashes($media->title) }}'; showDeleteModal = true"
                                            class="rounded-full bg-white/80 p-1 hover:bg-white">
                                            <i class="fas fa-trash text-sm text-red-600"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                      
                    </div>
                </template>

                <!-- Mode Liste -->
                <template x-if="viewMode === 'list'">
                    <div class="flex flex-wrap items-center gap-2">
                        @foreach ($galleries as $media)
                            <div
                                class="w-1/3 group flex items-center rounded-lg bg-white p-3 shadow transition-shadow duration-300 hover:shadow-md">
                                <div class="h-16 w-16 flex-shrink-0 cursor-pointer overflow-hidden rounded-md"
                                    @click="currentMedia = { 
                                    type: '{{ $media->type }}', 
                                    url: '{{ $media->url }}', 
                                    title: '{{ $media->title }}',
                                    description: '{{ $media->description }}'
                                }; fullscreen = true">
                                    @if ($media->type === 'image')
                                        <img src="{{ $media->thumbnail_url ?? $media->url }}" alt="{{ $media->title }}"
                                            class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-gray-800">
                                            <i class="fas fa-play text-lg text-white"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="ml-4 min-w-0 flex-1">
                                    <h3 class="truncate text-sm font-medium text-gray-900">{{ $media->title }}</h3>
                                    <p class="truncate text-xs text-gray-500">
                                        {{ $media->description ?: ' ' }}</p>
                                    <div class="mt-1 flex items-center text-xs text-gray-400">
                                        <span class="flex items-center">
                                            <i class="fas fa-{{ $media->type === 'image' ? 'image' : 'video' }} mr-1"></i>
                                            {{ $media->type === 'image' ? __('gallery_manage.image') : __('gallery_manage.video') }}
                                        </span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $media->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>

                                <!-- Actions (owner only) -->
                                @if (auth()->id() === $user->id)
                                    <div class="flex space-x-2 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                        <button @click.stop="$wire.openModal({{ $media->id }})"
                                            class="p-2 text-gray-500 hover:text-blue-600">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button
                                            @click.stop="mediaToDelete = {{ $media->id }}; deleteModalTitle = '{{ __('gallery_manage.delete') }} {{ addslashes($media->title) }}'; showDeleteModal = true"
                                            class="p-2 text-gray-500 hover:text-red-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endforeach

        
                    </div>
                </template>
            @endif
        @endif
    @endif 












<!-- Modal d'ajout/édition -->
    <x-modal wire:model="showModal" maxWidth="2xl">
        <div class="p-6 font-roboto-slab">
            <h3 class="mb-4 text-xl font-semibold text-green-gs font-roboto-slab">
                {{ $selectedMedia ? __('gallery_manage.edit_media') : __('gallery_manage.add_media') }}
            </h3>

            <form wire:submit.prevent="saveMedia">
                <div class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-green-gs">{{ __('gallery_manage.title') }}
                            *</label>
                        <input type="text" wire:model="title" class="w-full rounded-lg border-gray-300">
                        @error('title')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-green-gs">{{ __('gallery_manage.description') }}</label>
                        <textarea wire:model="description" rows="3" class="w-full rounded-lg border-gray-300"></textarea>
                    </div>

                    @if (!$selectedMedia)
                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-green-gs">{{ __('gallery_manage.media') }}
                                *</label>
                            <div x-data="{ isUploading: false, progress: 0, isDragging: false }" x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                                @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                                @drop.prevent="isDragging = false; $wire.uploadMultiple('media', $event.dataTransfer.files)">
                                <div class="rounded-lg border-2 border-dashed border-gray-300 p-4 text-center"
                                    :class="{ 'border-green-gs bg-green-gs/10': isDragging, 'border-gray-300': !isDragging }">
                                    <input type="file" wire:model="media" multiple accept="image/*,video/*"
                                        class="hidden" id="galleryUpload">
                                    <label for="galleryUpload" class="cursor-pointer">
                                        <i class="fas fa-cloud-upload-alt mb-2 text-3xl text-green-gs"></i>
                                        <p class="text-sm text-gray-600">{{ __('gallery_manage.drag_drop') }}</p>
                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ __('gallery_manage.supported_formats') }}</p>
                                    </label>
                                </div>

                                <template x-if="isUploading">
                                    <div class="mt-2">
                                        <div class="h-2 overflow-hidden rounded-full bg-gray-200">
                                            <div class="h-full bg-blue-500" :style="`width: ${progress}%`"></div>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500"
                                            x-text="`{{ __('gallery_manage.uploading') }}... ${progress}%`"></p>
                                    </div>
                                </template>

                                @error('media.*')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Prévisualisations -->
                        <template x-if="$wire.previews.length > 0">
                            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
                                <template x-for="(preview, index) in $wire.previews" :key="index">
                                    <div class="group relative overflow-hidden rounded-lg border">
                                        <!-- {{ __('gallery_manage.image') }} -->
                                        <template x-if="preview.type === 'image'">
                                            <img :src="preview.url" :alt="preview.name"
                                                class="h-32 w-full object-cover">
                                        </template>

                                        <!-- {{ __('gallery_manage.video') }} -->
                                        <template x-if="preview.type === 'video'">
                                            <div class="flex h-32 w-full items-center justify-center bg-gray-200">
                                                <i class="fas fa-video text-2xl text-gray-400"></i>
                                            </div>
                                        </template>

                                        <!-- Infos -->
                                        <div class="absolute inset-x-0 bottom-0 bg-black/70 p-2 text-white">
                                            <p class="truncate text-xs" x-text="preview.name"></p>
                                            <div class="mt-1 h-1 rounded-full bg-gray-600">
                                                <div class="h-full rounded-full bg-blue-500"
                                                    :style="'width: ' + ($wire.uploadProgress[index] || 0) + '%'"></div>
                                            </div>
                                        </div>

                                        <!-- Bouton supprimer -->
                                        <button type="button" @click="$wire.removePreview(index)"
                                            class="absolute right-2 top-2 rounded-full bg-white/80 p-1 opacity-0 transition-opacity group-hover:opacity-100">
                                            <i class="fas fa-times text-sm text-red-600"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </template>
                    @endif

                    <div class="flex items-center">
                        <input type="checkbox" wire:model="isPublic" id="isPublic"
                            class="rounded border-gray-300 text-green-gs">
                        <label for="isPublic"
                            class="ml-2 text-sm text-green-gs">{{ __('gallery_manage.make_public') }}</label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="$wire.showModal = false"
                        class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-green-gs transition-colors hover:bg-gray-200">
                        {{ __('gallery_manage.cancel') }}
                    </button>
                    <button type="submit" class="bg-green-gs
                     rounded px-4 py-2 text-sm font-medium text-white transition-colors 
                     hover:bg-green-gs/80 rounded-sm">
                        {{ $selectedMedia ? __('gallery_manage.update') : __('gallery_manage.save') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>






    <!-- Modal de confirmation de suppression -->
    <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="w-full max-w-md overflow-hidden rounded-lg bg-white shadow-xl">
            <div class="p-6">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="deleteModalTitle"></h3>
                    <button @click="showDeleteModal = false" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <p class="mb-6 text-gray-600">{{ __('gallery_manage.confirm_delete') }}</p>

                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteModal = false"
                        class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200">
                        {{ __('gallery_manage.cancel') }}
                    </button>
                    <button @click="deleteFunc(); showDeleteModal = false"
                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i> {{ __('gallery_manage.delete') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Modal de visualisation -->
    <div x-show="fullscreen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black p-4"
        @click.away="fullscreen = false" @keydown.escape.window="fullscreen = false">

        <template x-if="currentMedia">
            <div class="relative w-full">
                <!-- Bouton précédent -->
                <button @click.stop="navigateMedia(-1)"
                
                     class="absolute left-4 top-1/2 -translate-y-1/2 z-10 rounded-full bg-green-gs p-2 text-white hover:bg-supaGirlRose"
                    :class="{ 'opacity-50 cursor-not-allowed': currentMediaIndex <= 0 }"
                    :disabled="currentMediaIndex <= 0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                </button>

               

                <!-- Bouton suivant -->
                <button @click.stop="navigateMedia(1)"
                    class="absolute right-4 top-1/2 -translate-y-1/2 z-10 rounded-full bg-green-gs p-2 text-white hover:bg-supaGirlRose"
                    :class="{ 'opacity-50 cursor-not-allowed': currentMediaIndex >= mediaCount - 1 }"
                    :disabled="currentMediaIndex >= mediaCount - 1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                 </button>

                <!-- Bouton fermer -->
                

                <button @click="fullscreen = false" class="absolute right-4 top-4 z-10 rounded-full bg-supaGirlRose p-2 text-green-gs hover:text-white hover:bg-green-gs">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

                <!-- Contenu média -->
                <div class="relative overflow-hidden rounded-lg bg-black">
                    <template x-if="currentMedia.type === 'image'">
                        <img :src="currentMedia.url" :alt="currentMedia.title"
                            class="mx-auto max-h-[80vh] w-full object-contain">
                    </template>

                    <template x-if="currentMedia.type === 'video'">
                        <video controls autoplay class="mx-auto max-h-[80vh] w-full">
                            <source :src="currentMedia.url" type="video/mp4">
                            {{ __('gallery_manage.video_not_supported') }}
                        </video>
                    </template>

                    <div class="bg-gray-900 p-4 text-white">
                        <h3 x-text="currentMedia.title" class="text-xl font-semibold"></h3>
                        <p x-text="currentMedia.description" class="mt-1 text-gray-300"></p>
                        <div class="mt-2 text-sm text-gray-400">
                            <span x-text="`${currentMediaIndex + 1} / ${mediaCount}`"></span>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    </div>
</div>
