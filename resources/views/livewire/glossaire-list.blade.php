<div>
    <div
        class="mx-auto flex h-auto w-full -translate-y-[30%] flex-wrap items-center justify-center gap-3 rounded-md bg-white p-2 shadow-lg md:w-[80%] xl:-translate-y-[50%] xl:flex-nowrap">
        @foreach (range('A', 'Z') as $item)
            <div>
                <input wire:model.live='lettreSearche' id="lettre{{ $item }}" name="{{ $item }}"
                    class="peer hidden" type="checkbox" value="{{ $item }}" />
                <label for="lettre{{ $item }}"
                    class="bg-whire text-green-gs font-dm-serif hover:bg-green-gs peer-checked:bg-green-gs flex h-10 w-10 cursor-pointer items-center justify-center rounded-md border border-gray-300 text-base font-bold transition-all hover:text-white peer-checked:text-white xl:text-xl">{{ Str::upper($item) }}</label>
            </div>
        @endforeach
    </div>

    <div class="mx-auto px-5 lg:container lg:p-10">
        @foreach ($glossaires as $glossaire)
            <div class="my-5 flex flex-col justify-center gap-1 text-sm xl:text-base">
                <a href="{{ route('glossaires.show', $glossaire->slug) }}"
                    class="font-dm-serif text-green-gs text-2xl font-bold xl:text-4xl">{{ $glossaire->title }}</a>
                @if ($glossaire->excerpt)
                    {!! $glossaire->excerpt !!}
                @else
                    <p>{!! $glossaire->content !!}</p>
                @endif
            </div>
        @endforeach

        <div>{{ $glossaires->links('pagination::simple-tailwind') }}</div>
    </div>
</div>
