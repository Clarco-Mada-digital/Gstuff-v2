<div class="mx-auto w-full space-y-4">
    @if (session()->has('success'))
        <div class="rounded bg-green-100 p-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form id="conseilForm" wire:submit.prevent="send" method="POST" class="flex w-full flex-col gap-3">
        <div class="grid w-full grid-cols-1 gap-3 md:grid-cols-2">
        

            <x-form.input-field 
                    name="name"
                    wire:model="name"
                    :label="__('contact.name')"
                    :value="old('name')"
                    autocomplete="name"
                    :error="$errors->has('name')"
                    :errorMessage="$errors->first('name')"
                    placeholder="{{ __('contact.name_placeholder') }}"
                    required
                />

                <x-form.input-field 
                    name="email"
                    type="email"
                    wire:model="email"
                    :label="__('contact.email')"
                    :value="old('email')"
                    autocomplete="email"
                    :error="$errors->has('email')"
                    :errorMessage="$errors->first('email')"
                    placeholder="{{ __('contact.email_placeholder') }}"
                    required
                />



        </div>


        <x-form.input-field 
                    name="subject"
                    wire:model="subject"
                    :label="__('contact.subject')"
                    :value="old('subject')"
                    autocomplete="subject"
                    :error="$errors->has('subject')"
                    :errorMessage="$errors->first('subject')"
                    placeholder="{{ __('contact.subject_placeholder') }}"
                    required
                />

       

            <div class="flex w-full flex-col gap-1">
            <label for="messageConseil" class="font-medium text-sm text-green-gs font-roboto-slab font-bold">{{ __('contact.message') }}</label>
            <textarea wire:model.defer="message" name="message" id="messageConseil" rows="6"
                class="@error('message') border-red-500 @enderror rounded-lg border border-supaGirlRose border-2 p-2 ring-0 focus:border-supaGirlRose text-sm font-roboto-slab text-textColorParagraph"
                placeholder="{{ __('contact.message_placeholder') }}"></textarea>
            @error('message')
                <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <x-form.submit-button :text="__('contact.send')" />

    </form>
</div>
