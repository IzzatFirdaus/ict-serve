{{--
  Livewire Legacy Theme Fallback (MYDS Styled)
  ============================================
  
  Purpose:
  This file serves as a minimal template to satisfy legacy Livewire theme references
  that might still be present in automated tests or older, unmigrated components.
  Its existence prevents tests from failing due to a missing view file.
  
  Styling:
  While its primary role is functional, the styling has been updated to use MYDS
  (Malaysia Government Design System) tokens for colors and spacing. This ensures that if the
  component is ever rendered in the browser, it will not appear visually broken and
  will maintain consistency with the rest of the application's UI.
  
  
  
  Usage:
  This component is not intended for active development. New forms and components
  should use the proper MYDS-compliant structures directly. It simply wraps
  a slotted input with an optional label and help text.
--}}
@php
  // This is a safe fallback partial for legacy references.
  // It accepts optional variables: $label, $help.
@endphp

{{-- The main wrapper uses a standard MYDS bottom margin for consistent vertical rhythm. --}}
<div class="mb-4">
  {{-- Label: Styled using MYDS text color tokens and typography. --}}
  @if (! empty($label))
    <label
      class="block text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
    >
      {{ $label }}
    </label>
  @endif

  {{-- Slot: This is where the actual input element (e.g., <input>, <select>) will be rendered. --}}
  <div class="mt-1">
    @isset($slot)
      {{ $slot }}
    @endisset
  </div>

  {{-- Help Text: Styled using MYDS secondary text color tokens. --}}
  @if (! empty($help))
    <p class="mt-2 text-sm text-txt-black-500 dark:text-txt-black-400">
      {{ $help }}
    </p>
  @endif
</div>
