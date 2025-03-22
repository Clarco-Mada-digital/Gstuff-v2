<div x-data="{userType: '{{ Auth::user()->profile_type}}'}">
    <button id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification" type="button" class="relative bg-gray-200 focus:outline-none font-medium rounded-full text-sm p-2 text-center inline-flex items-center xl:order-1 cursor-pointer">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5 19q-.425 0-.712-.288T4 18t.288-.712T5 17h1v-7q0-2.075 1.25-3.687T10.5 4.2v-.7q0-.625.438-1.062T12 2t1.063.438T13.5 3.5v.7q2 .5 3.25 2.113T18 10v7h1q.425 0 .713.288T20 18t-.288.713T19 19zm7 3q-.825 0-1.412-.587T10 20h4q0 .825-.587 1.413T12 22"/></svg>
      <span class="sr-only">Icon description</span>
      @if($unreadCount > 0)
      <div class="absolute block w-5 h-5 bg-red-500 border-2 border-white rounded-full top-1 start-5.5 dark:border-gray-900 text-white text-sm flex items-center justify-center">{{ $unreadCount }}</div>
      @endif
    </button>
    <!-- Dropdown menu -->
    <div id="dropdownNotification" class="z-20 hidden w-full max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-800 dark:divide-gray-700" aria-labelledby="dropdownNotificationButton">
      <div class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white">
          Notifications
      </div>
      <div class="divide-y divide-gray-100 dark:divide-gray-700">
        @forelse($notifications as $notification)
        <a href="{{$notification->data['url'] ?? '#'}}" 
            wire:key="{{ $notification->id }}" 
            class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700"
            wire:click="markAsRead('{{ $notification->id }}')">
            <div class="shrink-0">
              <img class="rounded-full w-11 h-11" src="{{ asset('images/icons/user_icon.svg')}}" alt="Robert image">
              <div class="absolute flex items-center justify-center w-5 h-5 ms-6 -mt-5 bg-purple-500 border border-white rounded-full dark:border-gray-800">
                <svg class="w-2 h-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                  <path d="M11 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm8.585 1.189a.994.994 0 0 0-.9-.138l-2.965.983a1 1 0 0 0-.685.949v8a1 1 0 0 0 .675.946l2.965 1.02a1.013 1.013 0 0 0 1.032-.242A1 1 0 0 0 20 12V2a1 1 0 0 0-.415-.811Z"/>
                </svg>
              </div>
            </div>
            <div class="w-full ps-3">
                <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400 flex flex-col gap-1">
                    <span class="font-semibold text-gray-900 dark:text-white">
                        {{ $notification->data['title'] }}
                    </span>
                    <span>
                        {{ $notification->data['message'] }}
                    </span>
                </div>
                <div class="text-xs text-blue-600 dark:text-blue-500">
                    {{ $notification->created_at->diffForHumans() }}
                </div>
            </div>
        </a>
        @empty
        <div class="p-3 text-gray-500">Aucune notification</div>
        @endforelse      
      </div>
      <a href="#" class="block py-2 text-sm font-medium text-center text-gray-900 rounded-b-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white">
        <div class="inline-flex items-center ">
          <svg class="w-4 h-4 me-2 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
            <path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
          </svg>
            Voir tous
        </div>
      </a>
    </div>    
</div>