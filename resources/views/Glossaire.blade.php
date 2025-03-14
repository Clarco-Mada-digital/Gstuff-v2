@extends('layouts.base')
  @section('content')

  <div class="w-full flex items-center justify-center bg-green-gs/30 py-20">
    <h2 class="font-dm-serif text-5xl text-center text-green-gs">Glossaire</h2>
  </div>
  <div class="w-[80%] h-auto mx-auto p-2 flex items-center flex-wrap xl:flex-nowrap justify-center gap-3 bg-white rounded-md -translate-y-[50%] shadow-lg">
    @foreach (range('A', 'Z') as $item)
    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-md bg-whire text-green-gs border border-gray-300 font-dm-serif text-xl font-bold hover:bg-green-gs hover:text-white transition-all">{{ Str::upper($item) }}</a>
    @endforeach
  </div>

  <div class="lg:container mx-auto px-5 lg:p-10">
    @foreach ($apiData['glossaires'] as $glossaire)
    <div class="flex flex-col justify-center gap-1 my-5">
      <h3 class="text-4xl font-dm-serif text-green-gs font-bold">{{ $glossaire['title']['rendered'] }}</h3>
      <p>{!! $glossaire['excerpt']['rendered'] !!}</p>
    </div>
    @endforeach
  </div>

  @stop
