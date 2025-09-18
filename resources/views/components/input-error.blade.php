{{--
  ICTServe (iServe) Input Error Component
  MYDS & MyGovEA Compliance:
    - Uses MYDS inline error pattern: red text, danger icon, 8px vertical spacing (see MYDS-Design-Overview.md, Forms/Input Fields/Error Handling).
    - Colours: text-txt-danger, icon text-danger-600 (see MYDS-Colour-Reference.md).
    - Icon: MYDS "exclamation-circle" 20x20, 1.5px stroke (see MYDS-Icons-Overview.md).
    - Accessibility: role="alert", aria-live, clear error messaging.
    - Typography: Inter, text-sm, font-medium.
    - Minimal, citizen-centric, error prevention/prioritization (prinsip-reka-bentuk-mygovea.md).
--}}

@props(['messages'])

@if ($messages)
    <ul
        {{ $attributes->merge([
            'class' => 'mt-1 text-sm font-medium text-txt-danger space-y-1 flex flex-col',
            'role' => 'alert',
            'aria-live' => 'polite'
        ]) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-start gap-2">
                {{-- MYDS exclamation-circle icon (20x20, 1.5px stroke) --}}
                <svg class="flex-shrink-0 w-5 h-5 text-danger-600 mt-0.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" focusable="false">
                    <circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <path d="M10 7v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <circle cx="10" cy="14" r="1" fill="currentColor"/>
                </svg>
                <span>{{ $message }}</span>
            </li>
        @endforeach
    </ul>
@endif
