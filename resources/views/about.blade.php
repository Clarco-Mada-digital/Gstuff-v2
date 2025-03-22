@extends('layouts.base')

  @section('pageTitle')
    Qui somme nous ?
  @endsection

  @section('content')

  <div class="bg-white flex flex-col items-center gap-4 h-30 xl:min-h-60 w-full text-center pt-5 px-2 py-60 z-0">
    <h2 class="font-dm-serif text-2xl xl:text-5xl font-bold text-green-gs">Qui sommes-nous ?</h2>
    <p class="text-sm">Bienvenue sur Gstuff.ch, la plateforme suisse d’annonces érotiques dédiée à la célébration du plaisir sexuel dans toute sa diversité.</p>
  </div>

  <div class="bg-green-gs min-h-60 pb-4 w-full">
    <div class="w-full xl:w-[70%] mx-auto -translate-y-1/2">
      <img src="images/image_about_deco.png" alt="Image deco" />
    </div>
    <div class="grid grid-cols-1 px-10 text-center lg:grid-cols-2 w-full lg:gap-40 xl:w-[65%] mx-auto lg:-mt-20 text-white">
      <div class="text-wrap text-sm xl:text-base">
        <h3 class="text-2xl xl:text-5xl font-dm-serif mb-10">Genèse de Gstuff</h3>
        <p class="text-justify my-3">Gstuff s’écrit avec un G majuscule, en référence à la zone de plaisir appelée point G ou zone G, et signifie donc tout ce qui est en lien avec le plaisir. Dès lors, Gstuff se veut être un site d’annonces érotiques inclusif, c’est-à-dire que seul le plaisir compte, peu importe comment et avec qui, du moment que cela reste entre adultes consentants.</p>
        <p class="text-justify my-3">Le plaisir érotique est une facette intime de l’expérience humaine, qui transcende les frontières des identités de genre. C’est un territoire riche en sensations, émotions et connections qui nous relie à notre essence la plus profonde. Pour Gstuff, il est primordial de célébrer le plaisir érotique de manière inclusive, en embrassant toutes les identités de genre. De la fluidité des genres à la non-conformité, chaque individu mérite d’explorer librement sa sexualité sans peur ni jugement.</p>
      </div>
      <div class="hidden lg:flex flex-col gap-5">
        <div class="w-90 h-60" style="background: url('images/girl_deco_about_001.jpg') center center /cover"></div>
        <div class="w-90 h-60" style="background: url('images/girl_deco_about_002.jpg') center center /cover"></div>
      </div>
    </div>
  </div>

  <div class="xl:w-[80%] w-full mx-auto bg-white flex flex-col md:flex-row items-center justify-center text-center gap-10 py-20">
    <div class="flex flex-col items-center justify-center gap-5 text-wrap w-full px-2 xl:w-1/3">
      <img src="images/fi_shield.png" alt="shield icon" />
      <h3 class="font-dm-serif text-3xl text-green-gs">Divertissement érotique</h3>
      <span>Vivez des expériences uniques avec nos partenaires soigneusement sélectionnés.​</span>
    </div>
    <div class="flex flex-col items-center justify-center gap-5 text-wrap w-full px-2 xl:w-1/3">
      <img src="images/fi_zap.png" alt="zap icon" />
      <h3 class="font-dm-serif text-3xl text-green-gs">Sécurité & Confidentialité</h3>
      <span>Rencontrez en toute confiance grâce à notre système de sécurité avancé.​</span>
    </div>
    <div class="flex flex-col items-center justify-center gap-5 text-wrap w-full px-2 xl:w-1/3">
      <img src="images/fi_map-pin.png" alt="map icon" />
      <h3 class="font-dm-serif text-3xl text-green-gs">Éducation et Information fiables</h3>
      <span>Accédez à des conseils sexologiques et des articles éducatifs pour une sexualité épanouie.​</span>
    </div>
  </div>

  <x-FeedbackSection />

  <x-CallToActionContact />

  <div class="lg:container mx-auto px-5 flex flex-col-reverse gap-10 lg:flex-row justify-center items-center xl:gap-20 my-5">
    <div class="w-full flex flex-col gap-10">
      <h3 class="text-5xl font-bold font-dm-serif text-green-gs text-center">Inscription en une minute.</h3>
      <form action="{{route('register')}}" method="POST" class="flex flex-col gap-4 text-sm xl:text-base">
        @csrf
        <input type="hidden" name="profile_type" value="invite">
        <div class="flex flex-col gap-2">
          <label for="user_name">user_name *</label>
          <input type="text" name="user_name" id="user_name" class="border rounded-lg focus:border-amber-400 ring-0 @error('user_name') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror" value="{{ old('user_name') }}" autocomplete="user_name" required>
          @error('user_name')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
          @enderror
        </div>
        <div class="flex flex-col gap-2">
          <label for="Insc_email">Adresse email *</label>
          <input type="email" name="email" id="Insc_email" class="border rounded-lg focus:border-amber-400 ring-0 @error('user_name') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror" value="{{ old('user_name') }}" autocomplete="email" required >
          @error('email')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
          @enderror
        </div>
        <div class="flex flex-col gap-2">
          <label for="date_naissance">Date de naissance</label>
          <input type="date" name="date_naissance" id="date_naissance" class="border rounded-lg focus:border-amber-400 ring-0 @error('date_naissance') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror" value="{{ old('date_naissance') }}" autocomplete="date_naissance" required>
          @error('date_naissance')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
          @enderror
        </div>
        <div class="flex flex-col gap-2">
          <label for="mdp">Mot de passe *</label>
          <input type="password" name="password" id="mdp" class="border rounded-lg focus:border-amber-400 ring-0 @error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror" value="{{ old('password') }}" autocomplete="password" required>
          @error('password')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
          @enderror
        </div>
        <div class="flex flex-col gap-2">
          <label for="cmdp">Confirmer votre mot de passe *</label>
          <input type="password" name="password_confirmation" id="cmdp" class="border rounded-lg focus:border-amber-400 ring-0 @error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror" value="{{ old('password') }}" autocomplete="password" required>
          @error('password')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
          @enderror
        </div>
        <div class="flex flex-col gap-2">
          <span class="text-wrap">Merci de consulter nos conditions générales d'utilisation. Voir les <a href="#" class="text-green-gs">condition générales d'utilisation. *</a></span>
          <div class="flex items-center gap-1">
            <input type="checkbox" name="cgu_accepted" id="cgu" required>
            <label for="cgu">J'ai lu et j'accepte les conditions générales</label>
          </div>
        </div>
        <button type="submit" class="bg-green-gs text-white text-center p-2 rounded-lg hover:bg-green-gs/80 cursor-pointer">INSCRIPTION</button>
      </form>
    </div>
    <div class="w-full flex flex-col gap-5 justify-center items-center">
      <div class="w-full min-h-30 lg:w-[450px] lg:h-[263px] bg-green-gs p-3 flex flex-col text-white text-3xl lg:text-4xl font-bold items-center justify-center gap-3 rounded-lg">
        <span class="text-center font-dm-serif w-[70%]">+ de 500 partenaires</span>
        <span class="text-center text-sm lg:text-base font-normal w-[75%] mx-auto">Profils vérifiés pour des rencontres authentiques</span>
      </div>
      <div class="w-full min-h-30 lg:w-[450px] lg:h-[263px] bg-green-gs p-3 flex flex-col text-white text-3xl lg:text-4xl font-bold items-center justify-center gap-3 rounded-lg lg:ml-10">
        <span class="text-center font-dm-serif w-[70%]">+ de 300 amateurs</span>
        <span class="text-center text-sm lg:text-base font-normal w-[75%] mx-auto">Expériences coquines avec des amateurs dédiés.</span>
      </div>
      <div class="w-full min-h-30 lg:w-[450px] lg:h-[263px] bg-green-gs p-3 flex flex-col text-white text-3xl lg:text-4xl font-bold items-center justify-center gap-3 rounded-lg">
        <span class="text-center font-dm-serif w-[70%]">+ de 200 salons professionnels</span>
        <span class="text-center text-sm lg:text-base font-normal w-[75%] mx-auto">Offres variées dans des cadres professionnels sécurisés.</span>
      </div>
    </div>
  </div>

  <x-CallToActionInscription />

  @stop
