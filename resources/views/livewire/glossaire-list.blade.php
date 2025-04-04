<div>
    <div class="md:w-[80%] w-full h-auto mx-auto p-2 flex items-center flex-wrap xl:flex-nowrap justify-center gap-3 bg-white rounded-md xl:-translate-y-[50%] -translate-y-[30%] shadow-lg">
        @foreach (range('A', 'Z') as $item)
        <div>
            <input wire:model.live='lettreSearche' id="lettre{{$item}}" name="{{$item}}" class="hidden peer" type="checkbox" value="{{$item}}"/>
            <label for="lettre{{$item}}" class="w-10 h-10 flex items-center justify-center rounded-md bg-whire text-green-gs border border-gray-300 font-dm-serif text-base xl:text-xl font-bold hover:bg-green-gs hover:text-white peer-checked:bg-green-gs peer-checked:text-white transition-all cursor-pointer">{{ Str::upper($item) }}</label>
        </div>
        @endforeach
      </div>
    
      <div class="lg:container mx-auto px-5 lg:p-10">
        @foreach ($glossaires as $glossaire)
        <div class="flex flex-col justify-center gap-1 my-5 text-sm xl:text-base">
          <a href="{{route('glossaires.show', $glossaire->slug)}}" class="text-2xl xl:text-4xl font-dm-serif text-green-gs font-bold">{{ $glossaire->title }}</a>
          @if ($glossaire->excerpt)
            {!! $glossaire->excerpt !!}
          @else
          <p>{!! $glossaire->content !!}</p>
          @endif        
        </div>
        @endforeach
    
        <div>{{$glossaires->links('pagination::simple-tailwind')}}</div>
    </div>
</div>
