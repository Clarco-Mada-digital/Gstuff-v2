<div x-data="carousel()" x-init="init()" class="relative py-10 w-full min-h-90 overflow-hidden flex items-center justify-center">
  <div class="bg-[#E4F1F1] absolute top-0 right-0 w-full h-full z-0"></div>
  <div class="w-full flex items-center justify-center gap-5 flex-nowrap overflow-hidden">
    <template x-for="(item, index) in items" :key="index">
      <div
        :class="{
          'scale-75 translate-x-[-100%] z-10': currentIndex === index,
          'scale-100 translate-x-0 z-20': currentIndex === index - 1,
          'scale-75 translate-x-[100%] z-10': currentIndex === index - 2,
          'translate-x-0 opacity-0 scale-50': currentIndex !== index && currentIndex !== index - 1 && currentIndex !== index - 2
        }"
        class="min-w-[400px] w-full lg:w-[625px] h-[250px] p-5 bg-white rounded-lg flex flex-col items-center justify-center gap-4 text-xl lg:text-3xl duration-500 flex-shrink-0 md:w-1/3 absolute transition-feed">
        <span class="text-center w-[80%] mx-auto" x-text="item.content"></span>
        <div class="flex flex-col xl:flex-row items-center w-full justify-center gap-4">
          <img class="w-12 h-12 rounded-full" src="{{ asset('images/icons/user_icon.svg') }}" alt="user_default icon" srcset="user icon">
          <div class="flex flex-col font-bold">
            <span class="font-dm-serif text-base lg:text-2xl text-green-800" x-text="item.author"></span>
            <span class="text-sm text-center xl:text-start lg:text-base" x-text="item.post"></span>
          </div>
        </div>
      </div>
    </template>
  </div>
  <button @click="prev()" class="absolute left-1 xl:left-10 top-1/2 transform -translate-y-1/2 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer z-40">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z"/></svg>
  </button>
  <button @click="next()" class="absolute right-1 xl:right-10 top-1/2 transform -translate-y-1/2 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer z-40">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z"/></svg>
  </button>
</div>

<style>
  .transition-feed {
    transition: all 1.5s ease-in-out;
  }
</style>
<script>
  function carousel() {
    return {
      items: [
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
        { content: "Amazing experience i love it a lot. Thanks to the team that dreams come true, great!", author: "Lassy Chester", post: "Escort"},
      ],
      currentIndex: 0,
      next() {
        this.currentIndex = (this.currentIndex + 1) % this.items.length;
      },
      prev() {
        this.currentIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
      },
      autoSlide() {
        setInterval(() => {
          this.next();
        }, 7000); // Change every 7 seconds
      },
      init() {
        // this.autoSlide();
      }
    }
  }
</script>
