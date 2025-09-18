{{--
  ICTServe (iServe) Input Label Component
  MYDS & MyGovEA Compliance:
    - Follows MYDS form label standards: aligned top-left, Inter font, font-medium, text-sm, text-txt-black-900 (see MYDS-Design-Overview.md, MYDS-Develop-Overview.md).
    - Required mark: strong visual indicator using text-txt-danger and aria-label="required" for accessibility.
    - Spacing: 4px bottom margin (MYDS spacing), as per field-label gap.
    - Handles both string and slot content for flexibility.
    - Accessibility: Always associated with an input via "for" (when used with matching id).
    - Minimal, clear, and citizen-centric (prinsip-reka-bentuk-mygovea.md).
--}}

@props([
    'value' => null,
    'required' => false,
    // Optionally allow passing a custom id for 'for' attribute in parent usage
])

<label {{ $attributes->merge(['class' => 'block mb-1 text-sm font-medium text-txt-black-900']) }}>
    @if($value)
        {{ $value }}
    @else
        {{ $slot }}
    @endif
    @if($required)
        <span class="text-txt-danger ml-1 align-middle" aria-label="required" title="Required">*</span>
    @endif
</label>
