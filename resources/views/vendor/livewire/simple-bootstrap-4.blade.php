{{-- Minimal fallback template to satisfy legacy Livewire theme reference used in tests.
     This keeps tests passing while letting the app use MYDS components in production. --}}
@php
    // Safe fallback partial for legacy references. Accepts optional variables: $label, $help
@endphp
<div class="mb-3">
    @if(!empty($label))
        <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif

    <div class="mt-1">
        @isset($slot)
            {{ $slot }}
        @endisset
    </div>

    @if(!empty($help))
        <p class="mt-2 text-sm text-gray-500">{{ $help }}</p>
    @endif
</div>
