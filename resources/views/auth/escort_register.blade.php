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
            <div class="xl:px-30 gap-15 mx-auto flex w-full flex-col items-center justify-center px-2 py-3 xl:w-1/2">
                <h2 class="font-roboto-slab text-center text-2xl font-bold text-green-gs">{{ __('escort_register_form.register_escort') }}
                </h2>

                {{-- Inscription Escort Formulaire --}}
                <form class="mx-auto flex w-full flex-col gap-5" action="{{ route('register') }}" method="POST">
                    @csrf
                    <input type="hidden" name="profile_type" value="escorte">

                    <div class="group relative z-0 mb-5 w-full">
                        <input type="text" name="prenom" id="floating_name"
                            class="font-roboto-slab focus:border-supaGirlRose @error('prenom') border-red-500 @enderror peer block w-full appearance-none border-0 border-b-2 border-green-gs bg-transparent px-0 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-0 "
                            placeholder=" " value="{{ old('prenom') }}" autocomplete="prenom" required />
                        <label for="floating_name"
                            class="peer-focus:text-green-gs  @error('prenom') text-red-700 peer-focus:text-red-700 @enderror absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-green-gs duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4">{{ __('escort_register_form.first_name') }}
                            *</label>
                        @error('prenom')
                            <p class="mt-2 text-sm text-red-600  "><span
                                    class="font-medium">{{ __('escort_register_form.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="group relative z-0 mb-5 w-full">
                        <label for="floating_genre"
                            class="peer-focus:text-green-gs font-roboto-slab @error('genre_id') text-red-700 peer-focus:text-red-700 @enderror absolute top-3
                             -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-green-gs duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4 border-green-gs">{{ __('escort_register_form.genre') }}
                            *</label>
                        <select name="genre_id" id="floating_genre"
                            class="font-roboto-slab   focus:border-supaGirlRose border-green-gs @error('genre_id') border-red-500 @enderror
                             peer block w-full appearance-none border-0 border-b-2 border-green-gs bg-transparent px-2 py-2.5 text-sm text-green-gs focus:outline-none focus:ring-0 "
                            placeholder=" " value="{{ old('genre_id') }}" autocomplete="genre_id" required>
                            <option>---</option>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->id }}">
                                    {{ $genre->getTranslation('name', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                        @error('genre')
                            <p class="mt-2 text-sm text-red-600"><span
                                    class="font-medium">{{ __('escort_register_form.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="group relative z-0 mb-5 w-full">
                        <input type="email" name="email" id="floating_email"
                            class=" focus:border-supaGirlRose @error('email') border-red-500  focus:border-red-500 @enderror peer block w-full appearance-none border-0 border-b-2 border-green-gs bg-transparent px-0 py-2.5 text-sm text-textColor focus:outline-none focus:ring-0"
                            placeholder=" " value="{{ old('email') }}" autocomplete="email" required />
                        <label for="floating_email"
                            class="peer-focus:text-green-gs @error('email') text-red-700 peer-focus:text-red-700 @enderror absolute top-3 
                            -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-textColor duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4">{{ __('escort_register_form.email') }}
                            *</label>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600"><span
                                    class="font-medium">{{ __('escort_register_form.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="group relative z-0 mb-5 w-full">
                        <input type="date" name="date_naissance" id="floating_date_naissance"
                            class=" focus:border-supaGirlRose font-roboto-slab @error('date_naissance') border-red-500  focus:border-red-500 @enderror peer block w-full appearance-none border-0 border-b-2 border-green-gs bg-transparent px-0 py-2.5 text-sm text-textColor focus:outline-none focus:ring-0"
                            placeholder=" " value="{{ old('date_naissance') }}" autocomplete="date_naissance" required />
                        <label for="floating_date_naissance"
                            class="peer-focus:text-green-gs @error('date_naissance') text-red-700 peer-focus:text-red-700 @enderror absolute top-3 
                            -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-textColor duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4">{{ __('escort_register_form.birth_date') }}
                            *</label>
                        @error('date_naissance')
                            <p class="mt-2 text-sm text-red-600  "><span
                                    class="font-medium">{{ __('escort_register_form.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="group relative z-0 mb-5 w-full">
                        <input type="password" name="password" id="floating_pass"
                            class=" focus:border-supaGirlRose @error('password') border-red-500   focus:border-red-500 @enderror peer block w-full appearance-none border-0 border-b-2 border-green-gs bg-transparent px-0 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-0 "
                            placeholder=" " value="{{ old('password') }}" autocomplete="new-password" required />
                        <label for="floating_pass"
                            class="peer-focus:text-green-gs @error('password') text-red-700   peer-focus:text-red-700 peer-focus:  @enderror absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4  ">{{ __('escort_register_form.password') }}
                            *</label>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600  "><span
                                    class="font-medium">{{ __('escort_register_form.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="group relative z-0 mb-5 w-full">
                        <input type="password" name="password_confirmation" id="floating_pass_conf"
                            class=" focus:border-supaGirlRose @error('password') border-red-500   focus:border-red-500 @enderror peer block w-full appearance-none border-0 border-b-2 border-green-gs bg-transparent px-0 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-0 "
                            placeholder=" " value="{{ old('password') }}" autocomplete="new-password" required />
                        <label for="floating_pass_conf"
                            class="peer-focus:text-green-gs  @error('password') text-red-700 peer-focus:text-red-700 @enderror absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-gray-500 duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4  ">{{ __('escort_register_form.confirm_password') }}
                            *</label>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600"><span
                                    class="font-medium">{{ __('escort_register_form.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="font-roboto-slab text-sm ">{{ __('escort_register_form.terms_conditions') }} <br>
                        {{ __('escort_register_form.see_terms') }} <a class="font-roboto-slab text-green-gs text-sm"
                            href="{{ route('static.page' , 'cgv') }}">{{ __('escort_register_form.terms_conditions_link') }}</a>
                    </div>

                    <div class="mb-5 flex items-start">
                        <div class="flex h-5 items-center">
                            <input id="cgu_accepted" type="checkbox" name="cgu_accepted"
                                class="focus:ring-3 focus:ring-green-gs  h-4 w-4 rounded-sm border border-gray-300 bg-gray-50 "
                                autocomplete="cgu_accepted" {{ old('cgu_accepted') ? 'checked' : '' }} required />
                        </div>
                        <label for="cgu_accepted"
                            class="@error('cgu_accepted') text-red-300  @enderror ms-2 text-sm font-medium text-textColorParagraph font-roboto-slab   ">{{ __('escort_register_form.accept_terms') }}</label>
                    </div>

                    <button type="submit"
                        class="rounded-lg bg-green-gs px-5 py-2.5 text-center text-sm font-medium text-white font-roboto-slab hover:bg-supaGirlRose hover:text-green-gs focus:outline-none focus:ring-4 focus:ring-green-gs  ">{{ __('escort_register_form.register') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('extraScripts')
@endsection
