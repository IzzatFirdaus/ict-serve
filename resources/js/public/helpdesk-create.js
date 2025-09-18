document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('helpdesk-form');
    const submitBtn = document.getElementById('submit-btn');
    const attachmentsInput = document.getElementById('attachments');
    const fileList = document.getElementById('file-list');

    // File upload handling
    attachmentsInput.addEventListener('change', function() {
        fileList.innerHTML = '';

        if (this.files.length > 5) {
            alert('Maximum 5 files allowed');
            this.value = '';
            return;
        }

        Array.from(this.files).forEach(file => {
            if (file.size > 10 * 1024 * 1024) {
                alert(`File ${file.name} exceeds 10MB limit`);
                this.value = '';
                fileList.innerHTML = '';
                return;
            }

            const fileItem = document.createElement('div');
            fileItem.className = 'flex items-center justify-between p-2 bg-gray-100 rounded';
            fileItem.innerHTML = `
                <span class="text-sm text-gray-700">${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)</span>
                <button type="button" class="text-danger-500 hover:text-danger-700" onclick="this.parentElement.remove(); updateFileInput();">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            fileList.appendChild(fileItem);
        });
    });

    // Priority change handling
    document.getElementById('priority').addEventListener('change', function() {
        if (this.value === 'urgent') {
            if (!confirm('For urgent issues, please consider calling our emergency hotline for faster response. Continue with ticket submission?')) {
                this.value = 'high';
            }
        }
    });

    // Form submission handling
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.querySelector('.submit-text').classList.add('hidden');
        submitBtn.querySelector('.loading-text').classList.remove('hidden');
    });
});

function updateFileInput() {
    const fileList = document.getElementById('file-list');
    const attachmentsInput = document.getElementById('attachments');

    if (fileList.children.length === 0) {
        attachmentsInput.value = '';
    }
}
