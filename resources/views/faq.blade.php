@extends('layouts.base')

@section('pageTitle')
    {{ __('faq.title') }}
@endsection

@section('content')

    <div class="bg-green-gs/30 flex min-h-60 items-center justify-center py-20">
        <h2 class="font-dm-serif text-green-gs text-center text-3xl font-bold lg:text-5xl">{{ __('faq.title') }}</h2>
    </div>
    <div class="py-15 mx-auto my-10 px-2 xl:container xl:px-60">
        <div id="accordion-collapse text-wrap" data-accordion="collapse">
            <h2 id="accordion-collapse-heading-1" class="w-full">
                <button type="button"
                    class="font-dm-serif text-green-gs hover:bg-green-gs dark:hover:bg-green-gs bg-green-gs/30 flex w-full items-center justify-between gap-3 rounded-t-xl border border-b-0 p-5 text-xl font-bold hover:text-white xl:text-2xl rtl:text-right"
                    data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
                    aria-controls="accordion-collapse-body-1">
                    <span class="flex items-center"><svg class="me-2 h-5 w-5 shrink-0" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd"></path>
                        </svg>{{ __('faq.what_is_gstuff.question') }}</span>
                    <svg data-accordion-icon class="h-3 w-3 shrink-0 rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
                <div
                    class="border border-b-0 border-gray-200 bg-white p-5 text-sm xl:text-base dark:border-gray-700 dark:bg-gray-900">
                    <p class="mb-2 whitespace-pre-line">{{ __('faq.what_is_gstuff.answer') }}</p>
                </div>
            </div>
            <h2 id="accordion-collapse-heading-2" class="w-full">
                <button type="button"
                    class="font-dm-serif text-green-gs hover:bg-green-gs dark:hover:bg-green-gs bg-green-gs/30 flex w-full items-center justify-between gap-3 border border-b-0 p-5 text-xl font-bold hover:text-white xl:text-2xl rtl:text-right"
                    data-accordion-target="#accordion-collapse-body-2" aria-expanded="false"
                    aria-controls="accordion-collapse-body-2">
                    <span class="flex items-center"><svg class="me-2 h-5 w-5 shrink-0" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd"></path>
                        </svg>{{ __('faq.advantages.question') }}</span>
                    <svg data-accordion-icon class="h-3 w-3 shrink-0 rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
                <div
                    class="border border-b-0 border-gray-200 bg-white p-5 text-base text-sm dark:border-gray-700 dark:bg-gray-900">
                    <ul class="mb-2">
                        @foreach (__('faq.advantages.items') as $item)
                            <li>• {{ $item }}</li>
                        @endforeach
                    </ul>
                    <p class="mt-2">{{ __('faq.advantages.summary') }}</p>
                </div>
            </div>
            <h2 id="accordion-collapse-heading-3" class="w-full">
                <button type="button"
                    class="font-dm-serif text-green-gs hover:bg-green-gs dark:hover:bg-green-gs bg-green-gs/30 flex w-full items-center justify-between gap-3 border border-b-0 p-5 text-xl font-bold hover:text-white xl:text-2xl rtl:text-right"
                    data-accordion-target="#accordion-collapse-body-3" aria-expanded="false"
                    aria-controls="accordion-collapse-body-3">
                    <span class="flex items-center"><svg class="me-2 h-5 w-5 shrink-0" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd"></path>
                        </svg>{{ __('faq.requirements.question') }}</span>
                    <svg data-accordion-icon class="h-3 w-3 shrink-0 rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-2">
                <div
                    class="flex flex-col gap-2 border border-b-0 border-gray-200 bg-white p-5 text-sm xl:text-base dark:border-gray-700 dark:bg-gray-900">
                    <p class="mb-2"><strong>{{ __('faq.requirements.age') }}</strong></p>
                    <p class="mb-2">{{ __('faq.requirements.age_text') }}</p>
                    <p class="mb-4">{{ __('faq.requirements.age_note') }}</p>

                    <p class="mb-2"><strong>{{ __('faq.requirements.work_in_switzerland') }}</strong></p>
                    <p class="mb-4">{{ __('faq.requirements.work_in_switzerland_text') }}</p>

                    <p class="mb-2"><strong>{{ __('faq.requirements.phone_requirement') }}</strong></p>
                    <p class="mb-4">{{ __('faq.requirements.phone_requirement_text') }}</p>
                </div>
            </div>
            <h2 id="accordion-collapse-heading-4" class="w-full">
                <button type="button"
                    class="font-dm-serif text-green-gs hover:bg-green-gs dark:hover:bg-green-gs bg-green-gs/30 flex w-full items-center justify-between gap-3 border border-b-0 p-5 text-xl font-bold hover:text-white xl:text-2xl rtl:text-right"
                    data-accordion-target="#accordion-collapse-body-4" aria-expanded="false"
                    aria-controls="accordion-collapse-body-4">
                    <span class="flex items-center"><svg class="me-2 h-5 w-5 shrink-0" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd"></path>
                        </svg>{{ __('faq.payment_methods.question') }}</span>
                    <svg data-accordion-icon class="h-3 w-3 shrink-0 rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-4" class="hidden" aria-labelledby="accordion-collapse-heading-2">
                <div
                    class="flex flex-col gap-2 border border-b-0 border-gray-200 bg-white p-5 text-sm xl:text-base dark:border-gray-700 dark:bg-gray-900">
                    <p class="mb-2">{{ __('faq.payment_methods.question') }}</p>
                    <ul class="mb-2">
                        @foreach (__('faq.payment_methods.methods') as $method)
                            <li>• {{ $method }}</li>
                        @endforeach
                    </ul>
                    <p class="mt-2">{{ __('faq.payment_methods.contact') }} <a href="mailto:support@gstuff.ch"
                            class="text-blue-600 hover:underline">support@gstuff.ch</a>.
                        {{ __('faq.payment_methods.solution') }}</p>
                </div>
            </div>
            <h2 id="accordion-collapse-heading-5" class="w-full">
                <button type="button"
                    class="font-dm-serif text-green-gs hover:bg-green-gs dark:hover:bg-green-gs bg-green-gs/30 flex w-full items-center justify-between gap-3 border border-b-0 p-5 text-xl font-bold hover:text-white xl:text-2xl rtl:text-right"
                    data-accordion-target="#accordion-collapse-body-5" aria-expanded="false"
                    aria-controls="accordion-collapse-body-5">
                    <span class="flex items-center"><svg class="me-2 h-5 w-5 shrink-0" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd"></path>
                        </svg>{{ __('faq.deactivate_profile.question') }}</span>
                    <svg data-accordion-icon class="h-3 w-3 shrink-0 rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-5" class="hidden" aria-labelledby="accordion-collapse-heading-2">
                <div
                    class="flex flex-col gap-2 border border-b-0 border-gray-200 bg-white p-5 text-sm xl:text-base dark:border-gray-700 dark:bg-gray-900">
                    <p>{{ __('faq.deactivate_profile.text1') }}</p>
                    <p>{{ __('faq.deactivate_profile.why_pay') }}</p>
                    <p class="font-bold">{{ __('faq.deactivate_profile.departure') }}</p>
                    <p>{{ __('faq.deactivate_profile.departure_instructions') }}</p>
                    <p class="font-bold">{{ __('faq.deactivate_profile.return') }}</p>
                    <p>{{ __('faq.deactivate_profile.return_instructions') }}</p>
                </div>
            </div>
            <h2 id="accordion-collapse-heading-6" class="w-full">
                <button type="button"
                    class="font-dm-serif text-green-gs hover:bg-green-gs dark:hover:bg-green-gs bg-green-gs/30 flex w-full items-center justify-between gap-3 border border-b-0 p-5 text-xl font-bold hover:text-white xl:text-2xl rtl:text-right"
                    data-accordion-target="#accordion-collapse-body-6" aria-expanded="false"
                    aria-controls="accordion-collapse-body-6">
                    <span class="flex items-center"><svg class="me-2 h-5 w-5 shrink-0" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd"></path>
                        </svg>{{ __('faq.help.question') }}</span>
                    <svg data-accordion-icon class="h-3 w-3 shrink-0 rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-6" class="hidden border-b border-gray-300"
                aria-labelledby="accordion-collapse-heading-2">
                <div
                    class="flex flex-col gap-2 border border-b-0 border-gray-200 bg-white p-5 text-sm xl:text-base dark:border-gray-700 dark:bg-gray-900">
                    <p>{{ __('faq.help.intro') }}</p>
                    <p>{{ __('faq.help.police_info') }}</p>
                    <p>{{ __('faq.help.phone_note') }}</p>
                    <p>{{ __('faq.help.phone_example') }} <a href="tel:+41791234567"
                            class="text-blue-600 hover:underline">+41 79 123 45 67</a></p>
                    <p>{{ __('faq.help.romandie_note') }}</p>
                    <p><b>{{ __('faq.organizations.social_support') }}</b><br>
                        {{ __('faq.organizations.aspasie') }} – <a href="https://www.apasie.ch"
                            target="_blank">www.apasie.ch</a></p>
                    <p>{{ __('faq.organizations.astree') }} – <a href="https://www.astree.ch"
                            target="_blank">www.astree.ch</a></p>
                    <p>{{ __('faq.organizations.procore') }} – <a href="https://procore-info.ch"
                            target="_blank">procore-info.ch</a></p>
                    <p>{{ __('faq.organizations.tandem') }} – <a href="https://www.tandem91.org"
                            target="_blank">www.tandem91.org</a></p>
                    <p>{{ __('faq.organizations.point_appui') }} – <a href="https://www.eglisemigrationvd.com"
                            target="_blank">www.eglisemigrationvd.com</a></p>
                    <p>{{ __('faq.organizations.lavi') }} – <a href="tel:0216310300">021 631 03 00</a></p>
                    <p>{{ __('faq.organizations.appartenances') }} – <a href="https://www.appartenances.ch"
                            target="_blank">www.appartenances.ch</a></p>
                    <p>{{ __('faq.organizations.abs') }} – <a href="https://www.fondationabs.ch"
                            target="_blank">www.fondationabs.ch</a></p>
                    <p>{{ __('faq.organizations.caritas') }} – <a href="https://www.caritas-vaud.ch"
                            target="_blank">www.caritas-vaud.ch</a> – <a href="tel:0216220622">021 622 06 22</a></p>
                    <p>{{ __('faq.organizations.point_eau') }} – <a href="https://www.pointdeau-lausanne.ch"
                            target="_blank">www.pointdeau-lausanne.ch</a></p>
                    <p>{{ __('faq.organizations.appartenances_femmes') }} – <a href="https://www.appartenances.ch"
                            target="_blank">www.appartenances.ch</a> – <a href="tel:0213512880">021 351 28 80</a></p>
                    <p>{{ __('faq.organizations.bourse_travail') }} – <a href="https://www.labourseatravail.ch"
                            target="_blank">www.labourseatravail.ch</a></p>

                    <p><b>{{ __('faq.organizations.legal_services') }}</b></p>
                    <p>{{ __('faq.organizations.cedre') }}</p>
                    <p>{{ __('faq.organizations.saje') }} – <a href="tel:0213512551">021 351 25 51</a></p>
                    <p>{{ __('faq.organizations.csp') }} – <a href="https://www.csp.ch" target="_blank">www.csp.ch</a>
                    </p>

                    <p><b>{{ __('faq.organizations.medical_services') }}</b><br>
                        {{ __('faq.organizations.chuv') }} – <a href="tel:0213141111">021 314 11 11</a><br>
                        {{ __('faq.organizations.maternity') }} – <a href="tel:0213143518">021 314 35 18</a><br>
                        {{ __('faq.organizations.emergency_maternity') }} – <a href="tel:0213143410">021 314 34 10</a><br>
                        {{ __('faq.organizations.gynecology') }} – <a href="tel:0213143245">021 314 32 45</a></p>

                    <p>{{ __('faq.organizations.pmu') }} – <a href="https://www.pmu-lausanne.ch"
                            target="_blank">www.pmu-lausanne.ch</a> – <a href="tel:0213146060">021 314 60 60</a><br>
                        {{ __('faq.organizations.hiv_std_tests') }} – <a href="tel:0213144917">021 314 49 17</a><br>
                        {{ __('faq.organizations.flon_office') }} – <a href="tel:0213149090">021 314 90 90</a></p>

                    <p>{{ __('faq.organizations.profa') }} – <a href="https://www.profa.ch"
                            target="_blank">www.profa.ch</a></p>
                    <p>{{ __('faq.organizations.aids_support') }} – <a href="https://www.aids.ch"
                            target="_blank">www.aids.ch</a></p>

                </div>
            </div>
        </div>

    </div>

    <x-CallToActionContact />

@stop
