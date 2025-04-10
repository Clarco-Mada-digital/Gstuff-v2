@extends('layouts.base')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="prose prose-indigo max-w-none">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">{{ $page->title }}</h1>
            
            <div class="mt-6 text-gray-500">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</div>
@endsection