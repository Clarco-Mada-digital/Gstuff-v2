@php
    $image = json_decode($photo->attachment);
@endphp

<li>
    <a class="venobox cursor-zoom-in" href="#"
        @click.prevent="$dispatch('img-modal', { imgModalSrc: '{{ asset($image) }}', imgModalDesc: '' })">
        <img src="{{ asset($image) }}" alt="Media partagé" class="h-24 w-full rounded object-cover" loading="lazy">
    </a>
</li>
