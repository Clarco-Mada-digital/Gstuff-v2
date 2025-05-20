@php $user = Auth()->user(); @endphp
<div class="relative rounded-lg p-4">
    <input type="file" wire:model="media" class="hidden" id="storiesUpload">

    @if (!$media)
        <label for="storiesUpload">
            <div class="border-green-gs relative h-24 w-24 cursor-pointer rounded-full border-2">
                <img @if ($avatar = $user->avatar) src="{{ asset('storage/avatars/' . $avatar) }}"
                    @else
                    src="{{ asset('images/icon_logo.png') }}" @endif
                    class="h-full w-full rounded-full object-cover" alt="{{ __('profile.add_story') }}">
                <div
                    class="text-green-gs absolute left-0 top-0 flex h-full w-full items-center justify-center rounded-full bg-gray-300/50 text-2xl font-bold">
                    +</div>
            </div>
        </label>
    @else
        <div class="relative">
            @if ($mediaType === 'image')
                <img src="{{ $media->temporaryUrl() }}" class="max-w-50 rounded-lg">
            @else
                <video controls class="max-w-50 rounded-lg">
                    <source src="{{ $media->temporaryUrl() }}">
                </video>
            @endif

            <button wire:click="save" class="absolute bottom-4 right-4 rounded bg-green-500 px-4 py-2 text-white">
                {{ __('profile.publish') }}
            </button>
        </div>
    @endif
</div>
