<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-h2 text-gray-900 dark:text-gray-100 mb-2">
            Admin Dropdown Manager
        </h1>
        <p class="text-body-lg text-gray-600 dark:text-gray-400">
            Manage dropdown options used throughout the ICT system for damage types, departments, priorities, and categories.
        </p>
    </div>

    <!-- Category Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex space-x-8">
                @foreach($categories as $category)
                    <button
                        wire:click="$set('activeCategory', '{{ $category['key'] }}')"
                        class="flex items-center py-2 px-1 border-b-2 font-medium text-sm transition-colors
                            {{ $activeCategory === $category['key']
                                ? 'border-primary-500 text-primary-600 dark:text-primary-400'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}"
                    >
                        @if($category['icon'] === 'exclamation-triangle')
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        @elseif($category['icon'] === 'office-building')
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        @elseif($category['icon'] === 'flag')
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 2H21l-3 6 3 6h-8.5l-1-2H5a2 2 0 00-2 2zm9-13.5V9"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        @endif
                        {{ $category['label'] }}
                    </button>
                @endforeach
            </nav>
        </div>
    </div>

    @php
        $currentCategory = collect($categories)->firstWhere('key', $activeCategory);
    @endphp

    <!-- Category Description -->
    @if($currentCategory)
        <div class="mb-6 p-4 bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800 rounded-lg">
            <p class="text-primary-800 dark:text-primary-200">
                {{ $currentCategory['description'] }}
            </p>
        </div>
    @endif

    <!-- Controls Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <!-- Search -->
        <div class="flex-1 max-w-md">
            <div class="relative">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="searchTerm"
                    placeholder="Search items..."
                    class="form-input pl-10"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-3">
            <button
                wire:click="initializeDefaults"
                class="btn-secondary"
                title="Initialize default items for this category"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Initialize Defaults
            </button>

            <button
                wire:click="showAddModal"
                class="btn-primary"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Item
            </button>
        </div>
    </div>

    <!-- Items Table -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        @if(empty($items))
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 text-lg mb-4">
                    No items found{{ !empty($searchTerm) ? ' for "' . $searchTerm . '"' : '' }}
                </p>
                @if(empty($searchTerm))
                    <button
                        wire:click="initializeDefaults"
                        class="btn-primary"
                    >
                        Initialize Default Items
                    </button>
                @endif
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Description
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Order
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($items as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $item->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate">
                                    {{ $item->description ?: '—' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $item->order_column }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button
                                    wire:click="toggleItemStatus({{ $item->id }})"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors
                                        {{ $item->is_active
                                            ? 'bg-success-100 text-success-800 hover:bg-success-200 dark:bg-success-900/20 dark:text-success-400'
                                            : 'bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-gray-900/20 dark:text-gray-400' }}"
                                >
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"/>
                                    </svg>
                                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button
                                        wire:click="editItem({{ $item->id }})"
                                        class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300"
                                        title="Edit item"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button
                                        wire:click="confirmDelete({{ $item->id }})"
                                        class="text-danger-600 hover:text-danger-900 dark:text-danger-400 dark:hover:text-danger-300"
                                        title="Delete item"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Add/Edit Form Modal -->
    @if($showAddForm)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click.self="resetForm">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ $editingItemId ? 'Edit Item' : 'Add New Item' }}
                        </h3>
                        <button
                            wire:click="resetForm"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="saveItem" class="space-y-4">
                        <div>
                            <label for="itemName" class="form-label required">
                                Name
                            </label>
                            <input
                                type="text"
                                id="itemName"
                                wire:model.blur="itemName"
                                class="form-input @error('itemName') error @enderror"
                                placeholder="Enter item name"
                            >
                            @error('itemName')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="itemDescription" class="form-label">
                                Description
                            </label>
                            <textarea
                                id="itemDescription"
                                wire:model.blur="itemDescription"
                                rows="3"
                                class="form-input @error('itemDescription') error @enderror"
                                placeholder="Enter item description (optional)"
                            ></textarea>
                            @error('itemDescription')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="itemOrder" class="form-label">
                                    Order
                                </label>
                                <input
                                    type="number"
                                    id="itemOrder"
                                    wire:model.blur="itemOrder"
                                    min="1"
                                    max="100"
                                    class="form-input @error('itemOrder') error @enderror"
                                >
                                @error('itemOrder')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">Status</label>
                                <div class="flex items-center mt-2">
                                    <label class="flex items-center cursor-pointer">
                                        <input
                                            type="checkbox"
                                            wire:model.live="itemActive"
                                            class="sr-only"
                                        >
                                        <div class="relative">
                                            <div class="w-10 h-6 bg-gray-200 rounded-full shadow-inner transition {{ $itemActive ? 'bg-primary-600' : '' }}"></div>
                                            <div class="dot absolute w-4 h-4 bg-white rounded-full shadow -left-1 -top-1 transition {{ $itemActive ? 'transform translate-x-full bg-white' : '' }}"></div>
                                        </div>
                                        <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                            {{ $itemActive ? 'Active' : 'Inactive' }}
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4">
                            <button
                                type="button"
                                wire:click="resetForm"
                                class="btn-secondary"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="btn-primary {{ $loading ? 'opacity-75 cursor-not-allowed' : '' }}"
                                {{ $loading ? 'disabled' : '' }}
                            >
                                @if($loading)
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Saving...
                                @else
                                    {{ $editingItemId ? 'Update' : 'Save' }}
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal && $itemToDelete)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click.self="$set('showDeleteModal', false)">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-danger-100 dark:bg-danger-900/20 mb-4">
                        <svg class="h-6 w-6 text-danger-600 dark:text-danger-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                        Delete Item
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        Are you sure you want to delete "<strong>{{ $itemToDelete->name }}</strong>"? This action cannot be undone.
                    </p>
                    <div class="flex justify-center space-x-3">
                        <button
                            wire:click="$set('showDeleteModal', false)"
                            class="btn-secondary"
                        >
                            Cancel
                        </button>
                        <button
                            wire:click="deleteItem"
                            class="btn-danger {{ $loading ? 'opacity-75 cursor-not-allowed' : '' }}"
                            {{ $loading ? 'disabled' : '' }}
                        >
                            @if($loading)
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Deleting...
                            @else
                                Delete
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
