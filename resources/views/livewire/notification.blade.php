<div x-data="{ userType: '{{ Auth::user()->profile_type }}' }">
    <button id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification" type="button"
        class="relative inline-flex cursor-pointer items-center rounded-full bg-gray-200 p-2 text-center text-sm font-medium focus:outline-none xl:order-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
            <path fill="currentColor"
                d="M5 19q-.425 0-.712-.288T4 18t.288-.712T5 17h1v-7q0-2.075 1.25-3.687T10.5 4.2v-.7q0-.625.438-1.062T12 2t1.063.438T13.5 3.5v.7q2 .5 3.25 2.113T18 10v7h1q.425 0 .713.288T20 18t-.288.713T19 19zm7 3q-.825 0-1.412-.587T10 20h4q0 .825-.587 1.413T12 22" />
        </svg>
        <span class="sr-only">Icon description</span>
        @if ($unreadCount > 0)
            <div
                class="start-5.5 absolute top-1 block flex h-5 w-5 items-center justify-center rounded-full border-2 border-white bg-red-500 text-sm text-white dark:border-gray-900">
                {{ $unreadCount }}</div>
        @endif
    </button>
    <!-- Dropdown menu -->
    <div id="dropdownNotification"
        class="z-20 hidden w-full max-w-sm divide-y divide-gray-100 rounded-lg bg-white shadow-sm dark:divide-gray-700 dark:bg-gray-800"
        aria-labelledby="dropdownNotificationButton">
        <div
            class="block rounded-t-lg bg-gray-50 px-4 py-2 text-center font-medium text-gray-700 dark:bg-gray-800 dark:text-white">
            {{ __('notification.notifications') }}
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-700 ">
            @forelse($unreadNotifications as $notification)
                <a wire:click="markAsRead('{{ $notification->id }}')" href="{{ $notification->data['url'] ?? '#' }}" wire:key="{{ $notification->id }}"
                    class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700"
                    >
                    <div class="shrink-0">
                        <img class="h-11 w-11 rounded-full" src="{{ asset('images/icons/user_icon.svg') }}"
                            alt="Robert image">
                        <div
                            class="absolute -mt-5 ms-6 flex h-5 w-5 items-center justify-center rounded-full border border-white bg-purple-500 dark:border-gray-800">
                            <svg class="h-2 w-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 14">
                                <path
                                    d="M11 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm8.585 1.189a.994.994 0 0 0-.9-.138l-2.965.983a1 1 0 0 0-.685.949v8a1 1 0 0 0 .675.946l2.965 1.02a1.013 1.013 0 0 0 1.032-.242A1 1 0 0 0 20 12V2a1 1 0 0 0-.415-.811Z" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="w-full ps-3" wire:click="markAsRead('{{ $notification->id }}')">
                        <div class="mb-1.5 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                            @php
                                $data = $notification->data ?? [];
                                $hasType = isset($data['type']);
                                $isProfileCompletion = $hasType && $data['type'] === 'profileCompletion';
                                $isEscortInvitation = $hasType && $data['type'] === 'escortInvitation';
                                $isProfileVerificationRequest = $hasType && $data['type'] === 'profileVerificationRequest';
                            @endphp
                            
                            @if($isProfileCompletion && isset($data['percent']))
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ __('notification.profileCompletion.title', ['percent' => $data['percent']]) }}
                                </span>
                                <span>
                                    {{ __('notification.profileCompletion.message', ['percent' => $data['percent']]) }}
                                </span>
                            @elseif($isEscortInvitation && isset($data['inviter_name']))
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ __('notification.escortInvitation.title') }} 
                                </span>
                                <span>
                                    {{ __('notification.escortInvitation.message', ['inviter_name' => $data['inviter_name']]) }}
                                </span>
                            @elseif($isProfileVerificationRequest && isset($data['user_name']))
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ __('notification.profileVerificationRequest.title') }} 
                                </span>
                                <span>
                                    {{ __('notification.profileVerificationRequest.message', ['user_name' => $data['user_name']]) }}
                                </span>
                            @elseif(isset($data['title'], $data['message']))
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ $data['title'] ?? '' }}
                                </span>
                                <span>
                                    {{ $data['message'] ?? '' }}
                                </span>
                            @else
                                <span class="text-gray-500">
                                    Notification non reconnue
                                </span>
                            @endif
                            
                        </div>
                        <div class="text-xs text-blue-600 dark:text-blue-500" wire:click="markAsRead('{{ $notification->id }}')">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-3 text-gray-500 text-center text-sm">{{ __('notification.no_notifications') }}</div>
            @endforelse
        </div>
        <a wire:click="markAsReadAll()"
            class="block rounded-b-lg bg-gray-50 py-2 text-center text-sm font-medium text-gray-900 hover:bg-gray-100 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
            <div class="inline-flex items-center">
                <svg class="me-2 h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                    <path
                        d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                </svg>
                {{ __('notification.view_all') }}
            </div>
        </a>
    </div>
</div>
