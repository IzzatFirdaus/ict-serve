/**
 * Equipment Loan Request Form Interactions
 * Handles dynamic equipment addition/removal and form validation
 */
document.addEventListener('DOMContentLoaded', function() {
    let equipmentCount = 1;
    const addButton = document.getElementById('add-equipment');
    const container = document.getElementById('equipment-requests');

    // Equipment template for dynamic addition
    const equipmentTemplate = `
        <div class="equipment-request border border-otl-gray-200 rounded-[var(--radius-m)] p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="myds-body-lg font-medium">Equipment #__INDEX__</h3>
                <button type="button" class="remove-equipment text-txt-danger hover:text-txt-danger">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="myds-grid-12">
                <div class="col-span-full md:col-span-8">
                    <label class="block myds-body-sm font-medium text-txt-black-700">Equipment <span class="text-txt-danger">*</span></label>
                    <select name="equipment_requests[__COUNT__][equipment_id]" required class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-primary">
                        <option value="">Select equipment...</option>
                        ${getEquipmentOptions()}
                    </select>
                </div>
                <div class="col-span-full md:col-span-4">
                    <label class="block myds-body-sm font-medium text-txt-black-700">Quantity <span class="text-txt-danger">*</span></label>
                    <input type="number" name="equipment_requests[__COUNT__][quantity]" min="1" value="1" required class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-primary">
                </div>
            </div>
            <div class="mt-4">
                <label class="block myds-body-sm font-medium text-txt-black-700">Notes</label>
                <textarea name="equipment_requests[__COUNT__][notes]" rows="2" class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-primary" placeholder="Additional notes for this equipment..."></textarea>
            </div>
        </div>
    `;

    // Get equipment options from the first select element
    function getEquipmentOptions() {
        const firstSelect = container.querySelector('select[name="equipment_requests[0][equipment_id]"]');
        return firstSelect ? firstSelect.innerHTML.replace(/equipment_requests\[0\]/, 'equipment_requests[__COUNT__]') : '';
    }

    // Add equipment handler
    if (addButton) {
        addButton.addEventListener('click', function() {
            equipmentCount++;
            const newEquipment = equipmentTemplate
                .replace(/__COUNT__/g, equipmentCount - 1)
                .replace(/__INDEX__/g, equipmentCount);

            container.insertAdjacentHTML('beforeend', newEquipment);
            updateRemoveButtons();
        });
    }

    // Remove equipment handler
    if (container) {
        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-equipment')) {
                e.target.closest('.equipment-request').remove();
                updateIndexes();
                updateRemoveButtons();
            }
        });
    }

    // Update remove button visibility
    function updateRemoveButtons() {
        const requests = container.querySelectorAll('.equipment-request');
        requests.forEach((request, index) => {
            const removeBtn = request.querySelector('.remove-equipment');
            if (removeBtn) {
                if (requests.length > 1) {
                    removeBtn.classList.remove('hidden');
                } else {
                    removeBtn.classList.add('hidden');
                }
            }
        });
    }

    // Update equipment indexes after removal
    function updateIndexes() {
        const requests = container.querySelectorAll('.equipment-request');
        requests.forEach((request, index) => {
            const title = request.querySelector('h3');
            if (title) {
                title.textContent = `Equipment #${index + 1}`;
            }

            // Update form field names
            const fields = request.querySelectorAll('[name^="equipment_requests"]');
            fields.forEach(field => {
                const name = field.getAttribute('name');
                if (name) {
                    field.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                }
            });
        });
    }

    // Same as applicant checkbox functionality
    const sameAsApplicantCheckbox = document.querySelector('input[name="same_as_applicant"]');
    const responsibleOfficerFields = [
        document.getElementById('responsible_officer_name'),
        document.getElementById('responsible_officer_position'),
        document.getElementById('responsible_officer_phone')
    ];

    if (sameAsApplicantCheckbox && responsibleOfficerFields.every(field => field)) {
        sameAsApplicantCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // Get user data from authenticated user (these would be passed from Laravel)
                const userData = window.authUserData || {};

                responsibleOfficerFields[0].value = userData.name || '';
                responsibleOfficerFields[1].value = userData.position || '';
                responsibleOfficerFields[2].value = userData.phone || '';

                responsibleOfficerFields.forEach(field => {
                    field.readOnly = true;
                    field.classList.add('bg-bg-gray-50');
                });
            } else {
                responsibleOfficerFields.forEach(field => {
                    field.value = '';
                    field.readOnly = false;
                    field.classList.remove('bg-bg-gray-50');
                });
            }
        });
    }

    // Date validation
    const fromDate = document.getElementById('requested_from');
    const toDate = document.getElementById('requested_to');

    if (fromDate && toDate) {
        fromDate.addEventListener('change', function() {
            toDate.min = this.value;
            if (toDate.value && toDate.value <= this.value) {
                toDate.value = '';
            }
        });
    }

    // Initialize
    updateRemoveButtons();
});
