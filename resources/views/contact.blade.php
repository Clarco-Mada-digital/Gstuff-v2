@extends('layouts.base')

  @section('pageTitle')
    Contact
  @endsection

  @section('content')

  <div class="relative w-full py-50" style="background: url('images/girl_deco_image.jpg') center center /cover">
    <div class="absolute flex items-center justify-center top-0 left-0 bg-black/30 w-full h-full z-0">
    <h2 class="font-dm-serif text-5xl text-amber-400 font-bold text-center z-10">Nous contacter</h2>
    </div>
  </div>

  <div class="flex items-center w-full gap-5 py-5">
    <div class="w-full lg:w-1/2 flex flex-col justify-center items-center gap-5 px-1 xl:px-10 text-sm xl:text-base">
      <h2 class="font-dm-serif text-3xl text-green-gs text-center">Besoin d’informations ou de conseils ? Contactez-nous dès maintenant !</h2>

      <form action="#" method="POST" class="flex flex-col gap-3 w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 w-full">
          <div class="flex flex-col w-full gap-2">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom"  class="border rounded-lg focus:border-amber-400 ring-0" placeholder="Nom">
          </div>
          <div class="flex flex-col w-full gap-2">
            <label for="contact_email">Email</label>
            <input type="email" name="email" id="contact_email"  class="border rounded-lg focus:border-amber-400 ring-0" placeholder="Email">
          </div>
        </div>
        <div class="grid grid-cols-1">
          <div class="flex flex-col w-full gap-2">
            <label for="sujet">Sujet</label>
            <input type="text" name="sujet" id="sujet"  class="border rounded-lg focus:border-amber-400 ring-0" placeholder="Sujet">
          </div>
        </div>
        <div class="grid grid-cols-1">
          <div class="flex flex-col w-full gap-2">
            <label for="sujet">Message</label>
            <textarea name="message" id="message" rows="10"  class="border rounded-lg focus:border-amber-400 ring-0" placeholder="Message"></textarea>
          </div>
        </div>
        <div class="grid grid-cols-1 w-full">
          <button type="submit" class="w-full bg-green-gs rounded-lg text-center text-white p-3 text-lg cursor-pointer hover:bg-green-gs/70">Envoyer</button>
        </div>
      </form>
    </div>
    <div class="hidden lg:block lg:w-1/2 h-screen rounded-lg" style="background: url('images/girl_deco_contact_001.jpg') center center /cover"></div>

  </div>

  @stop
