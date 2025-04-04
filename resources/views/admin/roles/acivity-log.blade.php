@extends('layout:admin')

@section('page_title')
  Log Acivity
@endsection

@section('content')
  @foreach($activities as $activity)
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
              <strong>{{ $activity->causer->name ?? 'System' }}</strong>
              {{ $activity->description }}
          </p>
          <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
          
          @if($activity->event === 'updated')
          <div class="activity-changes">
              @foreach($activity->properties['attributes'] as $key => $value)
                  <div>
                      <strong>{{ $key }}:</strong>
                      {{ $value }} (était: {{ $activity->properties['old'][$key] ?? 'null' }})
                  </div>
              @endforeach
          </div>
          @endif
      </div>
  </div>
  @endforeach
@endsection