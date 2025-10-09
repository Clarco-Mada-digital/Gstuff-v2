@extends('layouts.base')

@section('pageTitle')
    {{ __('register_form.page_title') }}
@endsection

@section('content')
    <div x-data="{ 'InviteForm': true }" class="relative w-full overflow-x-hidden">

        {{-- Invitée section --}}
        <div x-data="{ 'registerForm': '' }" x-show="InviteForm" x-transition:enter="transition ease-in-out duration-500"
            x-transition:enter-start="opacity-0 -translate-x-[50%]" x-transition:enter-end="opacity-100"
            class="flex h-full w-full items-center justify-center">

            {{-- Formulaire --}}
            <div
                class="pt-30 xl:px-30 mx-auto flex w-full flex-col items-center justify-center gap-20 px-2 pb-5 xl:w-1/2 xl:pt-0">
                <h2 class="font-roboto-slab text-green-gs text-center text-2xl font-bold">
                    {{ __('register_form.become_member') }}</h2>

                {{-- Inscription Invité Formulaire --}}
                <form class="mx-auto flex w-full flex-col gap-5" action="{{ route('register') }}" method="POST">
                    @csrf

                    <input type="hidden" name="profile_type" value="invite">

                    <x-form.floating-input name="pseudo" :label="__('register_form.pseudo')" type="text" :required="true"
                        autocomplete="pseudo" :value="old('pseudo')" />

                    <x-form.floating-input name="email" :label="__('register_form.email')" type="email" :required="true"
                        autocomplete="email" />


                    <x-form.floating-input name="date_naissance" :label="__('register_form.birth_date')" type="date" :required="true"
                        autocomplete="date_naissance" :value="old('date_naissance')" />


                    <x-form.floating-input name="password" :label="__('register_form.password')" type="password" :required="true"
                        autocomplete="new-password" />

                    <x-form.floating-input name="password_confirmation" :label="__('register_form.confirm_password')" type="password"
                        :required="true" autocomplete="new-password" />




                    <x-form.terms-checkbox name="cgu_accepted" :label="__('register_form.accept_terms')" :termsText="__('register_form.terms_conditions')" :termsLinkText="__('register_form.terms_conditions_link')"
                        :termsLink="route('static.page', 'cgv')" :checked="old('cgu_accepted', false)" :required="true">
                        {{ __('register_form.see_terms') }}
                    </x-form.terms-checkbox>


                    <x-form.submit-button :text="__('register_form.register')" />
                </form>
            </div>

            {{-- Image deco --}}
            <div class="relative hidden min-h-[90vh] w-1/2 xl:block"
                style="background: url(images/girl_deco_register.jpg) center center /cover"></div>

        </div>

    </div>
@endsection

@section('extraScripts')
@endsection
