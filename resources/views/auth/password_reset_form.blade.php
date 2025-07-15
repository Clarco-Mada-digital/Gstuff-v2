@extends('layouts.base')

@php use Carbon\Carbon; @endphp

@section('pageTitle', __('auth.reset_password'))

@section('content')
<div>
@if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-4 absolute top-24 left-0 right-0 z-50" role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <svg class="fill-current h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.83-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 5h2v6H9V5zm0 8h2v2H9v-2z"/>
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

<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-amber-50 to-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg space-y-6">
        <div class="text-center">
            <h2 class="text-3xl font-roboto-slab text-green-gs">
                {{ is_string(__('auth.reset_password')) ? __('auth.reset_password') : 'Reset Password' }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('auth.reset_password_instructions') }}
            </p>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('password.reset') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ is_string($token) ? $token : '' }}">

           
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="email" class="block text-sm font-roboto-slab text-green-gs">{{ is_string(__('auth.email')) ? __('auth.email') : 'Email' }}</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-gs focus:border-green-gs sm:text-sm"
                           placeholder="{{ is_string(__('auth.email')) ? __('auth.email') : 'Email' }}">
                </div>
                <div>
                    <label for="password" class="block text-sm font-roboto-slab text-green-gs">{{ is_string(__('auth.password')) ? __('auth.password') : 'Password' }}</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-gs focus:border-green-gs sm:text-sm"
                           placeholder="{{ is_string(__('auth.password')) ? __('auth.password') : 'Password' }}">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-roboto-slab text-green-gs">{{ is_string(__('auth.confirm_password')) ? __('auth.confirm_password') : 'Confirm Password' }}</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-gs focus:border-green-gs sm:text-sm"
                           placeholder="{{ is_string(__('auth.confirm_password')) ? __('auth.confirm_password') : 'Confirm Password' }}">
                </div>
            </div>

            <div>
                <button type="submit"
                        class=" cursor-pointer w-full flex justify-center py-2 px-4 border border-transparent rounded-md
                         shadow-sm text-sm font-roboto-slab text-white bg-green-gs hover:bg-green-gs/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-gs transition duration-150 ease-in-out">
                    {{ is_string(__('auth.reset_password')) ? __('auth.reset_password') : 'Reset Password' }}
                </button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
