<div class="max-w-6xl mx-auto p-6" role="region" aria-labelledby="damage-type-heading">
    {{-- Page header (MYDS: Heading Medium, accessible) --}}
    <div class="mb-6">
        <h1 id="damage-type-heading" class="text-2xl font-semibold text-txt-black-900">
            Damage Type Management
        </h1>
        <p class="text-txt-black-500 mt-1">Manage damage types used in ICT Service (iServe) helpdesk reports.</p>
    </div>

    {{-- Flash Messages (accessible, semantic) --}}
    @if (session()->has('message'))
        <div class="mb-6 p-4 rounded-lg bg-success-50 border otl-success-200" role="status" aria-live="polite">
            <p class="text-txt-success">{{ session('message') }}</p>
        </div>
    @endif

    {{-- Add New Button --}}
    <div class="mb-6">
        @if (!$showForm)
            <button wire:click="showCreateForm"
                    type="button"
                    class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded radius-m focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary focus-visible:ring-offset-2"
                    aria-haspopup="dialog"
                    aria-controls="damage-type-form">
                {{-- Using an accessible "plus" icon (SVG inline for reliability) --}}
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                    <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="font-medium">Add New Damage Type</span>
            </button>
        @endif
    </div>

    {{-- Form (MYDS & A11y)
         - wire:submit.prevent to avoid full page reload
         - wire:model.defer for better performance & explicit update on submit
         - form has an accessible name and role
    --}}
    @if ($showForm)
        <div id="damage-type-form" class="mb-8 bg-white border otl-divider rounded-lg p-6" role="dialog" aria-labelledby="form-heading" aria-modal="false">
            <h2 id="form-heading" class="text-lg font-semibold mb-4">
                {{ $editingId ? 'Edit Damage Type' : 'Add New Damage Type' }}
            </h2>

            {{-- Use prevent to stop default submit --}}
            <form wire:submit.prevent="save" class="space-y-4" novalidate>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name_en" class="block text-sm font-medium text-txt-black-700 mb-1">
                            English Name <span class="text-danger-600" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="text"
                            id="name_en"
                            wire:model.defer="name_en"
                            aria-required="true"
                            aria-describedby="name_en_help name_en_error"
                            class="w-full px-3 py-2 border otl-gray-300 rounded radius-s focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary focus-visible:ring-offset-2 @error('name_en') otl-danger-300 border-danger-600 @enderror"
                            placeholder="Enter English name">
                        <p id="name_en_help" class="text-xs text-txt-black-500 mt-1">Enter a short, descriptive English label (e.g. "Screen Crack").</p>
                        @error('name_en')
                            <p id="name_en_error" class="text-sm mt-1 text-txt-danger" role="alert">
                                <span class="sr-only">Error:</span>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="name_bm" class="block text-sm font-medium text-txt-black-700 mb-1">
                            Bahasa Malaysia Name <span class="text-danger-600" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="text"
                            id="name_bm"
                            wire:model.defer="name_bm"
                            aria-required="true"
                            aria-describedby="name_bm_help name_bm_error"
                            class="w-full px-3 py-2 border otl-gray-300 rounded radius-s focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary focus-visible:ring-offset-2 @error('name_bm') otl-danger-300 border-danger-600 @enderror"
                            placeholder="Enter Bahasa Malaysia name">
                        <p id="name_bm_help" class="text-xs text-txt-black-500 mt-1">Masukkan label ringkas dalam Bahasa Malaysia.</p>
                        @error('name_bm')
                            <p id="name_bm_error" class="text-sm mt-1 text-txt-danger" role="alert">
                                <span class="sr-only">Error:</span>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="is_active" class="flex items-center cursor-pointer select-none">
                        <input
                            id="is_active"
                            type="checkbox"
                            wire:model.defer="is_active"
                            class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-fr-primary focus:ring-2"
                            aria-checked="{{ $is_active ? 'true' : 'false' }}">
                        <span class="ml-2 text-sm text-txt-black-700">Active</span>
                    </label>
                    <p class="sr-only" id="is_active_hint">Toggle to make this damage type available in dropdowns.</p>
                </div>

                <div class="flex gap-2">
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="save"
                        class="inline-flex items-center gap-2 bg-success-600 hover:bg-success-700 text-white px-4 py-2 rounded radius-m focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary focus-visible:ring-offset-2 disabled:opacity-60"
                        aria-describedby="save_status">
                        <span wire:loading.remove wire:target="save" class="font-medium">
                            {{ $editingId ? 'Update' : 'Create' }}
                        </span>
                        <span wire:loading wire:target="save" class="font-medium">Saving...</span>
                    </button>

                    <button
                        type="button"
                        wire:click="cancel"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded radius-m focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary focus-visible:ring-offset-2">
                        Cancel
                    </button>
                </div>
                <p id="save_status" class="sr-only" aria-live="polite"></p>
            </form>
        </div>
    @endif

    {{-- Table (MYDS table semantics, accessible caption, time element) --}}
    <div class="bg-white border otl-divider rounded-lg overflow-hidden" role="region" aria-labelledby="existing-damage-types-heading">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 id="existing-damage-types-heading" class="text-lg font-semibold text-txt-black-900">Existing Damage Types</h2>
        </div>

        @if ($damageTypes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full" role="table" aria-describedby="damage-types-caption">
                    <caption id="damage-types-caption" class="sr-only">List of existing damage types with status, creation date, and actions</caption>
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider">English Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider">Bahasa Malaysia Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider">Created</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-txt-black-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($damageTypes as $damageType)
                            <tr class="hover:bg-gray-50" wire:key="damage-type-{{ $damageType->id }}">
                                <td class="px-6 py-4 text-sm font-medium text-txt-black-900">
                                    {{ $damageType->name_en }}
                                </td>
                                <td class="px-6 py-4 text-sm text-txt-black-700">
                                    {{ $damageType->name_bm }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($damageType->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700">
                                            <span class="w-2 h-2 bg-success-400 rounded-full mr-1" aria-hidden="true"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <span class="w-2 h-2 bg-gray-400 rounded-full mr-1" aria-hidden="true"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-txt-black-500">
                                    <time datetime="{{ $damageType->created_at->toDateString() }}">
                                        {{ $damageType->created_at->format('M j, Y') }}
                                    </time>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button
                                        type="button"
                                        wire:click="edit({{ $damageType->id }})"
                                        class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-medium text-sm focus:outline-none focus-visible:underline"
                                        aria-label="Edit {{ $damageType->name_en }}">
                                        {{-- Pencil/Edit icon --}}
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <path d="M3 21v-3.75L17.81 2.44a2.25 2.25 0 0 1 3.18 0l.57.57a2.25 2.25 0 0 1 0 3.18L7.75 21H3z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $damageType->id }})"
                                        wire:confirm="Are you sure you want to delete this damage type? This action cannot be undone."
                                        class="inline-flex items-center gap-2 text-danger-600 hover:text-danger-800 font-medium text-sm focus:outline-none focus-visible:underline"
                                        aria-label="Delete {{ $damageType->name_en }}">
                                        {{-- Trash icon --}}
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <path d="M3 6h18M8 6v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6M10 6V4a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <p class="text-text-muted">No damage types found. Create your first damage type to get started.</p>
                <div class="mt-4">
                    <button wire:click="showCreateForm" type="button" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded radius-m focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary focus-visible:ring-offset-2">
                        Add first damage type
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
