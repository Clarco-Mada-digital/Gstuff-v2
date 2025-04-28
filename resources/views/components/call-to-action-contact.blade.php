{{-- Nou contactez --}}
<div class="flex flex-col items-center justify-center gap-10 lg:container mx-auto py-20">
  <div class="flex flex-col justify-center gap-5 w-full lg:w-[1140px] h-[255px] px-10 lg:px-20 text-white" style="background: url('images/girl_deco_contact.jpg') center center /cover">
    <h2 class="text-3xl lg:text-5xl font-dm-serif font-bold">{{__('call-to-action-contact.contact_us')}}</h2>
    <p>{{__('call-to-action-contact.need_info')}}</p>
    <div class="z-10 mt-5">
      <a href="{{route('contact')}}" type="button" class="w-52 flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg px-4 py-2 text-center text-sm lg:text-base dark:focus:ring-blue-800">{{__('call-to-action-contact.write_us')}} <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/></svg>
      </a>
    </div>
  </div>
</div>
