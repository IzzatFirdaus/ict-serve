<div class="myds-container myds-py-6">
    <!-- Page Header -->
    <div class="mb-6">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="myds-breadcrumb">
                <li class="myds-breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="myds-link">
                        Papan Pemuka / Dashboard
                    </a>
                </li>
                <li class="myds-breadcrumb-item">
                    <a href="#" class="myds-link">
                        Pentadbiran / Administration
                    </a>
                </li>
                <li class="myds-breadcrumb-item myds-breadcrumb-current" aria-current="page">
                    Pengurusan Jenis Kerosakan / Damage Type Management
                </li>
            </ol>
        </nav>

        <!-- Page Title -->
        <div class="myds-page-header">
            <h1 class="myds-heading-xl text-myds-gray-900 dark:text-myds-gray-100">
                <i class="myds-icon-cog mr-3" aria-hidden="true"></i>
                Pengurusan Jenis Kerosakan
            </h1>
            <p class="myds-text-body-lg text-myds-gray-600 dark:text-myds-gray-400 mt-2">
                Damage Type Management
            </p>
            <p class="myds-text-body-md text-myds-gray-600 dark:text-myds-gray-400 mt-4">
                Urus dan kemaskini senarai jenis kerosakan untuk dropdown dinamik dalam sistem bantuan teknikal.
                <br>
                Manage and update the list of damage types for dynamic dropdowns in the technical support system.
            </p>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="myds-alert myds-alert-success mb-6" role="alert">
            <i class="myds-icon-check-circle" aria-hidden="true"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="myds-alert myds-alert-error mb-6" role="alert">
            <i class="myds-icon-exclamation-circle" aria-hidden="true"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Toolbar -->
    <div class="myds-card myds-card-bordered mb-6">
        <div class="myds-card-body">
            <div class="myds-flex myds-justify-between myds-items-center myds-space-x-4">
                <!-- Search and Filters -->
                <div class="myds-flex myds-items-center myds-space-x-4 flex-1">
                    <!-- Search -->
                    <div class="flex-1 max-w-md">
                        <label for="search" class="sr-only">Cari / Search</label>
                        <div class="myds-input-group">
                            <div class="myds-input-group-prepend">
                                <i class="myds-icon-search myds-text-gray-400" aria-hidden="true"></i>
                            </div>
                            <input
                                type="search"
                                id="search"
                                wire:model.live.debounce.300ms="search"
                                class="myds-input"
                                placeholder="Cari jenis kerosakan... / Search damage types..."
                                autocomplete="off"
                            />
                        </div>
                    </div>

                    <!-- Severity Filter -->
                    <div>
                        <label for="severityFilter" class="sr-only">Tapis mengikut tahap / Filter by severity</label>
                        <select
                            id="severityFilter"
                            wire:model.live="severityFilter"
                            class="myds-select"
                        >
                            <option value="">Semua Tahap / All Severity</option>
                            <option value="low">Rendah / Low</option>
                            <option value="medium">Sederhana / Medium</option>
                            <option value="high">Tinggi / High</option>
                            <option value="critical">Kritikal / Critical</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="statusFilter" class="sr-only">Tapis mengikut status / Filter by status</label>
                        <select
                            id="statusFilter"
                            wire:model.live="statusFilter"
                            class="myds-select"
                        >
                            <option value="">Semua Status / All Status</option>
                            <option value="1">Aktif / Active</option>
                            <option value="0">Tidak Aktif / Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Add Button -->
                <button
                    type="button"
                    wire:click="create"
                    class="myds-button myds-button-primary"
                >
                    <i class="myds-icon-plus mr-2" aria-hidden="true"></i>
                    Tambah Jenis Kerosakan / Add Damage Type
                </button>
            </div>
        </div>
    </div>

    <!-- Form Modal/Card -->
    @if ($showForm)
        <div class="myds-card myds-card-elevated mb-6">
            <div class="myds-card-header">
                <h2 class="myds-heading-lg text-myds-gray-900 dark:text-myds-gray-100">
                    <i class="myds-icon-plus-circle mr-2" aria-hidden="true"></i>
                    @if ($editingId)
                        Kemaskini Jenis Kerosakan / Update Damage Type
                    @else
                        Tambah Jenis Kerosakan Baru / Add New Damage Type
                    @endif
                </h2>
            </div>

            <form wire:submit.prevent="save" class="myds-card-body">
                <div class="myds-form-grid">
                    <!-- Name (English) -->
                    <div>
                        <label for="name" class="myds-label myds-required">
                            Nama (Bahasa Inggeris) / Name (English)
                        </label>
                        <input
                            type="text"
                            id="name"
                            wire:model="name"
                            class="myds-input @error('name') myds-input-error @enderror"
                            placeholder="Hardware Malfunction"
                            maxlength="255"
                            required
                        />
                        @error('name')
                            <p class="myds-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name (Bahasa Malaysia) -->
                    <div>
                        <label for="name_bm" class="myds-label myds-required">
                            Nama (Bahasa Malaysia) / Name (Bahasa Malaysia)
                        </label>
                        <input
                            type="text"
                            id="name_bm"
                            wire:model="name_bm"
                            class="myds-input @error('name_bm') myds-input-error @enderror"
                            placeholder="Kerosakan Perkakasan"
                            maxlength="255"
                            required
                        />
                        @error('name_bm')
                            <p class="myds-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Severity -->
                    <div>
                        <label for="severity" class="myds-label myds-required">
                            Tahap Keterukan / Severity Level
                        </label>
                        <select
                            id="severity"
                            wire:model="severity"
                            class="myds-select @error('severity') myds-input-error @enderror"
                            required
                        >
                            <option value="low">Rendah / Low</option>
                            <option value="medium">Sederhana / Medium</option>
                            <option value="high">Tinggi / High</option>
                            <option value="critical">Kritikal / Critical</option>
                        </select>
                        @error('severity')
                            <p class="myds-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label for="sort_order" class="myds-label myds-required">
                            Turutan Paparan / Display Order
                        </label>
                        <input
                            type="number"
                            id="sort_order"
                            wire:model="sort_order"
                            class="myds-input @error('sort_order') myds-input-error @enderror"
                            min="0"
                            required
                        />
                        <p class="myds-help-text">
                            Nilai lebih kecil akan dipaparkan dahulu. / Lower values appear first.
                        </p>
                        @error('sort_order')
                            <p class="myds-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icon -->
                    <div>
                        <label for="icon" class="myds-label">
                            Ikon / Icon
                        </label>
                        <input
                            type="text"
                            id="icon"
                            wire:model="icon"
                            class="myds-input @error('icon') myds-input-error @enderror"
                            placeholder="myds-icon-desktop-computer"
                            maxlength="50"
                        />
                        <p class="myds-help-text">
                            Kelas CSS untuk ikon MYDS. / CSS class for MYDS icon.
                        </p>
                        @error('icon')
                            <p class="myds-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Color Code -->
                    <div>
                        <label for="color_code" class="myds-label">
                            Kod Warna / Color Code
                        </label>
                        <input
                            type="color"
                            id="color_code"
                            wire:model="color_code"
                            class="myds-input @error('color_code') myds-input-error @enderror"
                        />
                        <p class="myds-help-text">
                            Warna untuk paparan UI. / Color for UI display.
                        </p>
                        @error('color_code')
                            <p class="myds-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description (English) -->
                    <div class="myds-col-span-full">
                        <label for="description" class="myds-label">
                            Penerangan (Bahasa Inggeris) / Description (English)
                        </label>
                        <textarea
                            id="description"
                            wire:model="description"
                            class="myds-textarea @error('description') myds-input-error @enderror"
                            rows="3"
                            maxlength="1000"
                            placeholder="Detailed description of the damage type..."
                        ></textarea>
                        @error('description')
                            <p class="myds-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description (Bahasa Malaysia) -->
                    <div class="myds-col-span-full">
                        <label for="description_bm" class="myds-label">
                            Penerangan (Bahasa Malaysia) / Description (Bahasa Malaysia)
                        </label>
                        <textarea
                            id="description_bm"
                            wire:model="description_bm"
                            class="myds-textarea @error('description_bm') myds-input-error @enderror"
                            rows="3"
                            maxlength="1000"
                            placeholder="Penerangan terperinci tentang jenis kerosakan..."
                        ></textarea>
                        @error('description_bm')
                            <p class="myds-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="myds-col-span-full">
                        <div class="myds-flex myds-items-center">
                            <input
                                type="checkbox"
                                id="is_active"
                                wire:model="is_active"
                                class="myds-checkbox @error('is_active') myds-input-error @enderror"
                            />
                            <label for="is_active" class="myds-label ml-3">
                                Aktif / Active
                            </label>
                        </div>
                        <p class="myds-help-text">
                            Jenis kerosakan aktif akan dipaparkan dalam dropdown. / Active damage types will appear in dropdowns.
                        </p>
                        @error('is_active')
                            <p class="myds-error-text">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="myds-flex myds-justify-end myds-space-x-4 mt-6 pt-6 border-t border-myds-gray-200">
                    <button
                        type="button"
                        wire:click="cancelEdit"
                        class="myds-button myds-button-secondary"
                    >
                        <i class="myds-icon-x mr-2" aria-hidden="true"></i>
                        Batal / Cancel
                    </button>

                    <button
                        type="submit"
                        class="myds-button myds-button-primary"
                        wire:loading.attr="disabled"
                        wire:target="save"
                    >
                        <span wire:loading.remove wire:target="save">
                            <i class="myds-icon-check mr-2" aria-hidden="true"></i>
                            @if ($editingId)
                                Kemaskini / Update
                            @else
                                Simpan / Save
                            @endif
                        </span>
                        <span wire:loading wire:target="save">
                            <i class="myds-icon-refresh myds-animate-spin mr-2" aria-hidden="true"></i>
                            Menyimpan... / Saving...
                        </span>
                    </button>
                </div>

                @error('save')
                    <div class="myds-alert myds-alert-error mt-4" role="alert">
                        <i class="myds-icon-exclamation-circle" aria-hidden="true"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </form>
        </div>
    @endif

    <!-- Data Table -->
    <div class="myds-card myds-card-bordered">
        <div class="myds-card-header">
            <h2 class="myds-heading-lg text-myds-gray-900 dark:text-myds-gray-100">
                <i class="myds-icon-view-list mr-2" aria-hidden="true"></i>
                Senarai Jenis Kerosakan / Damage Types List
            </h2>
        </div>

        <div class="myds-card-body p-0">
            @if ($damageTypes->count())
                <div class="myds-table-responsive">
                    <table class="myds-table">
                        <thead class="myds-table-head">
                            <tr>
                                <th class="myds-table-th">Turutan / Order</th>
                                <th class="myds-table-th">Nama / Name</th>
                                <th class="myds-table-th">Tahap / Severity</th>
                                <th class="myds-table-th">Status</th>
                                <th class="myds-table-th">Tarikh Dikemaskini / Updated</th>
                                <th class="myds-table-th">Tindakan / Actions</th>
                            </tr>
                        </thead>
                        <tbody class="myds-table-body">
                            @foreach ($damageTypes as $damageType)
                                <tr class="myds-table-row">
                                    <td class="myds-table-td">
                                        <span class="myds-badge myds-badge-neutral">
                                            {{ $damageType->sort_order }}
                                        </span>
                                    </td>
                                    <td class="myds-table-td">
                                        <div class="myds-flex myds-items-center">
                                            @if ($damageType->icon)
                                                <i class="{{ $damageType->icon }} mr-3 text-lg" aria-hidden="true"></i>
                                            @endif
                                            <div>
                                                <div class="myds-text-body-md font-medium">
                                                    {{ $damageType->name }}
                                                </div>
                                                <div class="myds-text-body-sm text-myds-gray-600">
                                                    {{ $damageType->name_bm }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="myds-table-td">
                                        @php
                                            $severityConfig = [
                                                'low' => ['class' => 'myds-badge-success', 'text' => 'Rendah / Low'],
                                                'medium' => ['class' => 'myds-badge-warning', 'text' => 'Sederhana / Medium'],
                                                'high' => ['class' => 'myds-badge-error', 'text' => 'Tinggi / High'],
                                                'critical' => ['class' => 'myds-badge-error', 'text' => 'Kritikal / Critical'],
                                            ];
                                            $config = $severityConfig[$damageType->severity];
                                        @endphp
                                        <span class="myds-badge {{ $config['class'] }}">
                                            {{ $config['text'] }}
                                        </span>
                                    </td>
                                    <td class="myds-table-td">
                                        <span class="myds-badge {{ $damageType->is_active ? 'myds-badge-success' : 'myds-badge-neutral' }}">
                                            {{ $damageType->is_active ? 'Aktif / Active' : 'Tidak Aktif / Inactive' }}
                                        </span>
                                    </td>
                                    <td class="myds-table-td">
                                        <time datetime="{{ $damageType->updated_at->toISOString() }}" class="myds-text-body-sm">
                                            {{ $damageType->updated_at->format('d/m/Y H:i') }}
                                        </time>
                                    </td>
                                    <td class="myds-table-td">
                                        <div class="myds-flex myds-space-x-2">
                                            <button
                                                type="button"
                                                wire:click="edit({{ $damageType->id }})"
                                                class="myds-button myds-button-sm myds-button-secondary"
                                                title="Kemaskini / Edit"
                                            >
                                                <i class="myds-icon-pencil" aria-hidden="true"></i>
                                                <span class="sr-only">Kemaskini / Edit</span>
                                            </button>

                                            <button
                                                type="button"
                                                wire:click="toggleStatus({{ $damageType->id }})"
                                                class="myds-button myds-button-sm {{ $damageType->is_active ? 'myds-button-warning' : 'myds-button-success' }}"
                                                title="{{ $damageType->is_active ? 'Nyahaktifkan / Deactivate' : 'Aktifkan / Activate' }}"
                                                wire:loading.attr="disabled"
                                                wire:target="toggleStatus({{ $damageType->id }})"
                                            >
                                                <i class="{{ $damageType->is_active ? 'myds-icon-eye-off' : 'myds-icon-eye' }}" aria-hidden="true"></i>
                                                <span class="sr-only">
                                                    {{ $damageType->is_active ? 'Nyahaktifkan / Deactivate' : 'Aktifkan / Activate' }}
                                                </span>
                                            </button>

                                            <button
                                                type="button"
                                                wire:click="delete({{ $damageType->id }})"
                                                wire:confirm="Adakah anda pasti untuk memadam jenis kerosakan ini? / Are you sure you want to delete this damage type?"
                                                class="myds-button myds-button-sm myds-button-error"
                                                title="Padam / Delete"
                                                wire:loading.attr="disabled"
                                                wire:target="delete({{ $damageType->id }})"
                                            >
                                                <i class="myds-icon-trash" aria-hidden="true"></i>
                                                <span class="sr-only">Padam / Delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="myds-card-body border-t border-myds-gray-200">
                    {{ $damageTypes->links() }}
                </div>
            @else
                <div class="myds-card-body text-center py-12">
                    <i class="myds-icon-inbox myds-text-gray-400 text-6xl mb-4" aria-hidden="true"></i>
                    <h3 class="myds-heading-md text-myds-gray-700 dark:text-myds-gray-300 mb-2">
                        Tiada Jenis Kerosakan Dijumpai / No Damage Types Found
                    </h3>
                    <p class="myds-text-body-md text-myds-gray-600 dark:text-myds-gray-400">
                        @if ($search || $severityFilter || $statusFilter)
                            Tiada hasil sepadan dengan carian anda. Cuba ubah kriteria carian.
                            <br>
                            No results match your search. Try adjusting your search criteria.
                        @else
                            Tambah jenis kerosakan pertama untuk memulakan.
                            <br>
                            Add your first damage type to get started.
                        @endif
                    </p>
                    @if (!$search && !$severityFilter && !$statusFilter)
                        <button
                            type="button"
                            wire:click="create"
                            class="myds-button myds-button-primary mt-4"
                        >
                            <i class="myds-icon-plus mr-2" aria-hidden="true"></i>
                            Tambah Jenis Kerosakan Pertama / Add First Damage Type
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
