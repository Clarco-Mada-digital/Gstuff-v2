@props([
    'title' => '',
    'buttonText' => '',
    'class' => ''
])

<div class="font-roboto-slab text-supaGirlRose my-3 flex w-full flex-col items-center justify-center gap-5 {{ $class }}">
    <svg class="w-25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path fill="currentColor"
            d="M6 7.5a5.5 5.5 0 1 1 11 0a5.5 5.5 0 0 1-11 0M18 14c.69 0 1.25.56 1.25 1.25V16h-2.5v-.75c0-.69.56-1.25 1.25-1.25m3.25 2v-.75a3.25 3.25 0 0 0-6.5 0V16h-1.251v6.5h9V16zm-9.75 6H2v-2a6 6 0 0 1 6-6h3.5z" />
    </svg>
    @if($title)
        <p class="text-center text-3xl font-extrabold">{{ $title }}</p>
    @endif
    <button 
        data-modal-target="authentication-modal" 
        data-modal-toggle="authentication-modal"
        class="font-roboto-slab bg-green-gs px-5 py-2 text-white rounded-lg font-bold hover:bg-green-gs/80 transition-colors"
    >
        {{ $buttonText }}
    </button>
</div>
