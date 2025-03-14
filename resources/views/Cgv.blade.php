@extends('layouts.base')
  @section('content')

  @section('extraStyle')
    <style>
      h1{
        font-size: 40px;
        font-family: 'DM serif';
        color: var(--color-green-gs);
        text-align: center;
        padding: 20px 0;
        font-weight: bold;
      }
      h2{
        font-size: 30px;
        font-family: 'DM serif';
        font-weight: bold;
        padding: 10px 0;
      }
      h4.elementor-toc__header-title{
        display: none;
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
      {{-- <h2 class="text-5xl font-dm-serif font-bold text-green-gs text-center py-2">Conditions générales de vente (CGV)</h2> --}}
      {!! $apiData['cgv']['content']['rendered'] !!}
    </div>
  </div>

  @stop
