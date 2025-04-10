@extends('layouts.base')

  @section('pageTitle')
    {{$page->slug}}
  @endsection

  @section('content')

  @section('extraStyle')
    <style>
      h3{
        font-family: 'DM serif';
        font-size: 30px;
        font-weight: bold;
        margin: 10px 0;
      }
      .content a{
        color: var(--color-green-gs);
      }
      .content a:hover{
        color: #e9d168;
      }
    </style>
  @endsection

  <div class="w-full bg-green-gs/50 py-10 content" style="background: url('images/Fond-page-politique.jpg') center center /cover">
    <div class="w-full lg:w-[70%] lg:mx-auto p-5 bg-white">
      <h1 class="text-6xl font-dm-serif font-bold text-green-gs text-center py-2 shadow-lg w-full">{{$page->title}}</h1>
      {!! $page->content !!}
    </div>
  </div>

  @stop
