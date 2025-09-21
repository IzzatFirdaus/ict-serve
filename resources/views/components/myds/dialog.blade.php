@props(['title' => '', 'open' => false])
<div {{ $attributes->merge(['class' => 'myds-dialog']) }} role="dialog" aria-modal="true">
    @if($title)
        <div class="myds-dialog-header">
            <h3>{{ $title }}</h3>
        </div>
    @endif
    <div class="myds-dialog-body">
        {{ $slot }}
    </div>
</div>
