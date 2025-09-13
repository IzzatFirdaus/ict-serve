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
                    <a href="{{ route('helpdesk.index') }}" class="myds-link">
                        Bantuan Teknikal / Technical Support
                    </a>
                </li>
                <li class="myds-breadcrumb-item myds-breadcrumb-current" aria-current="page">
                    Lapor Masalah / Report Issue
                </li>
            </ol>
        </nav>

        <!-- Page Title -->
        <div class="myds-page-header">
            <h1 class="myds-heading-xl text-myds-gray-900 dark:text-myds-gray-100">
                <i class="myds-icon-exclamation-triangle mr-3" aria-hidden="true"></i>
                Lapor Masalah Teknikal
            </h1>
            <p class="myds-text-body-lg text-myds-gray-600 dark:text-myds-gray-400 mt-2">
                Report Technical Issue
            </p>
            <p class="myds-text-body-md text-myds-gray-600 dark:text-myds-gray-400 mt-4">
                Sila lengkapkan borang di bawah untuk melaporkan masalah teknikal atau meminta bantuan ICT.
                <br>
                Please complete the form below to report technical issues or request ICT assistance.
            </p>
        </div>
    </div>

    <form wire:submit.prevent="submit" class="myds-space-y-8">
        @csrf

        <!-- Issue Details Section -->
        <div class="myds-card myds-card-elevated">
            <div class="myds-card-header">
                <h2 class="myds-heading-lg text-myds-gray-900 dark:text-myds-gray-100">
                    <i class="myds-icon-clipboard-list mr-2" aria-hidden="true"></i>
                    Butiran Masalah / Issue Details
                </h2>
            </div>

            <div class="myds-card-body">
                <div class="myds-form-grid">
                    <!-- Issue Title -->
                    <div>
                        <label for="title" class="myds-label myds-required">
                            Tajuk Masalah / Issue Title
                        </label>
                        <input
                            type="text"
                            id="title"
                            wire:model="title"
                            class="myds-input @error('title') myds-input-error @enderror"
                            placeholder="Nyatakan masalah secara ringkas... / Brief description of the issue..."
                            maxlength="255"
                            required
                            aria-describedby="title-help @error('title') title-error @enderror"
                        />
                        <p id="title-help" class="myds-help-text">
                            Berikan tajuk yang jelas untuk masalah anda. / Provide a clear title for your issue.
                        </p>
                        @error('title')
                            <p id="title-error" class="myds-error-text" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Issue Category -->
                    <div>
                        <label for="category_id" class="myds-label myds-required">
                            Kategori Masalah / Issue Category
                        </label>
                        <select
                            id="category_id"
                            wire:model.live="category_id"
                            class="myds-select @error('category_id') myds-input-error @enderror"
                            required
                            aria-describedby="@error('category_id') category-error @enderror"
                        >
                            <option value="">Pilih kategori... / Select category...</option>
                            @foreach($ticketCategories as $category)
                                <option value="{{ $category['id'] }}">
                                    {{ $category['name'] }} / {{ $category['name_bm'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p id="category-error" class="myds-error-text" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Priority Level -->
                    <div>
                        <label for="priority" class="myds-label myds-required">
                            Tahap Keutamaan / Priority Level
                        </label>
                        <select
                            id="priority"
                            wire:model="priority"
                            class="myds-select @error('priority') myds-input-error @enderror"
                            required
                            aria-describedby="priority-help @error('priority') priority-error @enderror"
                        >
                            <option value="low">Rendah / Low - Tidak mengganggu kerja / Not affecting work</option>
                            <option value="medium" selected>Sederhana / Medium - Mengganggu sedikit / Slightly affecting work</option>
                            <option value="high">Tinggi / High - Mengganggu kerja / Affecting work significantly</option>
                            <option value="critical">Kritikal / Critical - Menghentikan kerja / Stopping work completely</option>
                        </select>
                        <p id="priority-help" class="myds-help-text">
                            Pilih tahap keutamaan berdasarkan kesan terhadap kerja anda. / Select priority level based on impact on your work.
                        </p>
                        @error('priority')
                            <p id="priority-error" class="myds-error-text" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Issue Description -->
                    <div class="myds-col-span-full">
                        <label for="description" class="myds-label myds-required">
                            Penerangan Masalah / Issue Description
                        </label>
                        <textarea
                            id="description"
                            wire:model="description"
                            class="myds-textarea @error('description') myds-input-error @enderror"
                            rows="5"
                            placeholder="Terangkan masalah dengan terperinci termasuk:&#10;- Apa yang berlaku?&#10;- Bila masalah bermula?&#10;- Langkah-langkah yang telah dicuba?&#10;&#10;Explain the issue in detail including:&#10;- What happened?&#10;- When did the issue start?&#10;- Steps already tried?"
                            maxlength="2000"
                            required
                            aria-describedby="description-help @error('description') description-error @enderror"
                        ></textarea>
                        <p id="description-help" class="myds-help-text">
                            Berikan penerangan yang terperinci untuk membantu kami memahami masalah. / Provide detailed description to help us understand the issue.
                        </p>
                        @error('description')
                            <p id="description-error" class="myds-error-text" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipment Information Section (conditional) -->
        @if($showEquipmentSelector)
            <div class="myds-card myds-card-elevated">
                <div class="myds-card-header">
                    <h2 class="myds-heading-lg text-myds-gray-900 dark:text-myds-gray-100">
                        <i class="myds-icon-desktop-computer mr-2" aria-hidden="true"></i>
                        Maklumat Peralatan / Equipment Information
                    </h2>
                </div>

                <div class="myds-card-body">
                    <div class="myds-form-grid">
                        <!-- Equipment Selection -->
                        <div class="myds-col-span-full">
                            <label for="equipment_item_id" class="myds-label">
                                Peralatan Berkaitan / Related Equipment
                            </label>
                            <select
                                id="equipment_item_id"
                                wire:model="equipment_item_id"
                                class="myds-select @error('equipment_item_id') myds-input-error @enderror"
                                aria-describedby="equipment-help @error('equipment_item_id') equipment-error @enderror"
                            >
                                <option value="">Pilih peralatan (jika berkaitan)... / Select equipment (if related)...</option>
                                @foreach($equipmentItems as $item)
                                    <option value="{{ $item['id'] }}">
                                        {{ $item['brand'] }} {{ $item['model'] }}
                                        @if(!empty($item['serial_number']))
                                            (S/N: {{ $item['serial_number'] }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <p id="equipment-help" class="myds-help-text">
                                Pilih peralatan yang berkaitan dengan masalah ini (jika ada). / Select equipment related to this issue (if any).
                            </p>
                            @error('equipment_item_id')
                                <p id="equipment-error" class="myds-error-text" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Contact Information Section -->
        <div class="myds-card myds-card-elevated">
            <div class="myds-card-header">
                <h2 class="myds-heading-lg text-myds-gray-900 dark:text-myds-gray-100">
                    <i class="myds-icon-user mr-2" aria-hidden="true"></i>
                    Maklumat Perhubungan / Contact Information
                </h2>
            </div>

            <div class="myds-card-body">
                <div class="myds-form-grid">
                    <!-- Location -->
                    <div>
                        <label for="location" class="myds-label">
                            Lokasi / Location
                        </label>
                        <input
                            type="text"
                            id="location"
                            wire:model="location"
                            class="myds-input @error('location') myds-input-error @enderror"
                            placeholder="Pejabat, bilik, atau lokasi..."
                            maxlength="255"
                            aria-describedby="location-help @error('location') location-error @enderror"
                        />
                        <p id="location-help" class="myds-help-text">
                            Nyatakan lokasi di mana masalah berlaku. / Specify the location where the issue occurred.
                        </p>
                        @error('location')
                            <p id="location-error" class="myds-error-text" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Phone -->
                    <div>
                        <label for="contact_phone" class="myds-label">
                            No. Telefon Perhubungan / Contact Phone
                        </label>
                        <input
                            type="tel"
                            id="contact_phone"
                            wire:model="contact_phone"
                            class="myds-input @error('contact_phone') myds-input-error @enderror"
                            placeholder="012-3456789"
                            maxlength="20"
                            aria-describedby="phone-help @error('contact_phone') phone-error @enderror"
                        />
                        <p id="phone-help" class="myds-help-text">
                            Untuk dihubungi jika diperlukan. / For contact if necessary.
                        </p>
                        @error('contact_phone')
                            <p id="phone-error" class="myds-error-text" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="myds-card myds-card-bordered">
            <div class="myds-card-body">
                <div class="myds-flex myds-justify-between myds-items-center">
                    <div class="myds-text-body-sm text-myds-gray-600 dark:text-myds-gray-400">
                        <i class="myds-icon-information-circle mr-1" aria-hidden="true"></i>
                        <span>
                            Tiket akan dihantar kepada pasukan ICT untuk tindakan.
                            <br>
                            Ticket will be sent to ICT team for action.
                        </span>
                    </div>

                    <div class="myds-flex myds-space-x-4">
                        <a href="{{ route('helpdesk.index') }}" class="myds-button myds-button-secondary">
                            <i class="myds-icon-arrow-left mr-2" aria-hidden="true"></i>
                            Batal / Cancel
                        </a>

                        <button
                            type="submit"
                            class="myds-button myds-button-primary"
                            wire:loading.attr="disabled"
                            wire:target="submit"
                        >
                            <span wire:loading.remove wire:target="submit">
                                <i class="myds-icon-paper-airplane mr-2" aria-hidden="true"></i>
                                Hantar Laporan / Submit Report
                            </span>
                            <span wire:loading wire:target="submit">
                                <i class="myds-icon-refresh myds-animate-spin mr-2" aria-hidden="true"></i>
                                Menghantar... / Submitting...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @error('submit')
            <div class="myds-alert myds-alert-error" role="alert">
                <i class="myds-icon-exclamation-circle" aria-hidden="true"></i>
                <span>{{ $message }}</span>
            </div>
        @enderror
    </form>
</div>
