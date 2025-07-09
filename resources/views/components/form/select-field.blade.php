@props([
    'name',
    'label',
    'options' => [],
    'optionValue' => 'id',
    'optionLabel' => 'nom',
    'translatable' => false, // Si vrai, utilise getTranslation
    'translationKey' => 'name', // Clé de traduction par défaut
    'translationParams' => null, // Paramètres pour la traduction (ex: ['price' => 100])
    'selected' => null,
    'required' => false,
    'placeholder' => '--',
    'containerClass' => 'mb-4',
    'selectClass' => '',
    'labelClass' => 'block text-sm font-roboto-slab text-green-gs',
])

<div class="{{ $containerClass }}">
    @if($label)
        <label for="{{ $name }}" class="{{ $labelClass }}">
            {{ $label }}
       
        </label>
    @endif
    
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'mt-1 block w-full text-textColorParagraph rounded-md border border-supaGirlRosePastel/50 font-roboto-slab shadow-sm focus:border-green-gs focus:ring-green-gs ' . $selectClass]) }}
    >
        <option value="" {{ $required ? 'disabled' : '' }} {{ $selected === null ? 'selected' : '' }}>
            {{ $placeholder }}
        </option>
        
        @foreach($options as $option)
            @php
                $value = is_array($option) ? ($option[$optionValue] ?? $option) : ($option->{$optionValue} ?? $option);
                
                // Gestion du label avec ou sans traduction
                if ($translatable) {
                    if (is_object($option) && method_exists($option, 'getTranslation')) {
                        $label = $option->getTranslation($translationKey, app()->getLocale());
                    } elseif (is_string($option) && $translationParams) {
                        // Cas spécial pour les traductions avec paramètres (comme les tarifs)
                        $label = __($option, ['price' => $value]);
                    } else {
                        $label = $option;
                    }
                } else {
                    $label = is_array($option) 
                        ? ($option[$optionLabel] ?? $value) 
                        : ($option->{$optionLabel} ?? $option);
                }
                
                $isSelected = $selected !== null && (string)$selected === (string)$value;
            @endphp
            
            <option value="{{ $value }}" {{ $isSelected ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
        
        {{ $slot }}
    </select>
    
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
