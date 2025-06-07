<div class="mx-auto w-full space-y-4">
    @if (session()->has('success'))
        <div class="rounded bg-green-100 p-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form id="conseilForm" wire:submit.prevent="send" method="POST" class="flex w-full flex-col gap-3">
        <div class="grid w-full grid-cols-1 gap-3 md:grid-cols-2">
            <div class="flex w-full flex-col gap-1">
                <label for="nom" class="font-medium">{{ __('contact.name') }}</label>
                <input wire:model.defer="name" type="text" name="nom" id="nom"
                    class="@error('name') border-red-500 @enderror rounded-lg border p-2 ring-0 focus:border-amber-400"
                    placeholder="{{ __('contact.name_placeholder') }}">
                @error('name')
                    <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex w-full flex-col gap-1">
                <label for="contact_email" class="font-medium">{{ __('contact.email') }}</label>
                <input wire:model.defer="email" type="email" name="email" id="contact_email"
                    class="@error('email') border-red-500 @enderror rounded-lg border p-2 ring-0 focus:border-amber-400"
                    placeholder="{{ __('contact.email_placeholder') }}">
                @error('email')
                    <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex w-full flex-col gap-1">
            <label for="sujet" class="font-medium">{{ __('contact.subject') }}</label>
            <input wire:model.defer="subject" type="text" name="sujet" id="sujet"
                class="@error('subject') border-red-500 @enderror rounded-lg border p-2 ring-0 focus:border-amber-400"
                placeholder="{{ __('contact.subject_placeholder') }}">
            @error('subject')
                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex w-full flex-col gap-1">
            <label for="messageConseil" class="font-medium">{{ __('contact.message') }}</label>
            <textarea wire:model.defer="message" name="message" id="messageConseil" rows="6"
                class="@error('message') border-red-500 @enderror rounded-lg border p-2 ring-0 focus:border-amber-400"
                placeholder="{{ __('contact.message_placeholder') }}"></textarea>
            @error('message')
                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit"
            class="bg-green-gs hover:bg-green-gs/90 mt-2 w-full cursor-pointer rounded-lg p-3 text-center text-lg text-white transition-colors duration-200">
            {{ __('contact.send') }}
        </button>
    </form>
</div>
