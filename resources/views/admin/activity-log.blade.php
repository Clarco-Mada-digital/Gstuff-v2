@extends('layouts.admin')

@section('page_title')
    {{ __('activity.page_title') }}
@endsection

@section('admin-content')
<div class="container mx-auto px-5 py-8">
    <h2 class="font-roboto-slab text-center text-2xl font-bold text-green-gs mb-8">{{ __('activity.activity_log') }}</h2>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden p-6">
        @foreach ($activities as $activity)
        <div class="border-l-4 border-supaGirlRose pl-4 mb-6 transition duration-300 ease-in-out hover:shadow-lg hover:bg-gray-50 p-4">
            <div class="flex items-start">
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-supaGirlRose flex items-center justify-center text-green-gs mr-4">
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
                    <div class="flex justify-between items-center">
                        <p class="text-gray-800 font-roboto-slab">
                            <strong class="text-green-gs font-roboto-slab">{{ $activity->causer->pseudo ?? __('activity.system') }}</strong>
                          
                        </p>
                        
                        <small class="text-gray-500 font-roboto-slab text-sm">{{ $activity->created_at->diffForHumans() }}</small>
                    </div>
                    <span class="font-roboto-slab text-textColor text-sm">{{ $activity->description }}</span>

                    @if ($activity->event === 'updated')
                    <div class="activity-changes mt-4">
                        <button class="w-full flex justify-between items-center p-4 bg-gray-100 rounded-lg focus:outline-none font-roboto-slab" onclick="toggleAccordion(this)">
                            <h4 class="text-gray-700 font-roboto-slab">{{ __('activity.changes') }}</h4>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="accordion-content hidden mt-2 bg-gray-100 p-4 rounded-lg">
                            @foreach ($activity->properties['attributes'] as $key => $value)
                            <div class="my-2 p-2 bg-white rounded shadow-sm">
                                <strong class="text-gray-700 font-roboto-slab">{{ $key }}:</strong>
                                <p class="text-gray-900 font-roboto-slab">{!! $value !!}</p>
                                <strong class="italic text-red-500 font-roboto-slab">{{ __('activity.was') }}: </strong>
                                <p class="text-gray-600 font-roboto-slab">{!! $activity->properties['old'][$key] ?? 'null' !!}</p>
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
