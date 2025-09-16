@extends('layouts.base')

@section('pageTitle')
    {{ __('glossary.page_title') }}
@endsection

@section('content')

    <div class="bg-supaGirlRose flex w-full items-center justify-center py-20">
        <h2 class="font-roboto-slab text-green-gs text-center text-xl md:text-5xl">{{ __('glossary.glossary_title') }}</h2>
    </div>

    @livewire('glossaireList')
   

@stop
