@props([
    'wireModel' => null,
    'label' => 'Signature',
    'required' => false,
    'height' => '200px',
    'width' => '100%'
])

<div {{ $attributes->merge(['class' => 'signature-pad-wrapper']) }} wire:ignore>
    <div x-data="{
        signaturePadId: $id('signature'),
        signaturePad: null,
        signature: @if($wireModel) @entangle($wireModel) @else null @endif,
        ratio: null,
        isEmpty: true,

        init() {
            this.resizeCanvas();
            this.signaturePad = new SignaturePad(this.$refs.canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)',
                minWidth: 0.5,
                maxWidth: 2.5,
                throttle: 16,
                minDistance: 5,
            });

            this.signaturePad.addEventListener('beginStroke', () => {
                this.isEmpty = false;
            });

            this.signaturePad.addEventListener('endStroke', () => {
                this.save();
            });

            if (this.signature) {
                this.signaturePad.fromDataURL(this.signature, {
                    ratio: this.ratio
                });
                this.isEmpty = this.signaturePad.isEmpty();
            }
        },

        save() {
            if (!this.signaturePad.isEmpty()) {
                this.signature = this.signaturePad.toDataURL('image/png');
                this.isEmpty = false;
                this.$dispatch('signature-saved', {
                    id: this.signaturePadId,
                    signature: this.signature
                });
            }
        },

        clear() {
            this.signaturePad.clear();
            this.signature = null;
            this.isEmpty = true;
            this.$dispatch('signature-cleared', { id: this.signaturePadId });
        },

        resizeCanvas() {
            this.ratio = Math.max(window.devicePixelRatio || 1, 1);
            this.$refs.canvas.width = this.$refs.canvas.offsetWidth * this.ratio;
            this.$refs.canvas.height = this.$refs.canvas.offsetHeight * this.ratio;
            this.$refs.canvas.getContext('2d').scale(this.ratio, this.ratio);
        }
    }"
    @resize.window="resizeCanvas"
    class="space-y-3">

        <!-- Label -->
        @if($label)
        <label class="myds-label">
            {{ $label }}
            @if($required)
                <span class="text-danger-600 ml-1">*</span>
            @endif
        </label>
        @endif

        <!-- Canvas Container -->
        <div class="relative border-2 border-otl-gray-300 border-dashed rounded-lg bg-bg-white"
             x-bind:style="{ height: '{{ $height }}' }">
            <canvas
                x-ref="canvas"
                class="w-full h-full cursor-crosshair touch-none"
                x-bind:style="{ width: '{{ $width }}', height: '{{ $height }}' }">
            </canvas>

            <!-- Empty State Message -->
            <div x-show="isEmpty"
                 class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="text-center text-txt-black-500">
                    <svg class="mx-auto h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    <p class="text-sm">Click and drag to sign</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between">
            <div class="flex space-x-2">
                <button type="button"
                        x-on:click="clear()"
                        class="myds-btn-outline-danger myds-btn-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Clear
                </button>
            </div>

            <!-- Status Indicator -->
            <div class="flex items-center space-x-2">
                <span x-show="!isEmpty"
                      x-transition
                      class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-success-100 text-success-800">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                              clip-rule="evenodd" />
                    </svg>
                    Signed
                </span>

            <span x-show="isEmpty"
                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-black-100 text-txt-black-700">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd" />
                    </svg>
                    Not signed
                </span>
            </div>
        </div>

        <!-- Notification -->
        <div x-data="{
            show: false,
            message: '',
            type: 'success',

            showNotification(message, type = 'success') {
                this.message = message;
                this.type = type;
                this.show = true;
                setTimeout(() => { this.show = false }, 2000);
            }
        }"
        @signature-saved.window="if ($event.detail.id === signaturePadId) showNotification('Signature saved successfully')"
        @signature-cleared.window="if ($event.detail.id === signaturePadId) showNotification('Signature cleared', 'info')">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform translate-y-2"
                 :class="{
                     'bg-success-50 border-success-200 text-success-700': type === 'success',
                     'bg-primary-50 border-otl-primary-300 text-txt-primary': type === 'info'
                 }"
                 class="mt-2 border rounded-md p-2 text-sm font-medium"
                 x-cloak>
                <span x-text="message"></span>
            </div>
        </div>
    </div>
</div>

@pushonce('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
@endpushonce
