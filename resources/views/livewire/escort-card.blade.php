@php
    $user = App\Models\User::find($escortId);
@endphp
<div class="relative mx-auto mb-2 flex h-full min-h-[405px] w-full min-w-[270px] max-w-[330px] flex-col justify-start rounded-lg border border-gray-200 bg-white p-1 shadow-sm dark:border-gray-700 dark:bg-gray-800"
    style="scroll-snap-align: center">
    <div
        class="text-green-gs absolute right-0 top-0 m-2 flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-white shadow-lg">
        <livewire:favorite-button :userId=$escortId wire:key='{{ $escortId }}' />
    </div>

    <a class="m-auto h-full w-full overflow-hidden rounded-lg"
        @if ($user->profile_type == 'escorte') href="{{ route('show_escort', $escortId) }}" @else href="{{ route('show_salon', $escortId) }}" @endif>
        <img class="h-[405px] w-full rounded-t-lg object-cover"
            @if ($avatar) src="{{ asset('storage/avatars/' . $avatar) }}" @else src="{{ asset('images/icon_logo.png') }}" @endif
            alt="image profile" />
    </a>
    <div class="mt-4 flex flex-col gap-2">
        <a class="flex items-center gap-1"
            @if ($user->profile_type == 'escorte') href="{{ route('show_escort', $escortId) }}" @else href="{{ route('show_salon', $escortId) }}" @endif>
            @if ($profileVerifie  === 'verifier')
                            <div class="relative group flex items-center justify-center">
                            <!-- Icône SVG stylisée 
                            <svg width="25px" height="25px" viewBox="0 0 48 48" enable-background="new 0 0 48 48" id="_x3C_Layer_x3E_" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="tick_x2C__check_mark"> <circle cx="24" cy="24" fill="#FFF8FB" r="21.5"></circle> <path d="M24,46C11.869,46,2,36.131,2,24S11.869,2,24,2c6.219,0,12.175,2.65,16.342,7.271 c0.186,0.205,0.169,0.521-0.036,0.706c-0.206,0.185-0.522,0.168-0.706-0.036C35.622,5.53,29.937,3,24,3C12.421,3,3,12.42,3,24 s9.421,21,21,21s21-9.42,21-21c0-2.299-0.369-4.56-1.098-6.72c-0.089-0.262,0.052-0.545,0.313-0.633 c0.268-0.088,0.546,0.052,0.634,0.314C45.613,19.224,46,21.592,46,24C46,36.131,36.131,46,24,46z" fill="#7F55B1"></path> <path d="M24,45C12.421,45,3,35.58,3,24S12.421,3,24,3c5.834,0,11.454,2.458,15.419,6.743 c0.188,0.203,0.175,0.519-0.027,0.707c-0.203,0.187-0.52,0.176-0.707-0.028C34.909,6.341,29.557,4,24,4C12.972,4,4,12.972,4,24 s8.972,20,20,20s20-8.972,20-20c0-2.03-0.303-4.031-0.899-5.948c-0.082-0.264,0.065-0.544,0.329-0.626 c0.263-0.08,0.545,0.066,0.626,0.329C44.683,19.768,45,21.869,45,24C45,35.58,35.579,45,24,45z" fill="#FFFFFF"></path> <g> <g> <path d="M21.584,33.834c0.892,0.888,2.438,0.888,3.331,0l19.387-19.309c0.931-0.926,0.931-2.433,0-3.359 c-0.892-0.888-2.438-0.888-3.33,0L24.007,28.061c-0.399,0.398-1.116,0.398-1.516,0l-6.463-6.436 c-0.446-0.444-1.037-0.688-1.665-0.688s-1.22,0.244-1.665,0.688c-0.931,0.926-0.931,2.433,0,3.359L21.584,33.834z" fill="#03ba31"></path> <path d="M23.249,35.005c-0.735,0-1.471-0.272-2.018-0.817v0l-8.886-8.85c-0.545-0.542-0.846-1.265-0.846-2.035 c0-0.769,0.301-1.491,0.846-2.033c1.077-1.074,2.954-1.076,4.035,0l6.463,6.436c0.205,0.204,0.606,0.205,0.81,0l16.966-16.896 c1.094-1.089,2.941-1.089,4.035,0c0.545,0.542,0.846,1.265,0.846,2.034c0,0.769-0.301,1.491-0.846,2.033L25.268,34.188 C24.721,34.733,23.984,35.005,23.249,35.005z M14.363,21.437c-0.495,0-0.961,0.193-1.312,0.542 c-0.355,0.354-0.552,0.824-0.552,1.325s0.195,0.972,0.551,1.325l8.886,8.851c0.699,0.695,1.927,0.696,2.626,0L43.949,14.17 c0.354-0.353,0.551-0.824,0.551-1.325s-0.195-0.972-0.551-1.325c-0.699-0.696-1.926-0.697-2.625,0L24.359,28.416 c-0.59,0.59-1.63,0.59-2.222,0l-6.462-6.436C15.324,21.629,14.858,21.437,14.363,21.437z" fill="#7F55B1"></path> </g> <path d="M13,23.804c-0.276,0-0.5-0.224-0.5-0.5c0-0.5,0.196-0.971,0.552-1.325c0.351-0.35,0.816-0.542,1.312-0.542 c0.276,0,0.5,0.224,0.5,0.5s-0.224,0.5-0.5,0.5c-0.229,0-0.443,0.089-0.606,0.25c-0.165,0.166-0.257,0.385-0.257,0.617 C13.5,23.581,13.276,23.804,13,23.804z" fill="#FFFFFF"></path> <path d="M26.161,27.828c-0.128,0-0.257-0.049-0.354-0.147c-0.194-0.196-0.194-0.512,0.002-0.708l14.07-14.013 c0.195-0.194,0.512-0.195,0.707,0.001c0.194,0.196,0.194,0.512-0.002,0.708l-14.07,14.013 C26.416,27.779,26.289,27.828,26.161,27.828z" fill="#FFFFFF"></path> </g> </g> </g></svg>Tooltip -->

                            <svg fill="#000000" width="30px" height="30px" viewBox="0 0 24 24" id="check-mark-circle" data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><rect id="secondary" x="3" y="3" width="18" height="18" rx="9" style="fill: #f9cdf3; stroke-width: 2;"></rect><polyline id="primary" points="8 11.5 11 14.5 16 9.5" style="fill: none; stroke: #146c33; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></polyline><rect id="primary-2" data-name="primary" x="3" y="3" width="18" height="18" rx="9" style="fill: none; stroke: #146c33; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></rect></g></svg>
                            <div class="absolute bottom-full mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                {{ __('profile.profile_verifie') }}
                                
                            </div>
                            </div>
                        @endif
            <h5 class="text-base tracking-tight text-gray-900 dark:text-white">{{ ucfirst($name) }}</h5>

            <div class="{{ $isOnline ? 'bg-green-gs' : 'bg-gray-400' }} h-2 w-2 rounded-full"></div>
        </a>
        <p class="font-normal text-gray-700 dark:text-gray-400">
            <span>{{ $canton }}</span>
            @if ($ville != '')
                <span> | {{ $ville }}</span>
            @endif
        </p>
        @if ($distance > 0)

            <div
                class="text-green-gs absolute left-0 top-0 m-2 flex cursor-pointer items-center justify-center rounded-sm bg-white px-2 py-1 font-bold shadow-lg">
                @if ($distance < 1)
                    {{ round($distance * 1000) }} m
                @else
                    {{ round($distance) }} km
                @endif
            </div>
        @endif



    </div>
</div>
