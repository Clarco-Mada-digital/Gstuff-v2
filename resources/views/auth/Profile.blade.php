@extends('layouts.base')

  @section('page_title')
      Profile page
  @endsection

  @section('content')
  <div class="container">
    <div class="flex items-center justify-center">
      <div class="w-[50%]">
        <div class="card">
          <div class="card-header">{{ __('Profil') }}</div>
          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-success" role="alert">
                {{ session('success') }}
              </div>
            @endif
            <p>{{ __('Bonjour') }}, {{ Auth::user()->pseudo ?? Auth::user()->prenom ?? Auth::user()->nom_salon ?? Auth::user()->email }} !</p>
            <p>{{ __('Type de profil') }}: {{ ucfirst(Auth::user()->profile_type) }}</p>

            {{-- Afficher des informations spécifiques au profil ici --}}
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              {{ __('Déconnexion') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
              @csrf
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection

{{-- @stop --}}
