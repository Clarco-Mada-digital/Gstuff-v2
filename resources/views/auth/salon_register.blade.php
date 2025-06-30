@extends('layouts.base')

@section('pageTitle')
    {{ __('salon_register_form.page_title') }}
@endsection

@section('content')
    <div class="relative w-full overflow-x-hidden">

        {{-- Salon section --}}
        <div class="flex h-full w-full items-center justify-center">

            {{-- Image deco --}}
            <div class="relative my-0 hidden min-h-[90vh] w-1/2 py-0 xl:block"
                style="background: url(images/girl_deco_salon.jpg) center center /cover"></div>

            {{-- Formulaire --}}
            <div class="xl:px-30 gap-15 mx-auto flex w-full flex-col items-center justify-center px-2 py-3 xl:w-1/2">
                <h2 class="font-dm-serif text-center text-2xl font-bold">{{ __('salon_register_form.register_salon') }}</h2>

                {{-- Inscription Salon Formulaire --}}
                <form x-show="!escortForm" class="mx-auto flex w-full flex-col gap-3" action="{{ route('register') }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="profile_type" value="salon">

                    <div class="group relative z-0 mb-5 w-full">
                        <input type="text" name="nom_salon" id="floating_nom_salon"
                            class="dark:focus:border-green-gs focus:border-green-gs @error('nom_salon') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer block w-full appearance-none border-0 border-b-2 border-amber-300 bg-transparent px-0 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-0 dark:border-amber-600 dark:text-white"
                            placeholder=" " value="{{ old('nom_salon') }}" autocomplete="user_name" required />
                        <label for="floating_nom_salon"
                            class="peer-focus:text-green-gs peer-focus:dark:text-green-gs @error('nom_salon') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4 dark:text-gray-400">{{ __('salon_register_form.salon_name') }}
                            *</label>
                        @error('nom_salon')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('salon_register_form.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="group relative z-0 mb-5 w-full">
                        <input type="text" name="nom_proprietaire" id="floating_nom_proprietaire"
                            class="dark:focus:border-green-gs focus:border-green-gs @error('nom_proprietaire') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer block w-full appearance-none border-0 border-b-2 border-amber-300 bg-transparent px-0 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-0 dark:border-amber-600 dark:text-white"
                            placeholder=" " value="{{ old('nom_proprietaire') }}" autocomplete="user_name" required />
                        <label for="floating_nom_proprietaire"
                            class="peer-focus:text-green-gs peer-focus:dark:text-green-gs @error('nom_proprietaire') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4 dark:text-gray-400">{{ __('salon_register_form.owner_name') }}
                            *</label>
                        @error('nom_proprietaire')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('salon_register_form.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="group relative z-0 mb-5 w-full">
                        <label for="floating_intitule"
                            class="peer-focus:text-green-gs peer-focus:dark:text-green-gs @error('intitule') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4 dark:text-gray-400">{{ __('salon_register_form.title') }}
                            *</label>
                        <select name="intitule" id="floating_intitule"
                            class="dark:focus:border-green-gs focus:border-green-gs @error('intitule') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer block w-full appearance-none border-0 border-b-2 border-amber-300 bg-transparent px-2 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-0 dark:border-amber-600 dark:text-white"
                            placeholder=" " value="{{ old('intitule') }}" autocomplete="intitule" required>
                            <option>---</option>
                            <option value="madame">{{ __('salon_register_form.madame') }}</option>
                            <option value="monsieur">{{ __('salon_register_form.monsieur') }}</option>
                            <option value="mademoiselle">{{ __('salon_register_form.mademoiselle') }}</option>
                            <option value="autre">{{ __('salon_register_form.autre') }}</option>
                        </select>
                        @error('intitule')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('salon_register_form.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="group relative z-0 mb-5 w-full">
                        <input type="email" name="email" id="floating_email"
                            class="dark:focus:border-green-gs focus:border-green-gs @error('email') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer block w-full appearance-none border-0 border-b-2 border-amber-300 bg-transparent px-0 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-0 dark:border-amber-600 dark:text-white"
                            placeholder=" " value="{{ old('email') }}" autocomplete="email" required />
                        <label for="floating_email"
                            class="peer-focus:text-green-gs peer-focus:dark:text-green-gs @error('email') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4 dark:text-gray-400">{{ __('salon_register_form.email') }}
                            *</label>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('salon_register_form.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="group relative z-0 mb-5 w-full">
                        <input type="date" name="date_naissance" id="floating_date_naissance"
                            class="dark:focus:border-green-gs focus:border-green-gs @error('date_naissance') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer block w-full appearance-none border-0 border-b-2 border-amber-300 bg-transparent px-0 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-0 dark:border-amber-600 dark:text-white"
                            placeholder=" " value="{{ old('date_naissance') }}" autocomplete="date_naissance" required />
                        <label for="floating_date_naissance"
                            class="peer-focus:text-green-gs peer-focus:dark:text-green-gs @error('date_naissance') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4 dark:text-gray-400">{{ __('salon_register_form.birth_date') }}
                            *</label>
                        @error('date_naissance')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('salon_register_form.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="group relative z-0 mb-5 w-full">
                        <input type="password" name="password" id="floating_pass"
                            class="dark:focus:border-green-gs focus:border-green-gs @error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer block w-full appearance-none border-0 border-b-2 border-amber-300 bg-transparent px-0 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-0 dark:border-amber-600 dark:text-white"
                            placeholder=" " value="{{ old('password') }}" autocomplete="new-password" required />
                        <label for="floating_pass"
                            class="peer-focus:text-green-gs peer-focus:dark:text-green-gs @error('password') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4 dark:text-gray-400">{{ __('salon_register_form.password') }}
                            *</label>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('salon_register_form.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="group relative z-0 mb-5 w-full">
                        <input type="password" name="password_confirmation" id="floating_pass_conf"
                            class="dark:focus:border-green-gs focus:border-green-gs @error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer block w-full appearance-none border-0 border-b-2 border-amber-300 bg-transparent px-0 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-0 dark:border-amber-600 dark:text-white"
                            placeholder=" " value="{{ old('password') }}" autocomplete="new-password" required />
                        <label for="floating_pass_conf"
                            class="peer-focus:text-green-gs peer-focus:dark:text-green-gs @error('password') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4 dark:text-gray-400">{{ __('salon_register_form.confirm_password') }}
                            *</label>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('salon_register_form.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="font-dm-serif font-bold">{{ __('salon_register_form.terms_conditions') }} <br>
                        {{ __('salon_register_form.see_terms') }} <a class="text-green-gs"
                            href="{{ route('static.page' ,'cgv') }}">{{ __('salon_register_form.terms_conditions_link') }}</a>
                    </div>

                    <div class="mb-5 flex items-start">
                        <div class="flex h-5 items-center">
                            <input id="cgu_accepted" type="checkbox" name="cgu_accepted"
                                class="focus:ring-3 focus:ring-green-gs dark:focus:ring-green-gs h-4 w-4 rounded-sm border border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800"
                                autocomplete="cgu_accepted" {{ old('cgu_accepted') ? 'checked' : '' }} required />
                        </div>
                        <label for="cgu_accepted"
                            class="@error('cgu_accepted') text-red-300 dark:text-red-500 @enderror ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('salon_register_form.accept_terms') }}</label>
                    </div>

                    <button type="submit"
                        class="rounded-lg bg-amber-500 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-300 dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-600">{{ __('salon_register_form.register') }}</button>
                </form>

            </div>

        </div>

    </div>
@endsection

@section('extraScripts')
@endsection
