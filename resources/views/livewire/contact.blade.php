<div class="mx-auto space-y-4 w-full">
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- <form  class="space-y-4">
        <input type="text"  placeholder="Votre nom"
            class="w-full border rounded px-4 py-2 ">
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <input type="email"  placeholder="Votre email"
            class="w-full border rounded px-4 py-2 ">
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <textarea placeholder="Votre message"
            class="w-full border rounded px-4 py-2 h-32 "></textarea>
        @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <button type="submit"
            class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded">
            Envoyer
        </button>
    </form> --}}
    <form id="conseilForm" wire:submit.prevent="send" method="POST" class="flex flex-col gap-3 w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 w-full">
          <div class="flex flex-col w-full gap-1">
            <label for="nom" class="font-medium">{{__('contact.name')}}</label>
            <input 
                wire:model.defer="name" 
                type="text" 
                name="nom" 
                id="nom" 
                class="border rounded-lg focus:border-amber-400 ring-0 p-2 @error('name') border-red-500 @enderror" 
                placeholder="{{__('contact.name_placeholder')}}"
            >
            @error('name')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="flex flex-col w-full gap-1">
            <label for="contact_email" class="font-medium">{{__('contact.email')}}</label>
            <input 
                wire:model.defer="email" 
                type="email" 
                name="email" 
                id="contact_email" 
                class="border rounded-lg focus:border-amber-400 ring-0 p-2 @error('email') border-red-500 @enderror" 
                placeholder="{{__('contact.email_placeholder')}}"
            >
            @error('email')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>
        </div>
        
        <div class="flex flex-col w-full gap-1">
          <label for="sujet" class="font-medium">{{__('contact.subject')}}</label>
          <input  
              wire:model.defer="subject" 
              type="text" 
              name="sujet" 
              id="sujet" 
              class="border rounded-lg focus:border-amber-400 ring-0 p-2 @error('subject') border-red-500 @enderror" 
              placeholder="{{__('contact.subject_placeholder')}}"
          >
          @error('subject')
              <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror
        </div>
        
        <div class="flex flex-col w-full gap-1">
          <label for="messageConseil" class="font-medium">{{__('contact.message')}}</label>
          <textarea  
              wire:model.defer="message" 
              name="message" 
              id="messageConseil" 
              rows="6" 
              class="border rounded-lg focus:border-amber-400 ring-0 p-2 @error('message') border-red-500 @enderror" 
              placeholder="{{__('contact.message_placeholder')}}"
          ></textarea>
          @error('message')
              <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror
        </div>
        
        <button 
            type="submit" 
            class="w-full bg-green-gs rounded-lg text-center text-white p-3 text-lg cursor-pointer hover:bg-green-gs/90 transition-colors duration-200 mt-2"
        >
            {{__('contact.send')}}
        </button>
    </form>
</div>

