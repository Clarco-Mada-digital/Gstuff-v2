<div class="relative py-10 w-full overflow-hidden">
  <div class="bg-[#E4F1F1] absolute top-0 right-0 w-full h-full z-0"></div>
  <div class="w-full flex items-center justify-center gap-5 flex-nowrap overflow-hidden">
  @foreach ([1, 2, 3] as $item)
  <div class=" @if ($item==2) scale-100 @else scale-75 @endif min-w-[300px] lg:w-[625px] h-[250px] p-5 bg-white rounded-lg flex flex-col items-center justify-center gap-4 text-xl lg:text-3xl z-10">
    <span class="text-center w-[80%] mx-auto">"Amazing experience i love it a lot. Thanks to the team that dreams come true, great!"</span>
    <div class="flex items-center w-full justify-center gap-4">
      <img class="w-12 h-12 rounded-full" src="{{ asset('images/icons/user_icon.svg') }}" alt="user_default icon" srcset="user icon">
      <div class="flex flex-col font-bold">
        <span class="font-dm-serif text-base lg:text-2xl text-green-800">Lassy Chester</span>
        <span class="text-sm lg:text-base">Escort</span>
      </div>
    </div>
  </div>
  @endforeach
  </div>
</div>
