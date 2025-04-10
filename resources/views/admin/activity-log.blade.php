@extends('layouts.admin')

@section('page_title')
  Log Acivity
@endsection

@section('admin-content')
<div class="px-5">
    <h2 class="font-dm-serif text-4xl font-bold text-center w-full">Activity</h2>
  @foreach($activities as $activity)
  <hr class="my-3 text-green-gs" />
  <div class="activity-item">
      <div class="activity-icon">
          @switch($activity->event)
              @case('created') 📄 @break
              @case('updated') ✏️ @break
              @case('deleted') 🗑️ @break
              @default 🔔
          @endswitch
      </div>
      <div class="activity-content">
          <p>
              <strong>{{ $activity->causer->pseudo ?? 'System' }}</strong>
              {{ $activity->description }}
          </p>
          <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
          
          @if($activity->event === 'updated')
          <div class="activity-changes">
              @foreach($activity->properties['attributes'] as $key => $value)
                  <div class="my-3">
                      <strong>{{ $key }}:</strong>
                      <p>{!! $value !!}</p> 
                      <strong class="text-red-500 italic">était: </strong>
                      <p>{!! $activity->properties['old'][$key] ?? 'null' !!}</p>
                  </div>
              @endforeach
          </div>
          @endif
      </div>
  </div>
  @endforeach
  <hr class="my-3 text-green-gs" />
</div>
@endsection