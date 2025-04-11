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
          <!-- Affichage de l'avatar de l'utilisateur -->
          <img class="w-12 h-12 rounded-full"
          :src="item.avatar ? `/storage/avatars/${item.avatar}` : '/images/icons/user_icon.svg'"
          alt="Image profile" />

        
          <div class="flex flex-col font-bold">
            <span class="font-dm-serif text-base lg:text-2xl text-green-800" x-text="item.author"></span>
            <span class="text-sm text-center xl:text-start lg:text-base" x-text="item.post"></span>
          </div>
        </div>
      </div>
    </template>
  </div>
  <button @click="prev()" class="absolute left-1 xl:left-10 top-1/2 transform -translate-y-1/2 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer z-40">
    ←
  </button>
  <button @click="next()" class="absolute right-1 xl:right-10 top-1/2 transform -translate-y-1/2 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer z-40">
    →
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
    items: [],
    currentIndex: 0,
    async fetchItems() {
      try {
        const response = await fetch("{{ route('commentaires.approved') }}");
        const data = await response.json();
        console.log();
        

        // Mise à jour des données récupérées avec gestion de l'avatar
        this.items = data.map(item => ({
          content: item.content,
          author: item.user.prenom,
          post: item.user.profile_type,
          avatar: item.user.avatar
        }));

      } catch (error) {
        console.error("Erreur lors de la récupération des éléments du carrousel :", error);
      }
    },
    next() {
      if (this.items.length > 0) {
        this.currentIndex = (this.currentIndex + 1) % this.items.length;
      }
    },
    prev() {
      if (this.items.length > 0) {
        this.currentIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
      }
    },
    autoSlide() {
      setInterval(() => {
        this.next();
      }, 7000);
    },
    init() {
      this.fetchItems();
      this.autoSlide();
    }
  };
}



</script>