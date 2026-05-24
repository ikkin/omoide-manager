@props(['label', 'required' => false , 'class' => 'font-semibold bg-[#E2EBB7] px-2 py-1'])

<p class="{{ $class }}">
    {{ $label }}
    @if($required)
        <span class="text-sm text-[#FF0000] ml-1">＊</span>
    @endif
</p>