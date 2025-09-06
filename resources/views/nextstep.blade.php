@extends('layouts.base')
@section('pageTitle', __('nextStep.page_title'))
@section('content')
    <div class="relative flex h-[50vh] w-full items-center justify-center bg-cover bg-center">
        <div id="background" class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000"
            style="background-image: url('../images/girl_deco_image.jpg'); opacity: 1;"></div>
        <div class="from-supaGirlRose to-green-gs absolute inset-0 bg-gradient-to-r opacity-60"></div>
        <h1
            class="font-roboto-slab animate-fade-in-down relative z-10 px-4 text-center text-4xl font-bold text-white sm:text-5xl md:text-6xl">
            {{ __('nextStep.title') }}
        </h1>
    </div>
    <div class="container relative -top-60 mx-auto mt-10 flex flex-wrap justify-around px-5 xl:-top-32">
        <!-- Card for Professionals -->
        <div
            class="animate-slide-in-left my-10 w-[80%] transform rounded-lg bg-white p-6 shadow-lg transition duration-500 hover:scale-105 lg:w-[46%]">
            <h1 class="text-green-gs animate-fade-in mb-4 text-2xl font-bold">{{ __('nextStep.title_2') }}</h1>
            <ul class="mb-6 space-y-3">
                <li class="animate-fade-in flex transform items-center transition duration-300 hover:translate-x-2">
                    <div
                        class="bg-supaGirlRosePastel mr-3 flex h-10 min-h-[2.5rem] w-10 min-w-[2.5rem] items-center justify-center rounded-full">
                        <i class="fas fa-crown text-green-gs text-sm"></i>
                    </div>
                    <p class="flex-1">{{ __('nextStep.title_3') }}</p>
                </li>
                <li class="animate-fade-in flex transform items-center transition duration-300 hover:translate-x-2">
                    <div
                        class="bg-supaGirlRosePastel mr-3 flex h-10 min-h-[2.5rem] w-10 min-w-[2.5rem] items-center justify-center rounded-full">
                        <i class="fas fa-lock text-green-gs text-sm"></i>
                    </div>
                    <p class="flex-1">{{ __('nextStep.title_4') }}</p>
                </li>
                <li class="animate-fade-in flex transform items-center transition duration-300 hover:translate-x-2">
                    <div
                        class="bg-supaGirlRosePastel mr-3 flex h-10 min-h-[2.5rem] w-10 min-w-[2.5rem] items-center justify-center rounded-full">
                        <i class="fas fa-money-bill-wave text-green-gs text-sm"></i>
                    </div>
                    <p class="flex-1">{{ __('nextStep.title_5') }}</p>
                </li>
            </ul>
            <div class="flex flex-wrap items-center justify-around">
                <a href="{{ route('escort_register') }}"
                    class="text-green-gs hover:text-green-gs border-green-gs font-roboto-slab hover:bg-supaGirlRosePastel hover:text-green-gs my-2 block w-full transform animate-pulse rounded border p-3 text-center transition duration-300 hover:scale-105 sm:w-[45%]">
                    {{ __('login_form.register_escort') }}
                </a>
                <a href="{{ route('salon_register') }}"
                    class="text-green-gs hover:text-green-gs border-green-gs font-roboto-slab hover:bg-supaGirlRosePastel hover:text-green-gs my-2 block w-full transform animate-pulse rounded border p-3 text-center transition duration-300 hover:scale-105 sm:w-[45%]">
                    {{ __('login_form.register_professional') }}
                </a>
            </div>
        </div>
        <!-- Card for Men -->
        <div
            class="animate-slide-in-right my-10 w-[80%] transform rounded-lg bg-white p-6 shadow-lg transition duration-500 hover:scale-105 lg:w-[45%]">
            <h1 class="text-green-gs animate-fade-in mb-4 text-2xl font-bold">{{ __('nextStep.title_7') }}</h1>
            <ul class="mb-6 space-y-3">
                <li class="animate-fade-in flex transform items-center transition duration-300 hover:translate-x-2">
                    <div
                        class="bg-supaGirlRosePastel mr-3 flex h-10 min-h-[2.5rem] w-10 min-w-[2.5rem] items-center justify-center rounded-full">
                        <i class="fas fa-user-plus text-green-gs text-sm"></i>
                    </div>
                    <p class="flex-1">{{ __('nextStep.title_8') }}</p>
                </li>
                <li class="animate-fade-in flex transform items-center transition duration-300 hover:translate-x-2">
                    <div
                        class="bg-supaGirlRosePastel mr-3 flex h-10 min-h-[2.5rem] w-10 min-w-[2.5rem] items-center justify-center rounded-full">
                        <i class="fas fa-heart text-green-gs text-sm"></i>
                    </div>
                    <p class="flex-1">{{ __('nextStep.title_9') }}</p>
                </li>
                <li class="animate-fade-in flex transform items-center transition duration-300 hover:translate-x-2">
                    <div
                        class="bg-supaGirlRosePastel mr-3 flex h-10 min-h-[2.5rem] w-10 min-w-[2.5rem] items-center justify-center rounded-full">
                        <i class="fas fa-comment text-green-gs text-sm"></i>
                    </div>
                    <p class="flex-1">{{ __('nextStep.title_10') }}</p>
                </li>
            </ul>
            <div class="flex flex-wrap items-center justify-around">
                <a href="{{ route('registerForm') }}"
                    class="text-green-gs hover:text-green-gs border-green-gs font-roboto-slab hover:bg-supaGirlRosePastel hover:text-green-gs block w-full transform animate-pulse rounded border p-3 text-center transition duration-300 hover:scale-105 sm:w-[45%]">
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
