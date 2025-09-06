@props(['count', 'description', 'class' => ''])

<div {{ $attributes->merge([
    'class' =>
        'group flex w-full flex-col items-center justify-center gap-3 bg-complementaryColorViolet p-3 text-2xl font-bold text-white transition-all duration-300 hover:shadow-lg hover:-translate-y-1 hover:bg-opacity-90 lg:h-[263px] lg:w-[367px] lg:text-4xl ' .
        $class,
]) }}
    x-data="{}" x-init="$el.style.setProperty('--tw-bg-opacity', '1')">
    <span
        class="font-roboto-slab w-[70%] text-center transition-transform duration-300 group-hover:scale-105">{{ $count }}</span>
    <span
        class="mx-auto w-[75%] text-center text-sm font-normal transition-all duration-300 group-hover:text-opacity-90 lg:text-base">
        {{ $description }}
    </span>
</div>
