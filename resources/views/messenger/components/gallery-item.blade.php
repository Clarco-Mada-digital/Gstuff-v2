@php
    $image = json_decode($photo->attachment);
@endphp

<li>
    <a class="venobox cursor-zoom-in" href="#"
        @click.prevent="$dispatch('img-modal', { imgModalSrc: '{{ asset($image) }}', imgModalDesc: '' })">
        <img src="{{ asset($image) }}" alt="Media partagé" class="w-full h-24 object-cover rounded" loading="lazy">
    </a>
</li>
