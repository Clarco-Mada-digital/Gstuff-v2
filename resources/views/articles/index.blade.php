@extends('layouts.base')

  @section('pageTitle')
      Glossaires
  @endsection

  @section('content')

  <div class="w-full flex items-center justify-center bg-green-gs/30 py-20">
    <h2 class="font-dm-serif text-5xl text-center text-green-gs">Glossaire</h2>
  </div>
  <div class="md:w-[80%] w-full h-auto mx-auto p-2 flex items-center flex-wrap xl:flex-nowrap justify-center gap-3 bg-white rounded-md xl:-translate-y-[50%] -translate-y-[30%] shadow-lg">
    @foreach (range('A', 'Z') as $item)
    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-md bg-whire text-green-gs border border-gray-300 font-dm-serif text-base xl:text-xl font-bold hover:bg-green-gs hover:text-white transition-all">{{ Str::upper($item) }}</a>
    @endforeach
  </div>

  <div class="lg:container mx-auto px-5 lg:p-10">
    @foreach ($articles as $glossaire)
    <div class="flex flex-col justify-center gap-1 my-5 text-sm xl:text-base">
      <h3 class="text-2xl xl:text-4xl font-dm-serif text-green-gs font-bold">{{ $glossaire->title }}</h3>
      @if ($glossaire->excerpt)
      <p>{{$glossaire->excerpt}}</p>
      @else
      <p>{!! $glossaire->content !!}</p>
      @endif        
    </div>
    @endforeach
  </div>

  @stop
