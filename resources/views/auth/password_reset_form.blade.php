@extends('layouts.base')

@php use Carbon\Carbon; @endphp

@section('pageTitle', __('auth.password.reset_password'))

@section('content')
    <div>
        @if ($errors->any())
            <div class="absolute left-0 right-0 top-24 z-50 mb-4 border-l-4 border-red-500 bg-red-50 p-4 text-red-700"
                role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg class="mr-2 h-5 w-5 fill-current text-red-500" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path
                                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.83-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 5h2v6H9V5zm0 8h2v2H9v-2z" />
                        </svg>
                    </div>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ is_string($error) ? $error : json_encode($error) }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div
            class="flex min-h-screen items-center justify-center bg-gradient-to-r from-amber-50 to-gray-50 px-4 py-12 sm:px-6 lg:px-8">
            <div class="w-full max-w-lg space-y-6 rounded-xl bg-white p-8 shadow-lg">
                <div class="text-center">
                    <h2 class="font-roboto-slab text-green-gs text-3xl">
                        {{ __('auth.password.reset_password') }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ __('auth.password.reset_password_instructions') }}
                    </p>
                </div>
                <form class="mt-8 space-y-6" action="{{ route('password.reset') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ is_string($token) ? $token : '' }}">


                    <div class="space-y-4 rounded-md shadow-sm">
                        <div>
                            <label for="email"
                                class="font-roboto-slab text-green-gs block text-sm">{{ __('auth.password.email') }}</label>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="focus:ring-green-gs focus:border-green-gs mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:outline-none sm:text-sm"
                                placeholder="{{ __('auth.password.email') }}">
                        </div>
                        <div>
                            <label for="password"
                                class="font-roboto-slab text-green-gs block text-sm">{{ __('auth.password.password') }}</label>
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                class="focus:ring-green-gs focus:border-green-gs mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:outline-none sm:text-sm"
                                placeholder="{{ __('auth.password.password') }}">
                        </div>
                        <div>
                            <label for="password_confirmation"
                                class="font-roboto-slab text-green-gs block text-sm">{{ __('auth.password.confirm_password') }}</label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                autocomplete="new-password" required
                                class="focus:ring-green-gs focus:border-green-gs mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:outline-none sm:text-sm"
                                placeholder="{{ __('auth.password.confirm_password') }}">
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="font-roboto-slab bg-green-gs hover:bg-green-gs/80 focus:ring-green-gs flex w-full cursor-pointer justify-center rounded-md border border-transparent px-4 py-2 text-sm text-white shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2">
                            {{ __('auth.password.reset_password_button') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
