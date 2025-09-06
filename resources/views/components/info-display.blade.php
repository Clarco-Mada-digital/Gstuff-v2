@props([
    'items' => '',
    'type' => 'language',
    'title' => null,
    'icon' => true,
    'iconPath' => null,
    'altText' => null,
    'separator' => ',',
])

@php
    $itemList = is_array($items) ? $items : ($items ? array_map('trim', explode($separator, $items)) : []);
    $isPayment = $type === 'payment';
    $defaultIcon = $isPayment ? 'images/icons/cart_icon.png' : 'images/icons/langue_icon.png';
    $defaultAlt = $isPayment ? __('escort_profile.payment_icon') : __('escort_profile.language_icon');
    $defaultTitle = $isPayment ? __('escort_profile.payment_methods') : __('escort_profile.language');
    $displayIconPath = $iconPath ?? $defaultIcon;
    $displayAltText = $altText ?? $defaultAlt;
    $displayTitle = $title ?? $defaultTitle;
@endphp
@if ($items)
    <div class="font-roboto-slab text-textColor flex w-full items-center gap-3">
        @if ($icon && $displayIconPath)
            <img src="{{ asset($displayIconPath) }}" alt="{{ $displayAltText }}" class="h-8 w-8" />
        @endif

        <div class="flex-1">
            @if ($displayTitle)
                <div class="font-roboto-slab text-textColor text-sm">{{ $displayTitle }} :</div>
            @endif
            @if (!empty($itemList))
                <div class="m-1 flex flex-wrap">
                    @foreach ($itemList as $item)
                        <span
                            class="bg-fieldBg text-textColor font-roboto-slab mb-1 mr-1 whitespace-nowrap rounded px-1 py-1 text-sm text-sm">
                            {{ $item }}
                        </span>
                    @endforeach
                </div>
            @else
                <span class="font-roboto-slab text-textColor text-sm">-</span>
            @endif
        </div>
    </div>
@endif
