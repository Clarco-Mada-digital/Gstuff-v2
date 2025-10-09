@extends('layouts.admin')

@section('page_title')
    {{ __('activity.page_title') }}
@endsection

@section('admin-content')
    <div class="container mx-auto px-5 py-8">
        <h2 class="font-roboto-slab text-green-gs mb-8 text-center text-2xl font-bold">{{ __('activity.activity_log') }}</h2>

        <div class="overflow-hidden rounded-xl bg-white p-6 shadow-lg">
            @foreach ($activities as $activity)
                <div
                    class="border-supaGirlRose mb-6 border-l-4 p-4 pl-4 transition duration-300 ease-in-out hover:bg-gray-50 hover:shadow-lg">
                    <div class="flex items-start">
                        <div
                            class="bg-supaGirlRose text-green-gs mr-4 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full">
                            @switch($activity->event)
                                @case('created')
                                    <i class="fas fa-file-alt"></i>
                                @break

                                @case('updated')
                                    <i class="fas fa-edit"></i>
                                @break

                                @case('deleted')
                                    <i class="fas fa-trash-alt"></i>
                                @break

                                @default
                                    <i class="fas fa-bell"></i>
                            @endswitch
                        </div>
                        <div class="activity-content flex-1">
                            <div class="flex items-center justify-between">
                                <p class="font-roboto-slab text-gray-800">
                                    <strong
                                        class="text-green-gs font-roboto-slab">{{ $activity->causer->pseudo ?? __('activity.system') }}</strong>

                                </p>

                                <small
                                    class="font-roboto-slab text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</small>
                            </div>
                            <span class="font-roboto-slab text-textColor text-sm">{{ $activity->description }}</span>

                            @if ($activity->event === 'updated')
                                <div class="activity-changes mt-4">
                                    <button
                                        class="font-roboto-slab flex w-full items-center justify-between rounded-lg bg-gray-100 p-4 focus:outline-none"
                                        onclick="toggleAccordion(this)">
                                        <h4 class="font-roboto-slab text-gray-700">{{ __('activity.changes') }}</h4>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <div class="accordion-content mt-2 hidden rounded-lg bg-gray-100 p-4">
                                        @foreach ($activity->properties['attributes'] as $key => $value)
                                            <div class="my-2 rounded bg-white p-2 shadow-sm">
                                                <strong class="font-roboto-slab text-gray-700">{{ $key }}:</strong>
                                                <p class="font-roboto-slab text-gray-900">{!! $value !!}</p>
                                                <strong
                                                    class="font-roboto-slab italic text-red-500">{{ __('activity.was') }}:
                                                </strong>
                                                <p class="font-roboto-slab text-gray-600">{!! $activity->properties['old'][$key] ?? 'null' !!}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function toggleAccordion(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('i');

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
            } else {
                content.classList.add('hidden');
                icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
            }
        }
    </script>
@endsection
