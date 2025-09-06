@props(['title', 'content'])
@if ($content)
    <div class="flex items-center justify-between gap-5 py-5">
        <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ $title }}</h2>
        <div class="bg-green-gs h-0.5 flex-1"></div>
    </div>
    <div class="flex flex-wrap items-center gap-10">
        <p class="font-roboto-slab text-textColor text-justify text-sm">{{ $content ?? '-' }}</p>
    </div>
@endif
