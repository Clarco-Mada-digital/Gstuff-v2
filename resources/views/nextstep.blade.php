@extends('layouts.base')
@section('pageTitle', __('nextstep.page_title'))
@section('content')
    <div class="relative flex h-[50vh] w-full items-center justify-center bg-cover bg-center">
        <div id="background" class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000"
             style="background-image: url('../images/girl_deco_image.jpg'); opacity: 1;"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-supaGirlRose to-green-gs opacity-60"></div>
        <h1 class="relative z-10 font-roboto-slab px-4 text-center text-4xl font-bold text-white sm:text-5xl md:text-6xl animate-fade-in-down">
            {{ __('nextStep.title') }}
        </h1>
    </div>
    <div class="container mx-auto mt-10 px-5 flex flex-wrap justify-around -top-60 xl:-top-32 relative">
        <!-- Card for Professionals -->
        <div class="bg-white shadow-lg rounded-lg p-6 w-[80%] lg:w-[46%] transform transition duration-500 hover:scale-105 my-10 animate-slide-in-left">
            <h1 class="text-2xl font-bold text-green-gs mb-4 animate-fade-in">{{ __('nextStep.title_2') }}</h1>
            <ul class="space-y-3 mb-6">
                <li class="flex items-center transform transition duration-300 hover:translate-x-2 animate-fade-in">
                    <div class="flex items-center justify-center rounded-full bg-supaGirlRosePastel w-10 h-10 min-w-[2.5rem] min-h-[2.5rem] mr-3">
                        <i class="fas fa-crown text-green-gs text-sm"></i>
                    </div>
                    <p class="flex-1">{{ __('nextStep.title_3') }}</p>
                </li>
                <li class="flex items-center transform transition duration-300 hover:translate-x-2 animate-fade-in">
                    <div class="flex items-center justify-center rounded-full bg-supaGirlRosePastel w-10 h-10 min-w-[2.5rem] min-h-[2.5rem] mr-3">
                        <i class="fas fa-lock text-green-gs text-sm"></i>
                    </div>
                    <p class="flex-1">{{ __('nextStep.title_4') }}</p>
                </li>
                <li class="flex items-center transform transition duration-300 hover:translate-x-2 animate-fade-in">
                    <div class="flex items-center justify-center rounded-full bg-supaGirlRosePastel w-10 h-10 min-w-[2.5rem] min-h-[2.5rem] mr-3">
                        <i class="fas fa-money-bill-wave text-green-gs text-sm"></i>
                    </div>
                    <p class="flex-1">{{ __('nextStep.title_5') }}</p>
                </li>
            </ul>
            <div class="flex flex-wrap justify-around items-center">
                <a href="{{ route('escort_register') }}" class="block my-2 text-green-gs hover:text-green-gs w-full sm:w-[45%] border border-green-gs p-3 font-roboto-slab text-center hover:bg-supaGirlRosePastel hover:text-green-gs rounded transition duration-300 transform hover:scale-105 animate-pulse">
                    {{ __('login_form.register_escort') }}
                </a>
                <a href="{{ route('salon_register') }}" class="block my-2 text-green-gs hover:text-green-gs w-full sm:w-[45%] border border-green-gs p-3 font-roboto-slab text-center hover:bg-supaGirlRosePastel hover:text-green-gs rounded transition duration-300 transform hover:scale-105 animate-pulse">
                    {{ __('login_form.register_professional') }}
                </a>
            </div>
        </div>
        <!-- Card for Men -->
        <div class="bg-white shadow-lg rounded-lg p-6 w-[80%] lg:w-[45%] transform transition duration-500 hover:scale-105 my-10 animate-slide-in-right">
            <h1 class="text-2xl font-bold text-green-gs mb-4 animate-fade-in">{{ __('nextStep.title_7') }}</h1>
            <ul class="space-y-3 mb-6">
                <li class="flex items-center transform transition duration-300 hover:translate-x-2 animate-fade-in">
                    <div class="flex items-center justify-center rounded-full bg-supaGirlRosePastel w-10 h-10 min-w-[2.5rem] min-h-[2.5rem] mr-3">
                        <i class="fas fa-user-plus text-green-gs text-sm"></i>
                    </div>
                    <p class="flex-1">{{ __('nextStep.title_8') }}</p>
                </li>
                <li class="flex items-center transform transition duration-300 hover:translate-x-2 animate-fade-in">
                    <div class="flex items-center justify-center rounded-full bg-supaGirlRosePastel w-10 h-10 min-w-[2.5rem] min-h-[2.5rem] mr-3">
                        <i class="fas fa-heart text-green-gs text-sm"></i>
                    </div>
                    <p class="flex-1">{{ __('nextStep.title_9') }}</p>
                </li>
                <li class="flex items-center transform transition duration-300 hover:translate-x-2 animate-fade-in">
                    <div class="flex items-center justify-center rounded-full bg-supaGirlRosePastel w-10 h-10 min-w-[2.5rem] min-h-[2.5rem] mr-3">
                        <i class="fas fa-comment text-green-gs text-sm"></i>
                    </div>
                    <p class="flex-1">{{ __('nextStep.title_10') }}</p>
                </li>
            </ul>
            <div class="flex flex-wrap justify-around items-center">
                <a href="{{ route('registerForm') }}" class="block text-green-gs hover:text-green-gs w-full sm:w-[45%] border border-green-gs p-3 font-roboto-slab text-center hover:bg-supaGirlRosePastel hover:text-green-gs rounded transition duration-300 transform hover:scale-105 animate-pulse">
                    {{ __('login_form.register_free') }}
                </a>
            </div>
        </div>
    </div>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-out;
        }
        .animate-fade-in-down {
            animation: fadeInDown 1s ease-out;
        }
        .animate-slide-in-left {
            animation: slideInLeft 1s ease-out;
        }
        .animate-slide-in-right {
            animation: slideInRight 1s ease-out;
        }
        .animate-pulse {
            animation: pulse 2s infinite;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backgroundImages = [
                'url("../images/girl_deco_image.jpg")',
                'url("../images/girl_deco_sp.jpg")',
                'url("../images/girl_deco_image_001.jpg")'
            ];
            let currentIndex = 0;
            const backgroundElement = document.getElementById('background');
            function changeBackgroundImage() {
                // Fade out the current image
                backgroundElement.style.opacity = 0;
                // Change the background image after the fade-out transition completes
                setTimeout(() => {
                    currentIndex = (currentIndex + 1) % backgroundImages.length;
                    backgroundElement.style.backgroundImage = backgroundImages[currentIndex];
                    // Fade in the new image
                    backgroundElement.style.opacity = 1;
                }, 1000); // This timeout should match the CSS transition duration
            }
            // Change the background image every 5 seconds
            setInterval(changeBackgroundImage, 5000);
        });
    </script>
@stop
