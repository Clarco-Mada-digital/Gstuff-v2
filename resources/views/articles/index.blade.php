@extends('layouts.base')

@section('pageTitle')
    {{ __('glossary.page_title') }}
@endsection

@section('content')

    <div class="bg-supaGirlRose flex w-full items-center justify-center py-20">
        <h2 class="font-roboto-slab text-green-gs text-center text-5xl">{{ __('glossary.glossary_title') }}</h2>
    </div>

    @livewire('glossaireList')
    {{-- <div class="md:w-[80%] w-full h-auto mx-auto p-2 flex items-center flex-wrap xl:flex-nowrap justify-center gap-3 bg-white rounded-md xl:-translate-y-[50%] -translate-y-[30%] shadow-lg">
    @foreach (range('A', 'Z') as $item)
    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-md bg-whire text-green-gs border border-gray-300 font-roboto-slab  xl:text-xl font-bold hover:bg-green-gs hover:text-white transition-all">{{ Str::upper($item) }}</a>
    @endforeach
  </div>

  <div class="lg:container mx-auto px-5 lg:p-10">
    @foreach ($glossaires as $glossaire)
    <div class="flex flex-col justify-center gap-1 my-5 text-sm xl:text-base">
      <a href="{{route('glossaires.show', $glossaire->slug)}}" class="text-2xl xl:text-4xl font-roboto-slab text-green-gs font-bold">{{ $glossaire->title }}</a>
      @if ($glossaire->excerpt)
        {!! $glossaire->excerpt !!}
      @else
      <p>{!! $glossaire->content !!}</p>
      @endif        
    </div>
    @endforeach

    <div>{{$glossaires->links('pagination::simple-tailwind')}}</div>
  </div> --}}

@stop
