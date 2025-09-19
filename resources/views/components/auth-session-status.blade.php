{{--
  ICTServe (iServe) Auth Session Status Component
  MYDS & MyGovEA Compliance:
  - Uses MYDS Callout/Alert pattern for session status feedback (see MYDS-Design-Overview.md, MYDS-Develop-Overview.md).
  - Semantic colour: Success state uses bg-success-50, border-success-200, txt-success-700 (see MYDS-Colour-Reference.md).
  - Icon: Uses MYDS success/check-circle icon, 20x20, with accessible label (see MYDS-Icons-Overview.md).
  - Accessible: role="status", aria-live, visible focus states, and notifies screen readers.
  - Spacing and radius: MYDS spacing (gap-2, px-4, py-3), 8px (rounded-md/radius-m).
  - Typography: Inter font, text-sm, font-medium (MYDS body text).
  - Minimalism & clarity: Citizen-centric, clear feedback, no unnecessary decoration (prinsip-reka-bentuk-mygovea.md).
--}}

@props([
  'status',
])

@if ($status)
  <div
    {{
      $attributes->merge([
        'class' => 'flex items-start gap-2 px-4 py-3 bg-success-50 border border-success-200 text-success-700 rounded-md font-medium text-sm',
        'role' => 'status',
        'aria-live' => 'polite',
      ])
    }}
  >
    {{-- MYDS check-circle icon (20x20, stroke 1.5) --}}
    <svg
      class="flex-shrink-0 w-5 h-5 mt-0.5 text-success-600"
      viewBox="0 0 20 20"
      fill="none"
      stroke="currentColor"
      stroke-width="1.5"
      aria-hidden="true"
      focusable="false"
    >
      <title>Status Berjaya</title>
      <circle
        cx="10"
        cy="10"
        r="9"
        stroke="currentColor"
        stroke-width="1.5"
        fill="none"
      />
      <path
        d="M7 10.5l2 2 4-4"
        stroke="currentColor"
        stroke-width="1.5"
        stroke-linecap="round"
        stroke-linejoin="round"
        fill="none"
      />
    </svg>
    <span class="flex-1">{{ $status }}</span>
  </div>
@endif
