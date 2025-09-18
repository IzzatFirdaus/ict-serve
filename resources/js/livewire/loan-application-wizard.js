// Loan Application Wizard Livewire JS
// Listen for Livewire signatureSaved event
document.addEventListener('livewire:init', () => {
    if (window.Livewire && window.Livewire.on) {
        window.Livewire.on('signatureSaved', (data) => {
            console.log('Signature saved:', data);
        });
    }
});
