<div class="max-w-6xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Damage Type Management</h1>
        <p class="text-gray-600 mt-1">Manage damage types for helpdesk reports</p>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-800">{{ session('message') }}</p>
        </div>
    @endif

    {{-- Add New Button --}}
    <div class="mb-6">
        @if (!$showForm)
            <button wire:click="showCreateForm" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Add New Damage Type
            </button>
        @endif
    </div>

    {{-- Form --}}
    @if ($showForm)
        <div class="mb-8 bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">
                {{ $editingId ? 'Edit Damage Type' : 'Add New Damage Type' }}
            </h2>

            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name_en" class="block text-sm font-medium text-gray-700 mb-1">
                            English Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name_en"
                               wire:model.live="name_en" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name_en') border-red-500 @enderror"
                               placeholder="Enter English name">
                        @error('name_en')
                            <p class="text-red-500 text-sm mt-1" role="alert">
                                <span class="sr-only">Error:</span>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="name_bm" class="block text-sm font-medium text-gray-700 mb-1">
                            Bahasa Malaysia Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name_bm"
                               wire:model.live="name_bm" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name_bm') border-red-500 @enderror"
                               placeholder="Enter Bahasa Malaysia name">
                        @error('name_bm')
                            <p class="text-red-500 text-sm mt-1" role="alert">
                                <span class="sr-only">Error:</span>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               wire:model.live="is_active" 
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>

                <div class="flex gap-2">
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            wire:target="save"
                            class="bg-green-600 hover:bg-green-700 disabled:bg-green-400 text-white px-4 py-2 rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <span wire:loading.remove wire:target="save">
                            {{ $editingId ? 'Update' : 'Create' }}
                        </span>
                        <span wire:loading wire:target="save">
                            Saving...
                        </span>
                    </button>

                    <button type="button" 
                            wire:click="cancel"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-900">Existing Damage Types</h2>
        </div>
        
        @if ($damageTypes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                English Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Bahasa Malaysia Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($damageTypes as $damageType)
                            <tr class="hover:bg-gray-50" wire:key="damage-type-{{ $damageType->id }}">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $damageType->name_en }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $damageType->name_bm }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($damageType->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <span class="w-2 h-2 bg-green-400 rounded-full mr-1" aria-hidden="true"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <span class="w-2 h-2 bg-gray-400 rounded-full mr-1" aria-hidden="true"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $damageType->created_at->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button wire:click="edit({{ $damageType->id }})" 
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm focus:outline-none focus:underline">
                                        Edit
                                    </button>
                                    <button wire:click="delete({{ $damageType->id }})" 
                                            wire:confirm="Are you sure you want to delete this damage type? This action cannot be undone."
                                            class="text-red-600 hover:text-red-800 font-medium text-sm focus:outline-none focus:underline">
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
                <p class="text-gray-500">No damage types found. Create your first damage type to get started.</p>
            </div>
        @endif
    </div>
</div>
