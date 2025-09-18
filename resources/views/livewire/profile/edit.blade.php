@extends('layouts.app')

@section('title', 'Kemaskini Profil')

@php
    // Define breadcrumbs for the layout
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Profil', 'url' => route('profile.index')],
        ['label' => 'Kemaskini Profil'],
    ];
@endphp

@section('content')
<div class="bg-washed min-h-screen">
    <main id="main-content" class="w-full mx-auto myds-container px-4 md:px-6 py-10" tabindex="-1">

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="myds-heading-xl font-semibold tracking-tight text-txt-black-900">Kemaskini Profil</h1>
            <p class="myds-body-lg text-txt-black-700 mt-2">Urus maklumat peribadi dan tetapan keselamatan akaun anda.</p>
        </div>

        <div class="max-w-4xl mx-auto space-y-8">
            {{-- Personal Information Form --}}
            <section class="bg-white rounded-lg shadow-card border border-otl-gray-200" aria-labelledby="profile-info-heading">
                <form wire:submit.prevent="updateProfileInformation">
                    <div class="p-6">
                        <h2 id="profile-info-heading" class="myds-heading-lg text-txt-black-900">Maklumat Peribadi</h2>
                        <p class="myds-body-md text-txt-black-700 mt-1">Pastikan maklumat anda tepat dan terkini.</p>
                    </div>
                    <div class="border-t border-otl-gray-200 p-6 space-y-6">
                        <div>
                            <label for="name" class="myds-label">Nama Penuh <span class="text-danger-600">*</span></label>
                            <input type="text" id="name" wire:model.defer="state.name" class="myds-input" required autocomplete="name">
                            @error('state.name') <p class="myds-error-msg mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="myds-label">Alamat E-mel <span class="text-danger-600">*</span></label>
                            <input type="email" id="email" wire:model.defer="state.email" class="myds-input" required autocomplete="email">
                             @error('state.email') <p class="myds-error-msg mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="mobile_number" class="myds-label">No. Telefon Bimbit</label>
                            <input type="tel" id="mobile_number" wire:model.defer="state.mobile_number" class="myds-input" placeholder="012-3456789" autocomplete="tel">
                             @error('state.mobile_number') <p class="myds-error-msg mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="bg-black-50 px-6 py-4 rounded-b-lg flex items-center justify-end">
                        <button type="submit" class="myds-btn myds-btn-primary" wire:loading.attr="disabled" wire:target="updateProfileInformation">
                            <span wire:loading.remove wire:target="updateProfileInformation">Simpan Perubahan</span>
                            <span wire:loading wire:target="updateProfileInformation">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </section>

            {{-- Change Password Form --}}
            <section class="bg-white rounded-lg shadow-card border border-otl-gray-200" aria-labelledby="change-password-heading">
                 <form wire:submit.prevent="updatePassword">
                    <div class="p-6">
                        <h2 id="change-password-heading" class="myds-heading-lg text-txt-black-900">Tukar Kata Laluan</h2>
                        <p class="myds-body-md text-txt-black-700 mt-1">Gunakan kata laluan yang kuat dan unik untuk melindungi akaun anda.</p>
                    </div>
                    <div class="border-t border-otl-gray-200 p-6 space-y-6">
                        <div>
                            <label for="current_password" class="myds-label">Kata Laluan Semasa <span class="text-danger-600">*</span></label>
                            <input type="password" id="current_password" wire:model.defer="state.current_password" class="myds-input" required autocomplete="current-password">
                            @error('state.current_password') <p class="myds-error-msg mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="myds-label">Kata Laluan Baru <span class="text-danger-600">*</span></label>
                            <input type="password" id="password" wire:model.defer="state.password" class="myds-input" required autocomplete="new-password">
                            @error('state.password') <p class="myds-error-msg mt-2">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="myds-label">Sahkan Kata Laluan Baru <span class="text-danger-600">*</span></label>
                            <input type="password" id="password_confirmation" wire:model.defer="state.password_confirmation" class="myds-input" required autocomplete="new-password">
                             @error('state.password_confirmation') <p class="myds-error-msg mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="bg-black-50 px-6 py-4 rounded-b-lg flex items-center justify-end">
                         <button type="submit" class="myds-btn myds-btn-primary" wire:loading.attr="disabled" wire:target="updatePassword">
                            <span wire:loading.remove wire:target="updatePassword">Tukar Kata Laluan</span>
                            <span wire:loading wire:target="updatePassword">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </section>
        </div>

        {{-- Session Message / Toast Placeholder --}}
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed bottom-5 right-5 bg-success-600 text-white py-2 px-4 rounded-lg shadow-lg">
                <p>{{ session('message') }}</p>
            </div>
        @endif
    </main>
</div>
@endsection
