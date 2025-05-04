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
          <div class="flex flex-col w-full gap-2">
            <label for="nom">{{__('contact.name')}}</label>
            <input wire:model.defer="name" type="text" name="nom" id="nom" class="border rounded-lg focus:border-amber-400 ring-0 @error('name') border-red-500 @enderror" placeholder="{{__('contact.name_placeholder')}}">
          </div>
          <div class="flex flex-col w-full gap-2">
            <label for="contact_email">{{__('contact.email')}}</label>
            <input wire:model.defer="email" type="email" name="email" id="contact_email" class="border rounded-lg focus:border-amber-400 ring-0 @error('email') border-red-500 @enderror" placeholder="{{__('contact.email_placeholder')}}">
          </div>
        </div>
        <div class="flex flex-col w-full gap-2">
          <label for="sujet">{{__('contact.subject')}}</label>
          <input  wire:model.defer="subject" type="text" name="sujet" id="sujet" class="border rounded-lg focus:border-amber-400 ring-0 @error('subject') border-red-500 @enderror" placeholder="{{__('contact.subject_placeholder')}}">
        </div>
        <div class="flex flex-col w-full gap-2">
          <label for="messageConseil">{{__('contact.message')}}</label>
          <textarea  wire:model.defer="message" name="message" id="messageConseil" rows="10" class="border rounded-lg focus:border-amber-400 ring-0 @error('message') border-red-500 @enderror" placeholder="{{__('contact.message_placeholder')}}"></textarea>
        </div>
        <button type="submit" class="w-full bg-green-gs rounded-lg text-center text-white p-3 text-lg cursor-pointer hover:bg-green-gs/70">{{__('contact.send')}}</button>
    </form>
</div>

