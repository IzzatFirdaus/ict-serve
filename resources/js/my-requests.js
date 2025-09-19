/**
 * ICTServe (iServe) - My Requests Page Scripts
 * ============================================
 * This file contains the client-side logic for the "My Requests" page.
 * It defines an Alpine.js component to handle the digital signature pad functionality,
 * allowing it to communicate seamlessly with the Livewire backend component.
 */

// We assume Alpine.js is loaded globally.
// We listen for the 'alpine:init' event to safely register our component.
document.addEventListener('alpine:init', () => {
  /**
   * Alpine.js component for managing a Signature Pad canvas.
   * * @param {object} livewireComponent - The Livewire component instance, passed via `@this` or `$wire`.
   */
  Alpine.data('signaturePad', (livewireComponent) => ({
    signaturePadInstance: null,

    /**
     * Initializes the signature pad on the canvas element.
     * This is called automatically by Alpine's x-init directive.
     */
    init() {
      const canvas = this.$refs.signatureCanvas;
      if (!canvas) {
        console.error('Signature canvas not found.');
        return;
      }

      // Adjust canvas for high DPI screens to ensure crisp signatures
      const ratio = Math.max(window.devicePixelRatio || 1, 1);
      canvas.width = canvas.offsetWidth * ratio;
      canvas.height = canvas.offsetHeight * ratio;
      canvas.getContext('2d').scale(ratio, ratio);

      this.signaturePadInstance = new SignaturePad(canvas, {
        backgroundColor: 'rgba(0, 0, 0, 0)', // Transparent background
        // Pen color adapts to light/dark mode for visibility
        penColor: document.documentElement.classList.contains('dark')
          ? 'white'
          : 'black',
      });

      // Resize canvas when window is resized to maintain responsiveness
      window.addEventListener('resize', () => this.resizeCanvas());
    },

    /**
     * Clears the signature from the canvas.
     */
    clearSignature() {
      this.signaturePadInstance.clear();
    },

    /**
     * Saves the signature as a base64-encoded PNG and sends it to the Livewire component.
     */
    saveSignature() {
      if (this.signaturePadInstance.isEmpty()) {
        alert('Sila berikan tandatangan terlebih dahulu.');
        return;
      }

      // Get the signature as a data URL
      const dataURL = this.signaturePadInstance.toDataURL('image/png');

      // Send the signature data to the Livewire component's `signatureData` property
      livewireComponent.set('signatureData', dataURL);

      // Optionally, call a method on the Livewire component after setting the data
      livewireComponent.call('saveSignature');

      alert('Tandatangan telah disimpan!');
    },

    /**
     * Helper function to resize the canvas if the window size changes.
     */
    resizeCanvas() {
      const canvas = this.$refs.signatureCanvas;
      const ratio = Math.max(window.devicePixelRatio || 1, 1);
      canvas.width = canvas.offsetWidth * ratio;
      canvas.height = canvas.offsetHeight * ratio;
      canvas.getContext('2d').scale(ratio, ratio);
      this.signaturePadInstance.clear(); // Clearing is necessary on resize
    },
  }));
});
