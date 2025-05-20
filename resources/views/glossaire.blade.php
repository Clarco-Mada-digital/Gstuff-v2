@extends('layouts.base')

@section('pageTitle')
    {{ __('glossary.page_title') }}
@endsection

@section('content')

    <div class="bg-green-gs/30 flex w-full items-center justify-center py-20">
        <h2 class="font-dm-serif text-green-gs text-center text-5xl">{{ __('glossary.glossary_title') }}</h2>
    </div>
    <div
        class="mx-auto flex h-auto w-full -translate-y-[30%] flex-wrap items-center justify-center gap-3 rounded-md bg-white p-2 shadow-lg md:w-[80%] xl:-translate-y-[50%] xl:flex-nowrap">
        @foreach (range('A', 'Z') as $item)
            <a href="#"
                class="text-green-gs font-dm-serif hover:bg-green-gs flex h-10 w-10 items-center justify-center rounded-md border border-gray-300 bg-white text-base font-bold transition-all hover:text-white xl:text-xl">{{ Str::upper($item) }}</a>
        @endforeach
    </div>

    <div class="mx-auto px-5 lg:container lg:p-10">
        @foreach ($glossaires as $glossaire)
            <div class="my-5 flex flex-col justify-center gap-1 text-sm xl:text-base">
                <h3 class="font-dm-serif text-green-gs text-2xl font-bold xl:text-4xl">{{ $glossaire->title }}</h3>
                {!! $glossaire->excerpt !!}
            </div>
        @endforeach
    </div>

@stop
