{{-- Glossaire --}}
<div class="relative w-full">
  <div id="glossaire-container" class="w-full flex items-center flex-nowrap gap-10 px-20 overflow-x-auto scroll-smooth" data-slider-wrapper style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
    @foreach ($apiData['glossaires'] as $item)
      <a href="{{ route('glossaire', $item['id']) }}">
        <div class="bg-green-gs min-w-[375px] w-[375px] h-[232px] flex flex-col items-stretch gap-5 p-5 text-white rounded-lg py-10" style="scroll-snap-align: center" data-carousel-item >
          <h4 class="font-dm-serif text-2xl">{{ $item['title']['rendered'] }}</h4>
          <span class="flex-1">{!! Str::limit($item['excerpt']['rendered'], 100, '...') !!}</span>
          <svg class="w-10 my-3 text-amber-400"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12.7 17.925q-.35.2-.625-.062T12 17.25L14.425 13H3q-.425 0-.712-.288T2 12t.288-.712T3 11h11.425L12 6.75q-.2-.35.075-.612t.625-.063l7.975 5.075q.475.3.475.85t-.475.85z"/></svg>
        </div>
      </a>
    @endforeach
  </div>
  <div id="arrowScrollRight" class="absolute top-[40%] left-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-prev>
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z"/></svg>
  </div>
  <div id="arrowScrollLeft" class="absolute top-[40%] right-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-next>
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z"/></svg>
  </div>
</div>


<script>
  let elementChild = 0
  let itemPercent = 0
  const rightBtn = document.getElementById('arrowScrollRight')
  const leftBtn = document.getElementById('arrowScrollLeft')
  const container = document.getElementById('glossaire-container')
  // let containerCheld = parseInt(containerCheld.length);
  // let itemPercent = (container.offsetWidth / containerCheld) * 100;
  // console.log(containerCheld)

  // const timeOut = setTimeout(() => {
  //   elementChild = parseInt(container.children.length)
  //   itemPercent = Math.ceil(elementChild / 100) ;
  // }, 1000);

  rightBtn.addEventListener('click', ()=>{scrollByPercentage(container, false)})
  leftBtn.addEventListener('click', ()=>{scrollByPercentage(container)})

</script>

