<div
  {{ $attributes->merge([
    'class' => "p-4 rounded-md shadow-md bg-" . ($type === 'success' ? 'success-100' : ($type === 'error' ? 'danger-100' : 'warning-100')) . " text-" . ($type === 'success' ? 'success-800' : ($type === 'error' ? 'danger-800' : 'warning-800')),
    'role' => 'alert',
    'aria-live' => $type === 'error' ? 'assertive' : 'polite',
  ]) }}
>
  <p class="text-sm">
    @if ($icon)
      <span class="mr-2">{{ $icon }}</span>
    @endif
    {{ __($slot) }}
  </p>
</div>
