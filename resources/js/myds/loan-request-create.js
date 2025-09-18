// resources/js/myds/loan-request-create.js

document.addEventListener('DOMContentLoaded', function() {
    // --- Category filter logic (old and new) ---
    var category = document.getElementById('category');
    if (category) {
        category.addEventListener('change', function() {
            var selected = this.value;
            var subcategories = document.querySelectorAll('.subcategory');
            subcategories.forEach(function(sub) {
                if (sub.dataset.category === selected) {
                    sub.classList.remove('hidden');
                } else {
                    sub.classList.add('hidden');
                }
            });
        });
    }

    // --- Equipment Category Filter (from Blade) ---
    const categoryFilter = document.getElementById('category-filter');
    const equipmentItems = document.querySelectorAll('.equipment-item');
    if (categoryFilter && equipmentItems.length > 0) {
        categoryFilter.addEventListener('change', function() {
            const selectedCategory = this.value;
            equipmentItems.forEach(item => {
                if (selectedCategory === '' || item.dataset.category === selectedCategory) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // --- Form validation (old) ---
    var loanForm = document.getElementById('loanForm');
    if (loanForm) {
        loanForm.addEventListener('submit', function(e) {
            var requiredFields = document.querySelectorAll('[required]');
            var valid = true;
            requiredFields.forEach(function(field) {
                if (!field.value) {
                    valid = false;
                    field.classList.add('border-danger-600');
                } else {
                    field.classList.remove('border-danger-600');
                }
            });
            if (!valid) {
                e.preventDefault();
                var formError = document.getElementById('formError');
                if (formError) {
                    formError.classList.remove('hidden');
                }
            }
        });
    }

    // --- Form validation and submission (from Blade) ---
    const form = document.getElementById('loan-request-form');
    const submitBtn = document.getElementById('submit-btn');
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            // Check if at least one equipment item is selected
            const selectedItems = document.querySelectorAll('input[name="equipment_items[]"]:checked');
            if (selectedItems.length === 0) {
                e.preventDefault();
                alert('Sila pilih sekurang-kurangnya satu peralatan untuk permohonan pinjaman anda.');
                return;
            }
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.querySelector('.submit-text').classList.add('hidden');
            submitBtn.querySelector('.loading-text').classList.remove('hidden');
        });
    }

    // --- Date validation (old) ---
    var startDate = document.getElementById('start_date');
    var endDate = document.getElementById('end_date');
    var dateError = document.getElementById('dateError');
    if (startDate && endDate && dateError) {
        startDate.addEventListener('change', function() {
            var start = new Date(this.value);
            var end = new Date(endDate.value);
            if (end && start > end) {
                dateError.classList.remove('hidden');
            } else {
                dateError.classList.add('hidden');
            }
        });
        endDate.addEventListener('change', function() {
            var start = new Date(startDate.value);
            var end = new Date(this.value);
            if (start && end < start) {
                dateError.classList.remove('hidden');
            } else {
                dateError.classList.add('hidden');
            }
        });
    }

    // --- Date validation (from Blade) ---
    const startDateInput = document.getElementById('loan_start_date');
    const endDateInput = document.getElementById('loan_end_date');
    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            const startDate = new Date(this.value);
            const minEndDate = new Date(startDate);
            minEndDate.setDate(minEndDate.getDate() + 1);
            endDateInput.min = minEndDate.toISOString().split('T')[0];
            if (endDateInput.value && new Date(endDateInput.value) <= startDate) {
                endDateInput.value = minEndDate.toISOString().split('T')[0];
            }
        });
    }
});
