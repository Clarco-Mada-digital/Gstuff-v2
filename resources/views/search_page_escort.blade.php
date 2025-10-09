@extends('layouts.base')

@section('extraStyle')
    <style>
        input[type=range]::-webkit-slider-thumb {
            pointer-events: all;
            width: 24px;
            height: 24px;
            -webkit-appearance: none;
            /* @apply w-6 h-6 appearance-none pointer-events-auto; */
        }
    </style>
@endsection

@section('pageTitle')
    Escort
@endsection

@section('content')
    @livewire('escort-search')

    <x-feedback-section />

    <x-call-to-action-inscription />
@endsection

@section('extraScripts')
@endsection
