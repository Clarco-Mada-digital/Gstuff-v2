@props([
    'name' => 'categorie',
    'label' => 'Catégorie',
    'categories' => [],
    'selected' => null,
    'required' => false,
    'containerClass' => 'col-span-2 md:col-span-1',
    'selectClass' => '',
])

<x-form.select
    :name="$name"
    :label="$label"
    :selected="$selected"
    :required="$required"
    :containerClass="$containerClass"
    :selectClass="$selectClass"
    {{ $attributes->merge(['class' => 'w-full']) }}
>
    <option value="" {{ $required ? 'disabled' : '' }} {{ $selected === null ? 'selected' : '' }}>--</option>
    @foreach($categories as $category)
        @if(is_array($category))
            <option value="{{ $category['id'] ?? $category['value'] }}" {{ $selected == ($category['id'] ?? $category['value']) ? 'selected' : '' }}>
                {{ $category['nom'] ?? $category['label'] ?? $category['name'] }}
            </option>
        @else
            <option value="{{ $category->id }}" {{ $selected == $category->id ? 'selected' : '' }}>
                {{ $category->nom ?? $category->name ?? $category->label }}
            </option>
        @endif
    @endforeach
</x-form.select>
