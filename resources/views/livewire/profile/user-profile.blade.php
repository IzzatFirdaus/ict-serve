{{--
    ICTServe (iServe) — User Profile (MYDS & MyGovEA compliant)
    - Rewritten to use MYDS primitives, tokens and MyGovEA principles (citizen-centric, accessible)
    - Livewire bindings preserved; ensure Livewire component properties exist:
        $name, $email, $staff_id, $department, $phone, $position,
        $current_profile_picture, $profile_picture, $userStats, $recentActivity, etc.
--}}

<x-myds.skiplink href="#profile-main">Skip to main content</x-myds.skiplink>

<x-myds.masthead>
    <x-myds.masthead-header>
        <x-myds.masthead-title>
            <x-myds.icon name="user-circle" class="w-6 h-6 mr-2" />
            Profil Pengguna / User Profile
        </x-myds.masthead-title>
    </x-myds.masthead-header>
</x-myds.masthead>

<main id="profile-main" class="myds-container max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8" tabindex="0" aria-labelledby="profile-heading">
    <header class="mb-6">
        <h1 id="profile-heading" class="text-heading-lg font-semibold text-txt-black-900 flex items-center gap-3">
            <x-myds.icon name="user" class="w-6 h-6" />
            Profil Pengguna / User Profile
        </h1>
        <p class="text-body-sm text-txt-black-500 mt-2">
            Urus maklumat profil dan keutamaan anda / Manage your profile information and preferences
        </p>
    </header>

    {{-- Flash / Alerts --}}
    @if(session('success'))
        <x-myds.callout variant="success" class="mb-6" role="status" aria-live="polite">
            <x-myds.icon name="check-circle" />
            <span>{{ session('success') }}</span>
        </x-myds.callout>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- SIDEBAR --}}
        <aside class="lg:col-span-1">
            <x-myds.card variant="elevated" class="p-6">
                {{-- Profile avatar and basic details --}}
                <div class="text-center">
                    @if($current_profile_picture)
                        <x-myds.avatar :src="Storage::url($current_profile_picture)" :alt="$name" size="xl" class="mx-auto mb-3" />
                    @else
                        <x-myds.avatar :name="$name" size="xl" class="mx-auto mb-3" />
                    @endif

                    <h3 class="text-body-md font-semibold text-txt-black-900 truncate">{{ $name }}</h3>
                    <p class="text-body-xs text-txt-black-500">{{ $staff_id }}</p>
                    <p class="text-body-xs text-txt-black-400 mt-1">{{ $department }}</p>
                </div>

                {{-- Profile picture upload --}}
                <div class="mt-6 space-y-4">
                    @if($profile_picture)
                        <div class="text-center">
                            <x-myds.avatar :src="$profile_picture->temporaryUrl()" alt="Preview" size="lg" class="mx-auto mb-2 ring-2 ring-primary-600" />
                            <div class="text-body-xs text-txt-black-500">Gambar baharu / New image</div>
                        </div>
                    @endif

                    <div>
                        <x-myds.label for="profile_picture">Gambar Profil / Profile Picture</x-myds.label>
                        <input id="profile_picture"
                               type="file"
                               accept="image/*"
                               wire:model="profile_picture"
                               class="block w-full text-body-sm mt-2 file:py-2 file:px-3 file:rounded-full file:bg-primary-50 file:text-primary-700 file:font-medium"
                               aria-describedby="@error('profile_picture') profile-picture-error @enderror" />
                        @error('profile_picture')
                            <div id="profile-picture-error" class="myds-field-error mt-2" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex gap-2">
                        @if($profile_picture)
                            <x-myds.button type="button" variant="primary" class="flex-1" wire:click="updateProfilePicture" wire:loading.attr="disabled" aria-live="polite">
                                <x-myds.icon name="check" class="w-4 h-4 mr-2" /> Simpan / Save
                            </x-myds.button>
                        @endif

                        @if($current_profile_picture)
                            <x-myds.button type="button" variant="danger-tertiary" class="flex-1"
                                wire:click="deleteProfilePicture"
                                onclick="return confirm('Adakah anda pasti ingin memadam gambar profil? / Are you sure you want to delete profile picture?')"
                            >
                                <x-myds.icon name="trash" class="w-4 h-4 mr-2" /> Padam / Delete
                            </x-myds.button>
                        @endif
                    </div>
                </div>

                {{-- Stats --}}
                <div class="mt-8 pt-6 border-t otl-divider">
                    <h4 class="text-body-sm font-medium text-txt-black-900 mb-3">Statistik / Statistics</h4>
                    <div class="space-y-3 text-body-sm text-txt-black-700">
                        <div class="flex justify-between">
                            <span class="text-txt-black-500">Jumlah Tiket / Total Tickets</span>
                            <span class="font-medium">{{ $userStats['total_tickets'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-txt-black-500">Tiket Selesai / Resolved</span>
                            <span class="font-medium text-success-600">{{ $userStats['resolved_tickets'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-txt-black-500">Pinjaman Aktif / Active Loans</span>
                            <span class="font-medium text-primary-600">{{ $userStats['active_loans'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-txt-black-500">Jumlah Pinjaman / Total Loans</span>
                            <span class="font-medium">{{ $userStats['total_loans'] ?? 0 }}</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t otl-divider text-body-xs text-txt-black-500">
                        <p>Sertai pada / Joined: {{ isset($userStats['join_date']) ? $userStats['join_date']->format('M Y') : '-' }}</p>
                        <p>Log masuk terakhir / Last login: {{ isset($userStats['last_login']) ? $userStats['last_login']->diffForHumans() : '-' }}</p>
                    </div>
                </div>
            </x-myds.card>

            {{-- Quick backlinks --}}
            <div class="mt-4 flex gap-2">
                <x-myds.button :href="route('dashboard')" variant="tertiary" class="flex-1">
                    <x-myds.icon name="arrow-left" class="w-4 h-4 mr-2" /> Kembali / Back
                </x-myds.button>
                <x-myds.button :href="route('helpdesk.create-enhanced')" variant="primary" class="flex-1">
                    <x-myds.icon name="plus" class="w-4 h-4 mr-2" /> Cipta Tiket
                </x-myds.button>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <section class="lg:col-span-3 space-y-8" aria-labelledby="profile-info-heading">
            {{-- Profile Information --}}
            <x-myds.card>
                <x-myds.card-header>
                    <div class="flex items-center justify-between w-full">
                        <div>
                            <h2 id="profile-info-heading" class="text-heading-md font-semibold text-txt-black-900 flex items-center gap-2">
                                <x-myds.icon name="document-text" class="w-5 h-5" /> Maklumat Profil / Profile Information
                            </h2>
                            <p class="text-body-sm text-txt-black-500 mt-1">Kemaskini maklumat peribadi anda / Update your personal information</p>
                        </div>
                    </div>
                </x-myds.card-header>

                <x-myds.card-body>
                    <form wire:submit.prevent="updateProfile" class="space-y-6" novalidate>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Name --}}
                            <x-myds.field>
                                <x-myds.label for="name">Nama Penuh / Full Name</x-myds.label>
                                <x-myds.input id="name" wire:model.live="name" type="text" :invalid="$errors->has('name')" />
                                @error('name') <x-myds.input-error>{{ $message }}</x-myds.input-error> @enderror
                            </x-myds.field>

                            {{-- Email --}}
                            <x-myds.field>
                                <x-myds.label for="email">E-mel / Email</x-myds.label>
                                <x-myds.input id="email" wire:model.live="email" type="email" :invalid="$errors->has('email')" />
                                @error('email') <x-myds.input-error>{{ $message }}</x-myds.input-error> @enderror
                            </x-myds.field>

                            {{-- Staff ID --}}
                            <x-myds.field>
                                <x-myds.label for="staff_id">ID Staf / Staff ID</x-myds.label>
                                <x-myds.input id="staff_id" wire:model.live="staff_id" type="text" :invalid="$errors->has('staff_id')" />
                                @error('staff_id') <x-myds.input-error>{{ $message }}</x-myds.input-error> @enderror
                            </x-myds.field>

                            {{-- Department --}}
                            <x-myds.field>
                                <x-myds.label for="department">Jabatan / Department</x-myds.label>
                                <x-myds.input id="department" wire:model.live="department" type="text" :invalid="$errors->has('department')" />
                                @error('department') <x-myds.input-error>{{ $message }}</x-myds.input-error> @enderror
                            </x-myds.field>

                            {{-- Phone --}}
                            <x-myds.field>
                                <x-myds.label for="phone">Telefon / Phone</x-myds.label>
                                <x-myds.input id="phone" wire:model.live="phone" type="tel" :invalid="$errors->has('phone')" />
                                @error('phone') <x-myds.input-error>{{ $message }}</x-myds.input-error> @enderror
                            </x-myds.field>

                            {{-- Position --}}
                            <x-myds.field>
                                <x-myds.label for="position">Jawatan / Position</x-myds.label>
                                <x-myds.input id="position" wire:model.live="position" type="text" :invalid="$errors->has('position')" />
                                @error('position') <x-myds.input-error>{{ $message }}</x-myds.input-error> @enderror
                            </x-myds.field>
                        </div>

                        <div class="flex justify-end">
                            <x-myds.button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="updateProfile">
                                <x-myds.icon name="check" class="w-4 h-4 mr-2" />
                                <span wire:loading.remove wire:target="updateProfile">Kemaskini Profil / Update Profile</span>
                                <span wire:loading wire:target="updateProfile">Mengemaskini... / Updating...</span>
                            </x-myds.button>
                        </div>
                    </form>
                </x-myds.card-body>
            </x-myds.card>

            {{-- Change Password --}}
            <x-myds.card>
                <x-myds.card-header>
                    <div>
                        <h3 class="text-heading-sm font-semibold text-txt-black-900 flex items-center gap-2">
                            <x-myds.icon name="lock-closed" class="w-5 h-5" /> Tukar Kata Laluan / Change Password
                        </h3>
                        <p class="text-body-sm text-txt-black-500 mt-1">Kemaskini kata laluan untuk keselamatan yang lebih baik / Update your password for better security</p>
                    </div>
                </x-myds.card-header>

                <x-myds.card-body>
                    <form wire:submit.prevent="updatePassword" class="space-y-6" novalidate>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <x-myds.field>
                                <x-myds.label for="current_password">Kata Laluan Semasa / Current Password</x-myds.label>
                                <x-myds.input id="current_password" wire:model.live="current_password" type="password" :invalid="$errors->has('current_password')" />
                                @error('current_password') <x-myds.input-error>{{ $message }}</x-myds.input-error> @enderror
                            </x-myds.field>

                            <x-myds.field>
                                <x-myds.label for="new_password">Kata Laluan Baru / New Password</x-myds.label>
                                <x-myds.input id="new_password" wire:model.live="new_password" type="password" :invalid="$errors->has('new_password')" />
                                @error('new_password') <x-myds.input-error>{{ $message }}</x-myds.input-error> @enderror
                            </x-myds.field>

                            <x-myds.field>
                                <x-myds.label for="new_password_confirmation">Sahkan Kata Laluan / Confirm Password</x-myds.label>
                                <x-myds.input id="new_password_confirmation" wire:model.live="new_password_confirmation" type="password" :invalid="$errors->has('new_password_confirmation')" />
                                @error('new_password_confirmation') <x-myds.input-error>{{ $message }}</x-myds.input-error> @enderror
                            </x-myds.field>
                        </div>

                        <div class="flex justify-end">
                            <x-myds.button type="submit" variant="danger-primary" wire:loading.attr="disabled" wire:target="updatePassword">
                                <x-myds.icon name="key" class="w-4 h-4 mr-2" />
                                <span wire:loading.remove wire:target="updatePassword">Tukar Kata Laluan / Change Password</span>
                                <span wire:loading wire:target="updatePassword">Menukar... / Changing...</span>
                            </x-myds.button>
                        </div>
                    </form>
                </x-myds.card-body>
            </x-myds.card>

            {{-- Preferences --}}
            <x-myds.card>
                <x-myds.card-header>
                    <div>
                        <h3 class="text-heading-sm font-semibold text-txt-black-900 flex items-center gap-2">
                            <x-myds.icon name="cog" class="w-5 h-5" /> Keutamaan / Preferences
                        </h3>
                        <p class="text-body-sm text-txt-black-500 mt-1">Tetapkan keutamaan aplikasi anda / Set your application preferences</p>
                    </div>
                </x-myds.card-header>

                <x-myds.card-body>
                    <form wire:submit.prevent="updatePreferences" class="space-y-6" novalidate>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-myds.field>
                                <x-myds.label for="preferred_language">Bahasa Pilihan / Preferred Language</x-myds.label>
                                <x-myds.select id="preferred_language" wire:model.live="preferred_language">
                                    <option value="ms">Bahasa Malaysia</option>
                                    <option value="en">English</option>
                                </x-myds.select>
                                @error('preferred_language') <x-myds.input-error>{{ $message }}</x-myds.input-error> @enderror
                            </x-myds.field>

                            <x-myds.field>
                                <x-myds.label for="theme_preference">Tema / Theme</x-myds.label>
                                <x-myds.select id="theme_preference" wire:model.live="theme_preference">
                                    <option value="light">Terang / Light</option>
                                    <option value="dark">Gelap / Dark</option>
                                    <option value="system">Ikut Sistem / System</option>
                                </x-myds.select>
                                @error('theme_preference') <x-myds.input-error>{{ $message }}</x-myds.input-error> @enderror
                            </x-myds.field>
                        </div>

                        <div class="border-t otl-divider pt-6">
                            <h4 class="text-body-md font-medium text-txt-black-900 mb-3">Tetapan Notifikasi / Notification Settings</h4>
                            <div class="space-y-4">
                                <x-myds.checkbox id="email_notifications" wire:model.live="email_notifications" label="Notifikasi E-mel / Email Notifications" />
                                <x-myds.checkbox id="sms_notifications" wire:model.live="sms_notifications" label="Notifikasi SMS / SMS Notifications" />
                                <x-myds.checkbox id="browser_notifications" wire:model.live="browser_notifications" label="Notifikasi Browser / Browser Notifications" />
                            </div>

                            <div class="mt-6">
                                <h5 class="text-body-sm font-medium text-txt-black-900 mb-3">Jenis Notifikasi / Notification Types</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-myds.checkbox id="ticket_updates" wire:model.live="notification_types.ticket_updates" label="Kemaskini Tiket / Ticket Updates" />
                                    <x-myds.checkbox id="loan_approvals" wire:model.live="notification_types.loan_approvals" label="Kelulusan Pinjaman / Loan Approvals" />
                                    <x-myds.checkbox id="equipment_reminders" wire:model.live="notification_types.equipment_reminders" label="Peringatan Peralatan / Equipment Reminders" />
                                    <x-myds.checkbox id="system_announcements" wire:model.live="notification_types.system_announcements" label="Pengumuman Sistem / System Announcements" />
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <x-myds.button type="submit" variant="success-primary" wire:loading.attr="disabled" wire:target="updatePreferences">
                                <x-myds.icon name="save" class="w-4 h-4 mr-2" />
                                <span wire:loading.remove wire:target="updatePreferences">Simpan Keutamaan / Save Preferences</span>
                                <span wire:loading wire:target="updatePreferences">Menyimpan... / Saving...</span>
                            </x-myds.button>
                        </div>
                    </form>
                </x-myds.card-body>
            </x-myds.card>

            {{-- Recent activity (optional) --}}
            @if(!empty($recentActivity))
                <x-myds.card>
                    <x-myds.card-header>
                        <h3 class="text-heading-sm font-semibold text-txt-black-900 flex items-center gap-2">
                            <x-myds.icon name="clock" class="w-5 h-5" /> Aktiviti Terkini / Recent Activity
                        </h3>
                    </x-myds.card-header>
                    <x-myds.card-body>
                        <div class="space-y-4">
                            @foreach($recentActivity as $activity)
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center
                                            @if($activity['type'] === 'ticket') bg-primary-50 text-primary-600
                                            @else bg-success-50 text-success-600 @endif">
                                            <x-myds.icon :name="$activity['type'] === 'ticket' ? 'clipboard-list' : 'archive'" class="w-4 h-4" />
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-body-sm font-medium text-txt-black-900 truncate">{{ $activity['title'] }}</p>
                                        <p class="text-body-xs text-txt-black-500">{{ $activity['description'] }}</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <x-myds.tag variant="default" size="xs">{{ $activity['status'] }}</x-myds.tag>
                                            <span class="text-body-xs text-txt-black-400">{{ \Carbon\Carbon::parse($activity['created_at'])->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <a href="{{ $activity['url'] }}" class="text-primary-600 hover:text-primary-700" aria-label="View activity">
                                            <x-myds.icon name="external-link" class="w-4 h-4" />
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-myds.card-body>
                </x-myds.card>
            @endif
        </section>
    </div>

    {{-- Toast-like ephemeral flash (if Livewire emits) --}}
    <div aria-live="polite" class="sr-only" wire:poll.visible.5000ms="noop"></div>
</main>

<x-myds.footer>
    <x-myds.footer-section>
        <x-myds.site-info>
            <x-myds.footer-logo logoTitle="Bahagian Pengurusan Maklumat (BPM)" />
            Aras 13, 14 &amp; 15, Blok Menara, Menara Usahawan, No. 18, Persiaran Perdana, Presint 2, 62000 Putrajaya, Malaysia
            <div class="mt-2">© 2025 BPM, Kementerian Pelancongan, Seni dan Budaya Malaysia.</div>
        </x-myds.site-info>
    </x-myds.footer-section>
</x-myds.footer>
