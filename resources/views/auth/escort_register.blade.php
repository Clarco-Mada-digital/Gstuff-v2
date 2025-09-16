@extends('layouts.base')

@section('pageTitle')
    {{ __('escort_register_form.page_title') }}
@endsection

@section('content')
    <div class="relative w-full overflow-x-hidden">

        {{-- Escort section --}}
        <div class="flex h-full w-full items-center justify-center">

            {{-- Image deco --}}
            <div class="relative my-0 hidden min-h-[90vh] w-1/2 py-0 xl:block"
                style="background: url(images/girl_deco_escort.jpg) center center /cover"></div>

            {{-- Formulaire --}}
            <div class="xl:px-30 gap-5 md:gap-15 mx-auto flex w-full flex-col items-center justify-center px-2 py-3 xl:w-1/2">
                <h2 class="font-roboto-slab text-green-gs text-center text-xl md:text-2xl font-bold py-5 md:py-0">
                    {{ __('escort_register_form.register_escort') }}
                </h2>

                {{-- Inscription Escort Formulaire --}}
                <form class="mx-auto flex w-full flex-col gap-2 md:gap-5" action="{{ route('register') }}" method="POST">
                    @csrf
                    <input type="hidden" name="profile_type" value="escorte">

                    <x-form.floating-input name="prenom" :label="__('escort_register_form.first_name')" type="text" :required="true"
                        autocomplete="given-name" />

                    <x-form.floating-select name="genre_id" :label="__('escort_register_form.genre')" :options="$genres" :selected="old('genre_id')"
                        :required="true" :translate="true" option-label="name" />

                    <x-form.floating-input name="email" :label="__('escort_register_form.email')" type="email" :required="true"
                        autocomplete="email" />

                    <x-form.floating-input name="date_naissance" :label="__('escort_register_form.birth_date')" type="date" :required="true"
                        autocomplete="date_naissance" />

                    <x-form.floating-input name="password" :label="__('escort_register_form.password')" type="password" :required="true"
                        autocomplete="new-password" />

                    <x-form.floating-input name="password_confirmation" :label="__('escort_register_form.confirm_password')" type="password"
                        :required="true" autocomplete="new-password" />


                    <x-form.terms-checkbox name="cgu_accepted" :label="__('escort_register_form.accept_terms')" :termsText="__('escort_register_form.terms_conditions')" :termsLinkText="__('escort_register_form.terms_conditions_link')"
                        :termsLink="route('static.page', 'cgv')" :checked="old('cgu_accepted', false)" :required="true">
                        {{ __('escort_register_form.see_terms') }}
                    </x-form.terms-checkbox>

                    <x-form.submit-button :text="__('escort_register_form.register')" />
                </form>
            </div>
        </div>
    </div>
@endsection

@section('extraScripts')
@endsection
