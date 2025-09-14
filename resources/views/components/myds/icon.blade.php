{{-- MYDS Icon Wrapper Component --}}
<span {{ $attributes->merge([
    'class' => "inline-flex items-center justify-center",
    'aria-hidden' => 'true',
    'role' => 'presentation',
    'style' => "width:" . ($size ? $size : 20) . "px;height:" . ($size ? $size : 20) . "px;"
]) }}>
    {!! $svg !!}
</span>
