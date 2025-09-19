{{--
  ICTServe (iServe) Signature Pad Component
  Uses: signature_pad library for enhanced touch/mouse drawing support
  MYDS & MyGovEA Compliance:
    - Layout: Uses MYDS card (bg-bg-white, border-otl-divider, rounded-lg, shadow-card, p-6) for signature area.
    - Typography: Inter for body text, Poppins for headings. text-sm for label/hint, text-txt-black-900 for label.
    - Colour: All backgrounds, borders, text, buttons use MYDS tokens (see MYDS-Colour-Reference.md).
    - Button: Primary and secondary buttons use MYDS tokens and states, radius-m, shadow-button.
    - Icon: Uses MYDS "edit" (pen) icon in signature area, and "refresh" icon for clear, both 20x20, stroke 1.5px (see MYDS-Icons-Overview.md).
    - Accessibility: Keyboard focusable, ARIA labels, visible focus ring, high-contrast text and controls.
    - Responsive: Fills container, uses 12/8/4 grid spacing.
    - Error prevention: Inline error callout below pad if validation fails.
    - Minimal, clear, citizen-centric (prinsip-reka-bentuk-mygovea.md).
    - Mobile: Touch-friendly, minimum height 180px, large clear/hint button.
--}}

@props([
    'label' => 'Digital Signature',
    'hint' => 'Sign in the box below using your mouse or touch. Ensure your signature is clear and matches your official record.',
    'required' => false,
    'name' => 'signature',
    'value' => null, // base64 PNG or null
    'error' => null,
    'readonly' => false,
    'height' => 180,
    'class' => '',
])

@php
    $uid = 'signature_' . uniqid();
    $readonly = filter_var($readonly, FILTER_VALIDATE_BOOLEAN);
@endphp

<div class="bg-bg-white rounded-lg shadow-card border border-otl-divider p-6 {{ $class }}">
    <label class="block text-sm font-medium text-txt-black-900 font-poppins mb-2" for="{{ $uid }}">
        {{ $label }}
        @if($required)
            <span class="text-txt-danger ml-1" aria-label="required" title="Required">*</span>
        @endif
    </label>
    @if($hint)
        <div class="text-xs text-txt-black-500 mb-3">{{ $hint }}</div>
    @endif

    <div
        x-data="{
            signaturePad: null, // reference to signature_pad library instance
            isDrawing: false,
            lastPoint: null,
            hasSignature: {{ $value ? 'true' : 'false' }},
            clearPad() {
                if (this.signaturePad) {
                    this.signaturePad.clear();
                } else {
                    const c = this.$refs.signaturePad;
                    const ctx = c.getContext('2d');
                    ctx.clearRect(0, 0, c.width, c.height);
                }
                this.hasSignature = false;
                @this.set('{{ $name }}', '');
            },
            startDraw(e) {
                if ({{ $readonly ? 'true' : 'false' }}) return;
                this.isDrawing = true;
                const rect = this.$refs.signaturePad.getBoundingClientRect();
                this.lastPoint = this.getPoint(e, rect);
            },
            draw(e) {
                if (!this.isDrawing || {{ $readonly ? 'true' : 'false' }}) return;
                const c = this.$refs.signaturePad;
                const ctx = c.getContext('2d');
                ctx.strokeStyle = '#18181B'; // MYDS gray-900
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                const rect = c.getBoundingClientRect();
                const point = this.getPoint(e, rect);

                ctx.beginPath();
                ctx.moveTo(this.lastPoint.x, this.lastPoint.y);
                ctx.lineTo(point.x, point.y);
                ctx.stroke();
                this.lastPoint = point;
                this.hasSignature = true;
            },
            endDraw() {
                if (!this.isDrawing) return;
                this.isDrawing = false;
                // Save as base64 PNG to Livewire (if present) or hidden input
                const c = this.$refs.signaturePad;
                const dataUrl = c.toDataURL('image/png');
                @this && @this.set('{{ $name }}', dataUrl);
                // For non-Livewire use, update hidden input
                if (document.getElementById('{{ $uid }}-input')) {
                    document.getElementById('{{ $uid }}-input').value = dataUrl;
                }
            },
            getPoint(e, rect) {
                let clientX, clientY;
                if (e.touches?.length) {
                    clientX = e.touches[0].clientX;
                    clientY = e.touches[0].clientY;
                } else {
                    clientX = e.clientX;
                    clientY = e.clientY;
                }
                return {
                    x: clientX - rect.left,
                    y: clientY - rect.top
                };
            },
            fillPadIfValue() {
                if (this.hasSignature && '{{ $value }}') {
                    const c = this.$refs.signaturePad;
                    const ctx = c.getContext('2d');
                    const img = new window.Image();
                    img.onload = function() {
                        ctx.clearRect(0, 0, c.width, c.height);
                        ctx.drawImage(img, 0, 0, c.width, c.height);
                    };
                    img.src = '{{ $value }}';
                }
            },
        }"
        x-init="fillPadIfValue()"
        class="relative border border-otl-gray-300 rounded-md bg-washed focus-within:ring-2 focus-within:ring-fr-primary"
        tabindex="0"
        aria-label="{{ $label }}"
        aria-required="{{ $required ? 'true' : 'false' }}"
        aria-invalid="{{ $error ? 'true' : 'false' }}"
        role="region"
        style="outline: none;"
    >
        <canvas
            x-ref="signaturePad"
            id="{{ $uid }}"
            width="600"
            height="{{ $height }}"
            class="w-full max-w-full h-[{{ $height }}px] min-h-[120px] touch-manipulation bg-bg-white rounded-md"
            style="cursor: {{ $readonly ? 'not-allowed' : 'crosshair' }}; background-color: #fff;"
            @mousedown="startDraw($event)"
            @mousemove="draw($event)"
            @mouseup="endDraw()"
            @mouseleave="isDrawing && endDraw()"
            @touchstart.prevent="startDraw($event)"
            @touchmove.prevent="draw($event)"
            @touchend="endDraw()"
            aria-label="{{ $label }}"
            {{ $readonly ? 'tabindex=-1' : '' }}
        >
            {{ __('Your browser does not support the HTML5 canvas element.') }}
        </canvas>
        @if(!$readonly)
            <button
                type="button"
                @click="clearPad()"
                class="absolute top-3 right-3 flex items-center px-2 py-1 bg-white text-txt-black-700 border border-otl-divider rounded-md shadow-button hover:bg-bg-gray-50 focus-visible:ring-2 focus-visible:ring-fr-primary transition-colors"
                aria-label="Clear signature"
            >
                {{-- MYDS refresh icon --}}
                <svg class="w-5 h-5 mr-1" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" focusable="false">
                    <path d="M4.5 10a5.5 5.5 0 0 1 9-4.2M15.5 10a5.5 5.5 0 0 1-9 4.2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <path d="M13.5 5.5v2h2M6.5 14.5v-2h-2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <span class="text-xs font-medium">Clear</span>
            </button>
        @endif
        @if($readonly && $value)
            {{-- Show icon overlay for "view" --}}
            <div class="absolute top-3 left-3 flex items-center text-txt-primary">
                {{-- MYDS edit (pen) icon --}}
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" focusable="false">
                    <path d="M14.8 4.8a2 2 0 1 1 2.8 2.8L8 17.5 4 18.5l1-4L14.8 4.8z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                </svg>
                <span class="ml-1 text-xs">View only</span>
            </div>
        @endif
    </div>

    {{-- For Livewire or standard form: store as base64 PNG --}}
    <input type="hidden" id="{{ $uid }}-input" name="{{ $name }}" value="{{ $value }}">

    @if($error)
        <div class="mt-2" role="alert" aria-live="polite">
            <div class="flex items-start gap-2 text-sm text-txt-danger">
                <svg class="w-5 h-5 text-danger-600 mt-0.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" focusable="false">
                    <circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <path d="M10 7v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <circle cx="10" cy="14" r="1" fill="currentColor"/>
                </svg>
                <span>{{ $error }}</span>
            </div>
        </div>
    @endif
</div>
