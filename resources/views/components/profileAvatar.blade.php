@props([
    'avatarSrc' => '',
    'gallery' => [],
    'status' => null,
    'type' => 'salon',
])




<div>
    @if($type === 'salon')
<div id="avatar-container" class="relative w-[220px] h-[220px] -mt-26 rounded-full border-4 border-white overflow-hidden shadow-md">
                <img 
                    src="{{ $avatarSrc ??  asset('images/icon_logo.png') }}"
                    alt="{{ __('salon_profile.profile_image') }}"
                    class="h-full w-full object-cover object-center cursor-pointer"
                />
                <span class="absolute bottom-4 right-4 h-4 w-4 rounded-full ring-2 ring-white {{ $status ? 'bg-green-500 animate-pulse' : 'bg-gray-400' }}"></span>
            </div>
            @endif
            @if($type === 'escort')
  <div id="avatar-container" class="w-[220px] h-[220px] border-5 relative mx-auto  rounded-full border-white shadow-sm overflow-hidden">
                <img 
                    src="{{ $avatarSrc ??  asset('images/icon_logo.png') }}"
                    alt="{{ __('salon_profile.profile_image') }}"
                    class="h-full w-full object-cover object-center cursor-pointer"
                />
                <span class="absolute bottom-4 right-4 h-4 w-4 rounded-full ring-2 ring-white {{ $status ? 'bg-green-500 animate-pulse' : 'bg-gray-400' }}"></span>
            </div>
            @endif            

<!-- Modal de galerie -->
<div id="gallery-modal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
   <!-- Bouton fermer -->
   <button id="close-modal" class="absolute right-4 top-4 z-10 rounded-full bg-supaGirlRose p-2 text-green-gs hover:text-white hover:bg-green-gs">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>

    <!-- Image -->
    <img id="gallery-image" src="" alt="Gallery Image" class="max-h-[70vh] mx-auto rounded shadow mb-4" />

    <!-- Boutons navigation -->
    <button id="prev-btn" class="absolute left-4 top-1/2 -translate-y-1/2 z-10 rounded-full bg-green-gs p-2 text-white hover:bg-supaGirlRose">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>

    <button id="next-btn" class="absolute right-4 top-1/2 -translate-y-1/2 z-10 rounded-full bg-green-gs p-2 text-white hover:bg-supaGirlRose">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </button>
</div>

</div>

            
    @push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
  const galleryData = @json($gallery);
  let currentIndex = 0;

  const avatarContainer = document.getElementById("avatar-container");
  const modal = document.getElementById("gallery-modal");
  const closeModal = document.getElementById("close-modal");
  const galleryImage = document.getElementById("gallery-image");
  const prevBtn = document.getElementById("prev-btn");
  const nextBtn = document.getElementById("next-btn");

  function showImage(index) {
    const item = galleryData[index];
    galleryImage.src = item.path;

    galleryImage.onerror = function () {
      this.src = '{{ asset('images/icon_logo.png') }}'; // Image par défaut si erreur
    };
  }

  function showModal(index = 0) {
    currentIndex = index;
    showImage(currentIndex);
    modal.classList.remove("hidden");
  }

  function hideModal() {
    modal.classList.add("hidden");
  }

  function navigate(direction) {
    currentIndex = (currentIndex + direction + galleryData.length) % galleryData.length;
    showImage(currentIndex);
  }

  avatarContainer?.addEventListener("click", () => showModal(0));
  closeModal?.addEventListener("click", hideModal);
  prevBtn?.addEventListener("click", () => navigate(-1));
  nextBtn?.addEventListener("click", () => navigate(1));

  modal?.addEventListener("click", function (e) {
    if (e.target === modal) hideModal();
  });

  // ✅ Navigation avec les flèches du clavier
  document.addEventListener("keydown", function (e) {
    if (!modal.classList.contains("hidden")) {
      if (e.key === "ArrowLeft") {
        navigate(-1);
      } else if (e.key === "ArrowRight") {
        navigate(1);
      } else if (e.key === "Escape") {
        hideModal();
      }
    }
  });
});
</script>
@endpush