{{--
    ICTServe (iServe) - Helpdesk Ticket Creation (Unified)
    - Combines classic and enhanced flows
    - Conforms to MYDS (Design, Develop, Icons, Colour) and MyGovEA principles
    - Accessible, responsive, and citizen-centric
--}}

<x-myds.skiplink href="#main-content">
    <span>Skip to main content</span>
</x-myds.skiplink>

<x-myds.masthead>
    <x-myds.masthead-header>
        <x-myds.masthead-title>ICTServe Helpdesk</x-myds.masthead-title>
    </x-myds.masthead-header>
    <x-myds.masthead-content>
        <x-myds.masthead-section title="Lapor Masalah Teknikal" icon="exclamation-triangle" />
    </x-myds.masthead-content>
</x-myds.masthead>

<main id="main-content" tabindex="0" class="myds-container max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    {{-- Breadcrumb --}}
    <x-myds.breadcrumb>
        <x-myds.breadcrumb-item>
            <x-myds.breadcrumb-link :href="route('dashboard')">Papan Pemuka / Dashboard</x-myds.breadcrumb-link>
        </x-myds.breadcrumb-item>
        <x-myds.breadcrumb-item>
            <x-myds.breadcrumb-link :href="route('helpdesk.index')">Bantuan Teknikal / Technical Support</x-myds.breadcrumb-link>
        </x-myds.breadcrumb-item>
        <x-myds.breadcrumb-item>
            <x-myds.breadcrumb-page>Lapor Masalah / Report Issue</x-myds.breadcrumb-page>
        </x-myds.breadcrumb-item>
    </x-myds.breadcrumb>

    {{-- Page header --}}
    <header class="mb-8">
        <h1 class="text-heading-l font-semibold text-txt-black-900 flex items-center gap-2">
            <x-myds.icon name="exclamation-triangle" class="w-7 h-7 text-danger-400" />
            Lapor Masalah Teknikal
        </h1>
        <div class="text-body-base text-txt-black-700 mt-2 mb-1">
            Report Technical Issue
        </div>
        <div class="text-body-md text-txt-black-700">
            Sila lengkapkan borang di bawah untuk melaporkan masalah teknikal atau meminta bantuan ICT.
            <br>
            Please complete the form below to report technical issues or request ICT assistance.
        </div>
    </header>

    {{-- Stepper/Progress Bar if using enhanced multi-step --}}
    @if($maxSteps ?? false)
        <nav aria-label="Progress" class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <span class="text-heading-xs font-semibold text-txt-black-900">
                        Cipta Tiket Bantuan / Create Help Ticket
                    </span>
                    <span class="text-body-sm text-txt-black-500 ml-3">
                        Langkah {{ $currentStep }} daripada {{ $maxSteps }} / Step {{ $currentStep }} of {{ $maxSteps }}
                    </span>
                </div>
                <div class="flex bg-bg-washed rounded-lg p-1">
                    <x-myds.button type="button" size="sm"
                        variant="{{ $ticketType === 'general' ? 'primary' : 'secondary' }}"
                        wire:click="$set('ticketType', 'general')"
                        aria-pressed="{{ $ticketType === 'general' ? 'true' : 'false' }}"
                    >Umum / General</x-myds.button>
                    <x-myds.button type="button" size="sm"
                        variant="{{ $ticketType === 'incident' ? 'primary' : 'secondary' }}"
                        wire:click="$set('ticketType', 'incident')"
                        aria-pressed="{{ $ticketType === 'incident' ? 'true' : 'false' }}"
                    >Insiden / Incident</x-myds.button>
                    <x-myds.button type="button" size="sm"
                        variant="{{ $ticketType === 'damage' ? 'primary' : 'secondary' }}"
                        wire:click="$set('ticketType', 'damage')"
                        aria-pressed="{{ $ticketType === 'damage' ? 'true' : 'false' }}"
                    >Kerosakan / Damage</x-myds.button>
                </div>
            </div>
            <div class="w-full bg-otl-gray-200 rounded-full h-2">
                <div class="bg-gradient-to-r from-primary-500 to-primary-700 h-2 rounded-full transition-all duration-300"
                     style="width: {{ $maxSteps ? ($currentStep / $maxSteps * 100) : 100 }}%">
                </div>
            </div>
            <div class="flex justify-between mt-2">
                <span class="text-xs {{ $currentStep >= 1 ? 'text-primary-600 font-medium' : 'text-txt-black-500' }}">
                    Jenis & Tajuk / Type & Title
                </span>
                <span class="text-xs {{ $currentStep >= 2 ? 'text-primary-600 font-medium' : 'text-txt-black-500' }}">
                    Butiran / Details
                </span>
                <span class="text-xs {{ $currentStep >= 3 ? 'text-primary-600 font-medium' : 'text-txt-black-500' }}">
                    Lampiran / Attachments
                </span>
            </div>
        </nav>
    @endif

    {{-- Main Form --}}
    <form
        wire:submit.prevent="submit"
        class="myds-space-y-8"
        aria-label="Lapor Masalah Teknikal / Report Technical Issue"
    >
        @csrf

        {{-- Step 1: Basic Information --}}
        @if(!isset($currentStep) || $currentStep === 1)
        <x-myds.card>
            <x-myds.card-header>
                <span class="text-heading-m font-semibold text-txt-black-900 flex items-center gap-2">
                    <x-myds.icon name="clipboard-list" class="w-5 h-5" />
                    Maklumat Asas / Basic Information
                </span>
            </x-myds.card-header>
            <x-myds.card-body>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-myds.input
                            id="title"
                            name="title"
                            label="Tajuk Masalah / Issue Title"
                            wire:model.live="title"
                            maxlength="255"
                            required
                            :invalid="$errors->has('title')"
                            placeholder="Nyatakan masalah secara ringkas... / Brief description of the issue..."
                            aria-describedby="title-help @error('title') title-error @enderror"
                        />
                        <x-myds.input-hint id="title-help">
                            Berikan tajuk yang jelas untuk masalah anda. / Provide a clear title for your issue.
                        </x-myds.input-hint>
                        @error('title')
                            <x-myds.input-error id="title-error">{{ $message }}</x-myds.input-error>
                        @enderror
                    </div>
                    <div>
                        <x-myds.select
                            id="category_id"
                            name="category_id"
                            label="Kategori Masalah / Issue Category"
                            wire:model.live="category_id"
                            required
                            :invalid="$errors->has('category_id')"
                            aria-describedby="@error('category_id') category-error @enderror"
                        >
                            <option value="">Pilih kategori... / Select category...</option>
                            @foreach($ticketCategories as $category)
                                <option value="{{ $category['id'] }}">
                                    {{ $category['name'] }}{{ $category['name_bm'] ? ' / ' . $category['name_bm'] : '' }}
                                </option>
                            @endforeach
                        </x-myds.select>
                        @error('category_id')
                            <x-myds.input-error id="category-error">{{ $message }}</x-myds.input-error>
                        @enderror
                    </div>
                </div>
            </x-myds.card-body>
        </x-myds.card>
        @endif

        {{-- Step 2: Details --}}
        @if(!isset($currentStep) || $currentStep === 2)
        <x-myds.card>
            <x-myds.card-header>
                <span class="text-heading-m font-semibold text-txt-black-900 flex items-center gap-2">
                    <x-myds.icon name="clipboard-document" class="w-5 h-5" />
                    Butiran Masalah / Issue Details
                </span>
            </x-myds.card-header>
            <x-myds.card-body>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-myds.select
                            id="priority"
                            name="priority"
                            label="Tahap Keutamaan / Priority Level"
                            wire:model.live="priority"
                            required
                            :invalid="$errors->has('priority')"
                            aria-describedby="priority-help @error('priority') priority-error @enderror"
                        >
                            <option value="low">Rendah / Low - Tidak mengganggu kerja</option>
                            <option value="medium">Sederhana / Medium - Mengganggu sedikit</option>
                            <option value="high">Tinggi / High - Mengganggu kerja</option>
                            <option value="critical">Kritikal / Critical - Menghentikan kerja</option>
                        </x-myds.select>
                        <x-myds.input-hint id="priority-help">
                            Pilih tahap keutamaan berdasarkan kesan terhadap kerja anda.
                        </x-myds.input-hint>
                        @error('priority')
                            <x-myds.input-error id="priority-error">{{ $message }}</x-myds.input-error>
                        @enderror
                    </div>
                    {{-- Optional: Urgency (enhanced flow) --}}
                    @if(isset($urgency))
                    <div>
                        <x-myds.select
                            id="urgency"
                            name="urgency"
                            label="Kesegeraan / Urgency"
                            wire:model.live="urgency"
                            required
                            :invalid="$errors->has('urgency')"
                        >
                            <option value="low">Rendah / Low</option>
                            <option value="normal">Normal / Normal</option>
                            <option value="high">Tinggi / High</option>
                            <option value="urgent">Segera / Urgent</option>
                        </x-myds.select>
                    </div>
                    @endif
                </div>
                <div class="mt-6">
                    <x-myds.textarea
                        id="description"
                        name="description"
                        label="Penerangan Masalah / Issue Description"
                        wire:model.live="description"
                        rows="5"
                        maxlength="2000"
                        required
                        :invalid="$errors->has('description')"
                        placeholder="Terangkan masalah dengan terperinci..."
                        aria-describedby="description-help @error('description') description-error @enderror"
                    />
                    <x-myds.input-hint id="description-help">
                        Berikan penerangan yang terperinci untuk membantu kami memahami masalah.
                    </x-myds.input-hint>
                    @error('description')
                        <x-myds.input-error id="description-error">{{ $message }}</x-myds.input-error>
                    @enderror
                </div>
                {{-- Step 2: Incident/Damage type-specific fields --}}
                @if($ticketType === 'incident')
                    @include('livewire.helpdesk.partials.incident-fields')
                @elseif($ticketType === 'damage')
                    @include('livewire.helpdesk.partials.damage-fields')
                @endif
            </x-myds.card-body>
        </x-myds.card>
        @endif

        {{-- Step 3: Equipment & Attachments --}}
        @if($showEquipmentSelector || $currentStep === 3)
        <x-myds.card>
            <x-myds.card-header>
                <span class="text-heading-m font-semibold text-txt-black-900 flex items-center gap-2">
                    <x-myds.icon name="desktop-computer" class="w-5 h-5" />
                    Peralatan &amp; Lampiran / Equipment & Attachments
                </span>
            </x-myds.card-header>
            <x-myds.card-body>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($showEquipmentSelector)
                    <div>
                        <x-myds.select
                            id="equipment_item_id"
                            name="equipment_item_id"
                            label="Peralatan Berkaitan / Related Equipment"
                            wire:model.live="equipment_item_id"
                            :invalid="$errors->has('equipment_item_id')"
                            aria-describedby="equipment-help @error('equipment_item_id') equipment-error @enderror"
                        >
                            <option value="">Pilih peralatan (jika berkaitan)... / Select equipment (if related)...</option>
                            @foreach($equipmentItems as $item)
                                <option value="{{ $item['id'] }}">
                                    {{ $item['brand'] }} {{ $item['model'] }}
                                    @if(!empty($item['serial_number'])) (S/N: {{ $item['serial_number'] }})@endif
                                </option>
                            @endforeach
                        </x-myds.select>
                        <x-myds.input-hint id="equipment-help">
                            Pilih peralatan berkaitan (jika ada).
                        </x-myds.input-hint>
                        @error('equipment_item_id')
                            <x-myds.input-error id="equipment-error">{{ $message }}</x-myds.input-error>
                        @enderror
                    </div>
                    @endif
                    {{-- Attachments (enhanced flow) --}}
                    @if(isset($attachments))
                    <div>
                        <x-myds.file-upload
                            id="attachments"
                            wire:model="attachments"
                            :multiple="true"
                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt"
                            label="Lampiran Fail / File Attachments"
                            hint="Maks 5 fail, 10MB setiap satu / Max 5 files, 10MB each."
                        />
                        @error('attachments.*')
                            <x-myds.input-error>{{ $message }}</x-myds.input-error>
                        @enderror
                    </div>
                    @endif
                </div>
            </x-myds.card-body>
        </x-myds.card>
        @endif

        {{-- Step: Contact Information --}}
        <x-myds.card>
            <x-myds.card-header>
                <span class="text-heading-m font-semibold text-txt-black-900 flex items-center gap-2">
                    <x-myds.icon name="user" class="w-5 h-5" />
                    Maklumat Perhubungan / Contact Information
                </span>
            </x-myds.card-header>
            <x-myds.card-body>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-myds.input
                            id="location"
                            name="location"
                            label="Lokasi / Location"
                            wire:model.live="location"
                            maxlength="255"
                            :invalid="$errors->has('location')"
                            placeholder="Pejabat, bilik, atau lokasi..."
                            aria-describedby="location-help @error('location') location-error @enderror"
                        />
                        <x-myds.input-hint id="location-help">
                            Nyatakan lokasi di mana masalah berlaku.
                        </x-myds.input-hint>
                        @error('location')
                            <x-myds.input-error id="location-error">{{ $message }}</x-myds.input-error>
                        @enderror
                    </div>
                    <div>
                        <x-myds.input
                            id="contact_phone"
                            name="contact_phone"
                            label="No. Telefon Perhubungan / Contact Phone"
                            type="tel"
                            wire:model.live="contact_phone"
                            maxlength="20"
                            :invalid="$errors->has('contact_phone')"
                            placeholder="012-3456789"
                            aria-describedby="phone-help @error('contact_phone') phone-error @enderror"
                        />
                        <x-myds.input-hint id="phone-help">
                            Untuk dihubungi jika diperlukan.
                        </x-myds.input-hint>
                        @error('contact_phone')
                            <x-myds.input-error id="phone-error">{{ $message }}</x-myds.input-error>
                        @enderror
                    </div>
                </div>
            </x-myds.card-body>
        </x-myds.card>

        {{-- Declaration/Confirmation Terms --}}
        <x-myds.card>
            <x-myds.card-header>
                <span class="text-heading-m font-semibold text-txt-black-900 flex items-center gap-2">
                    <x-myds.icon name="shield-check" class="w-5 h-5" />
                    Perakuan / Declaration
                </span>
            </x-myds.card-header>
            <x-myds.card-body>
                <label class="flex items-start gap-2" for="declaration">
                    <x-myds.checkbox id="declaration" name="declaration" wire:model.live="declaration" required />
                    <span class="text-body-sm text-txt-black-700">
                        Saya memperakui dan mengesahkan bahawa semua maklumat yang diberikan di dalam eBorang Laporan Kerosakan ini adalah benar, dan bersetuju menerima perkhidmatan Bahagian Pengurusan Maklumat (BPM) berdasarkan Piagam Pelanggan sedia ada.
                        <br>
                        I certify that all information provided in this ICT Damage Report e-Form is true, and agree to receive services from the Information Management Division (BPM) according to the current Customer Charter.
                    </span>
                </label>
                @error('declaration')
                    <x-myds.input-error>{{ $message }}</x-myds.input-error>
                @enderror
            </x-myds.card-body>
        </x-myds.card>

        {{-- Form Actions --}}
        <x-myds.card variant="bordered">
            <x-myds.card-body>
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <div class="text-body-sm text-txt-black-700 flex items-center gap-2">
                        <x-myds.icon name="information-circle" class="w-4 h-4" />
                        Tiket akan dihantar kepada pasukan ICT untuk tindakan.
                        <span class="ml-3 text-txt-black-500">Ticket will be sent to ICT team for action.</span>
                    </div>
                    <div class="flex gap-3">
                        <x-myds.button :href="route('helpdesk.index')" variant="secondary">
                            <x-myds.button-icon>
                                <x-myds.icon name="arrow-left" class="w-4 h-4" />
                            </x-myds.button-icon>
                            Batal / Cancel
                        </x-myds.button>
                        {{-- Navigation for enhanced flow --}}
                        @if(isset($currentStep) && $currentStep > 1)
                        <x-myds.button type="button" variant="tertiary" wire:click="previousStep">
                            <x-myds.button-icon>
                                <x-myds.icon name="arrow-left" class="w-4 h-4" />
                            </x-myds.button-icon>
                            Kembali / Back
                        </x-myds.button>
                        @endif
                        @if(isset($currentStep) && isset($maxSteps) && $currentStep < $maxSteps)
                        <x-myds.button type="button" variant="primary" wire:click="nextStep">
                            Seterusnya / Next
                            <x-myds.button-icon>
                                <x-myds.icon name="arrow-right" class="w-4 h-4" />
                            </x-myds.button-icon>
                        </x-myds.button>
                        @else
                        <x-myds.button
                            type="submit"
                            variant="primary"
                            wire:loading.attr="disabled"
                            wire:target="submit"
                        >
                            <span wire:loading.remove wire:target="submit">
                                <x-myds.button-icon>
                                    <x-myds.icon name="paper-airplane" class="w-4 h-4" />
                                </x-myds.button-icon>
                                Hantar Laporan / Submit Report
                            </span>
                            <span wire:loading wire:target="submit">
                                <x-myds.button-icon>
                                    <x-myds.icon name="refresh" class="w-4 h-4 myds-animate-spin" />
                                </x-myds.button-icon>
                                Menghantar... / Submitting...
                            </span>
                        </x-myds.button>
                        @endif
                    </div>
                </div>
            </x-myds.card-body>
        </x-myds.card>

        @error('submit')
        <x-myds.callout variant="danger">
            <x-myds.icon name="exclamation-circle" class="w-5 h-5" />
            <span>{{ $message }}</span>
        </x-myds.callout>
        @enderror
    </form>

    {{-- Tips/Help Section --}}
    <div class="mt-8">
        <x-myds.callout variant="info">
            <x-myds.icon name="light-bulb" class="w-5 h-5 mr-2" />
            <span class="font-medium">Petua / Tips:</span>
            @if(($ticketType ?? null) === 'incident')
                <span>
                    Untuk laporan insiden, sertakan masa tepat kejadian, saksi (jika ada), dan tindakan segera yang telah diambil.
                    / For incident reports, include exact time of occurrence, witnesses (if any), and immediate actions taken.
                </span>
            @elseif(($ticketType ?? null) === 'damage')
                <span>
                    Untuk laporan kerosakan, nyatakan jenis kerosakan, punca yang disyaki, dan status waranti peralatan.
                    / For damage reports, specify damage type, suspected cause, and equipment warranty status.
                </span>
            @else
                <span>
                    Berikan penerangan yang jelas dan terperinci untuk membantu kami menyelesaikan masalah anda dengan cepat.
                    / Provide clear and detailed descriptions to help us resolve your issue quickly.
                </span>
            @endif
        </x-myds.callout>
    </div>

    {{-- Toast on Success/Error --}}
    @if (session('success'))
        <x-myds.toast variant="success" :show="true">
            {{ session('success') }}
        </x-myds.toast>
    @endif
    @if (session('error'))
        <x-myds.toast variant="danger" :show="true">
            {{ session('error') }}
        </x-myds.toast>
    @endif
</main>

<x-myds.footer>
    <x-myds.footer-section>
        <x-myds.site-info>
            <x-myds.footer-logo logoTitle="Bahagian Pengurusan Maklumat (BPM)" />
            Aras 13, 14 &amp; 15, Blok Menara, Menara Usahawan, No. 18, Persiaran Perdana, Presint 2, 62000 Putrajaya, Malaysia
            <div class="mt-2">© 2025 BPM, Kementerian Pelancongan, Seni dan Budaya Malaysia.</div>
            <div class="mt-2 flex gap-3">
                <a href="#" aria-label="Facebook" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="facebook" class="w-5 h-5" /></a>
                <a href="#" aria-label="Twitter" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="twitter" class="w-5 h-5" /></a>
                <a href="#" aria-label="Instagram" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="instagram" class="w-5 h-5" /></a>
                <a href="#" aria-label="YouTube" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="youtube" class="w-5 h-5" /></a>
            </div>
        </x-myds.site-info>
    </x-myds.footer-section>
</x-myds.footer>
