@extends('layouts.base')

@section('pageTitle', __('contact.page_title'))

@section('content')
<div class="relative w-full py-50" style="background: url('images/girl_deco_image.jpg') center center /cover">
  <div class="absolute flex items-center justify-center top-0 left-0 bg-black/30 w-full h-full z-0">
    <h2 class="font-dm-serif text-5xl text-amber-400 font-bold text-center z-10">{{__('contact.contact_us')}}</h2>
  </div>
</div>

<div class="flex items-center w-full gap-5 py-5">
  <div class="w-full lg:w-1/2 flex flex-col justify-center items-center gap-5 px-1 xl:px-10 text-sm xl:text-base">
    @if(auth()->user())
    <button id="showCommentaire" class="cursor-pointer">
      <h2 class="font-dm-serif text-2xl text-green-gs text-center">{{__('contact.make_comment')}}</h2>
    </button>
    @endif

    <button id="showConseil" class="cursor-pointer">
      <h2 class="font-dm-serif text-2xl text-green-gs text-center">{{__('contact.need_info')}}</h2>
    </button>

    @if(auth()->user())
    <form id="commentaireForm" method="POST" class="flex flex-col gap-3 w-full hidden" action="{{ route('commentaires.store') }}">
      @csrf
      <div class="flex flex-col w-full gap-2">
        <label for="messageCommentaire">{{__('contact.comment')}}</label>
        <textarea name="content" id="messageCommentaire" rows="10" class="border rounded-lg focus:border-amber-400 ring-0" placeholder="{{__('contact.message_placeholder')}}"></textarea>
      </div>
      <button type="submit" class="w-full bg-green-gs rounded-lg text-center text-white p-3 text-lg cursor-pointer hover:bg-green-gs/70">{{__('contact.send')}}</button>
    </form>
    @endif

    {{-- <form id="conseilForm" action="#" method="POST" class="flex flex-col gap-3 w-full">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3 w-full">
        <div class="flex flex-col w-full gap-2">
          <label for="nom">{{__('contact.name')}}</label>
          <input type="text" name="nom" id="nom" class="border rounded-lg focus:border-amber-400 ring-0" placeholder="{{__('contact.name_placeholder')}}">
        </div>
        <div class="flex flex-col w-full gap-2">
          <label for="contact_email">{{__('contact.email')}}</label>
          <input type="email" name="email" id="contact_email" class="border rounded-lg focus:border-amber-400 ring-0" placeholder="{{__('contact.email_placeholder')}}">
        </div>
      </div>
      <div class="flex flex-col w-full gap-2">
        <label for="sujet">{{__('contact.subject')}}</label>
        <input type="text" name="sujet" id="sujet" class="border rounded-lg focus:border-amber-400 ring-0" placeholder="{{__('contact.subject_placeholder')}}">
      </div>
      <div class="flex flex-col w-full gap-2">
        <label for="messageConseil">{{__('contact.message')}}</label>
        <textarea name="message" id="messageConseil" rows="10" class="border rounded-lg focus:border-amber-400 ring-0" placeholder="{{__('contact.message_placeholder')}}"></textarea>
      </div>
      <button type="submit" class="w-full bg-green-gs rounded-lg text-center text-white p-3 text-lg cursor-pointer hover:bg-green-gs/70">{{__('contact.send')}}</button>
    </form> --}}
    @livewire('contact')

  </div>

  <div class="hidden lg:block lg:w-1/2 h-screen rounded-lg" style="background: url('images/girl_deco_contact_001.jpg') center center /cover"></div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const commentaireForm = document.getElementById('commentaireForm');
    const conseilForm = document.getElementById('conseilForm');
    const showCommentaireButton = document.getElementById('showCommentaire');
    const showConseilButton = document.getElementById('showConseil');

    showCommentaireButton.addEventListener('click', function () {
      commentaireForm.classList.remove('hidden');
      conseilForm.classList.add('hidden');
    });

    showConseilButton.addEventListener('click', function () {
      conseilForm.classList.remove('hidden');
      commentaireForm.classList.add('hidden');
    });

    conseilForm.classList.remove('hidden');
    commentaireForm.classList.add('hidden');
  });
</script>
@stop
