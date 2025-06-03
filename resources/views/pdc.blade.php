@extends('layouts.base')

@section('pageTitle')
    {{ $page->slug }}
@endsection

@section('content')

@section('extraStyle')
    <style>
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'DM serif';
            font-weight: bold;
            margin: 10px 0;
        }

        h3 {
            font-size: 24px;
        }

        h4 {
            font-size: 20px;
        }

        h5 {
            font-size: 18px;
        }

        h6 {
            font-size: 16px;
        }

        .content a {
            color: var(--color-green-gs);
        }

        .content a:hover {
            color: #e9d168;
        }
    </style>
@endsection

<div class="bg-green-gs/50 content w-full py-10"
    style="background: url('images/Fond-page-politique.jpg') center center /cover">
    <div class="w-full bg-white p-5 lg:mx-auto lg:w-[70%]">
        <h1 class="font-dm-serif text-green-gs w-full py-2 text-center text-6xl font-bold shadow-lg">{{ $page->title }}
        </h1>
        {!! $page->content !!}
    </div>
</div>

@stop
