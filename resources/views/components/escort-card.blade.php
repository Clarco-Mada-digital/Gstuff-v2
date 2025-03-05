<div class="relative flex flex-col justify-start min-w-[317px] min-h-[505px] mx-auto mb-2 p-1 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700" style="scroll-snap-align: center">
  <div class="absolute flex items-center justify-center top-0 right-0 w-10 h-10 rounded-full bg-white m-2 text-green-gs">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m22 9.24l-7.19-.62L12 2L9.19 8.63L2 9.24l5.46 4.73L5.82 21L12 17.27L18.18 21l-1.63-7.03zM12 15.4l-3.76 2.27l1-4.28l-3.32-2.88l4.38-.38L12 6.1l1.71 4.04l4.38.38l-3.32 2.88l1 4.28z"/></svg>
  </div>
  <a class="m-auto w-full rounded-lg overflow-hidden" href="{{route('escort')}}" >
      <img class="w-full object-cover rounded-t-lg" src="images/girl_001.png" alt="profile image" />
  </a>
  <div class="flex flex-col gap-2 mt-4">
      <a class="flex items-center gap-1" href="{{route('escort')}}" >
          <h5 class="text-base tracking-tight text-gray-900 dark:text-white">{{ $name }}</h5>
          <div class="w-2 h-2 rounded-full bg-green-gs"></div>
      </a>
      <p class="font-normal text-gray-700 dark:text-gray-400">
        <span>{{$canton}}</span><span> | {{$ville}}</span>
      </p>
  </div>
</div>
