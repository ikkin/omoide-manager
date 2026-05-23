@props(['field', 'class' => 'text-red-500 text-sm'])

@error($field)
    <p class="{{ $class }}">{{ $message }}</p>
@enderror