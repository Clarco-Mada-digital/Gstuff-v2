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
    $itemList = is_array($items) ? $items : 
              ($items ? array_map('trim', explode($separator, $items)) : []);
    $isPayment = $type === 'payment';
    $defaultIcon = $isPayment ? 'images/icons/cart_icon.svg' : 'images/icons/langue_icon.svg';
    $defaultAlt = $isPayment ? __('escort_profile.payment_icon') : __('escort_profile.language_icon');
    $defaultTitle = $isPayment ? __('escort_profile.payment_methods') : __('escort_profile.language');
    $displayIconPath = $iconPath ?? $defaultIcon;
    $displayAltText = $altText ?? $defaultAlt;
    $displayTitle = $title ?? $defaultTitle;
@endphp

<div class="font-dm-serif flex w-full items-center gap-3">
    @if($icon && $displayIconPath)
        <img 
            src="{{ asset($displayIconPath) }}" 
            alt="{{ $displayAltText }}"
           
        />
    @endif
    
    <div class="flex-1">
        @if($displayTitle)
            <div class="font-medium">{{ $displayTitle }} :</div>
        @endif
        @if(!empty($itemList))
            <div class="flex flex-wrap  m-1">
                @foreach($itemList as $item)
                    <span class="bg-gray-50 px-1 py-1 rounded text-sm whitespace-nowrap">
                        {{ $item }}
                    </span>
                @endforeach
            </div>
        @else
            <span class="text-gray-500">-</span>
        @endif
    </div>
</div>
