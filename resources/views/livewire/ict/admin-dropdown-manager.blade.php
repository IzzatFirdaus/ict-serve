<div class="myds-container max-w-7xl mx-auto py-8">
  <!-- Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between mb-4">
      <h1
        class="text-heading-l font-semibold text-txt-black-900 dark:text-txt-black-900"
      >
        Admin Dropdown Manager
      </h1>
      <x-myds.tag variant="primary">MYDS Compliant</x-myds.tag>
    </div>
    <p class="text-body-base text-txt-black-700 dark:text-txt-black-700">
      Manage dropdown options used throughout the ICT system for damage types,
      departments, priorities, and categories. All data is stored securely and
      follows MYDS accessibility standards.
    </p>
  </div>

  <!-- Category Tabs -->
  <div class="mb-8">
    <div class="border-b border-otl-gray-200 dark:border-otl-gray-200">
      <nav class="-mb-px flex space-x-8" aria-label="Category navigation">
        @foreach ($categories as $category)
          <button
            wire:click="$set('activeCategory', '{{ $category['key'] }}')"
            class="flex items-center py-3 px-1 border-b-2 font-medium text-body-sm transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary dark:focus:ring-fr-primary rounded-t-lg {{ $activeCategory === $category['key'] ? 'border-primary-600 text-primary-600 dark:text-primary-600 dark:border-primary-600' : 'border-transparent text-txt-black-700 hover:text-txt-black-900 hover:border-otl-gray-300 dark:text-txt-black-700 dark:hover:text-txt-black-900 dark:hover:border-otl-gray-300' }}"
            aria-pressed="{{ $activeCategory === $category['key'] ? 'true' : 'false' }}"
          >
            @if ($category['icon'] === 'exclamation-triangle')
              <svg
                class="w-5 h-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"
                ></path>
              </svg>
            @elseif ($category['icon'] === 'office-building')
              <svg
                class="w-5 h-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                ></path>
              </svg>
            @elseif ($category['icon'] === 'flag')
              <svg
                class="w-5 h-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 2H21l-3 6 3 6h-8.5l-1-2H5a2 2 0 00-2 2zm9-13.5V9"
                ></path>
              </svg>
            @else
              <svg
                class="w-5 h-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                ></path>
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
  @if ($currentCategory)
    <div class="mb-8">
      <x-myds.callout variant="info">
        <h3
          class="text-body-sm font-medium text-txt-black-900 dark:text-txt-black-900 mb-1"
        >
          {{ $currentCategory['label'] }}
        </h3>
        <p class="text-body-sm text-txt-black-700 dark:text-txt-black-700">
          {{ $currentCategory['description'] }}
        </p>
      </x-myds.callout>
    </div>
  @endif

  <!-- Controls Bar -->
  <div
    class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8"
  >
    <!-- Search -->
    <div class="flex-1 max-w-md">
      <div class="relative">
        <input
          type="text"
          wire:model.live.debounce.300ms="searchTerm"
          placeholder="Search items..."
          class="myds-input pl-10"
          aria-label="Search dropdown items"
        />
        <div
          class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
        >
          <svg
            class="h-5 w-5 text-txt-black-400 dark:text-txt-black-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
            ></path>
          </svg>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex space-x-3">
      <x-myds.button
        variant="secondary"
        size="sm"
        wire:click="initializeDefaults"
        wire:loading.attr="disabled"
        wire:target="initializeDefaults"
      >
        <svg
          class="w-4 h-4 mr-2"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
          ></path>
        </svg>
        Initialize Defaults
      </x-myds.button>

      <x-myds.button variant="primary" size="sm" wire:click="showAddModal">
        <svg
          class="w-4 h-4 mr-2"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
          ></path>
        </svg>
        Add Item
      </x-myds.button>
    </div>
  </div>

  <!-- Items Table -->
  <div class="myds-card overflow-hidden">
    @if (empty($items))
      <div class="p-12 text-center">
        <svg
          class="mx-auto h-12 w-12 text-txt-black-400 dark:text-txt-black-400 mb-4"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
          ></path>
        </svg>
        <h3
          class="text-heading-xs font-medium text-txt-black-900 dark:text-txt-black-900 mb-2"
        >
          No items found
        </h3>
        <p
          class="text-body-base text-txt-black-500 dark:text-txt-black-500 mb-6"
        >
          @if (! empty($searchTerm))
            No items match your search for "{{ $searchTerm }}". Try adjusting
            your search terms.
          @else
              This category doesn't have any items yet. You can initialize
              default items or add new ones manually.
          @endif
        </p>
        @if (empty($searchTerm))
          <x-myds.button
            variant="primary"
            wire:click="initializeDefaults"
            wire:loading.attr="disabled"
            wire:target="initializeDefaults"
          >
            Initialize Default Items
          </x-myds.button>
        @endif
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="min-w-full" role="table">
          <thead>
            <tr class="border-b border-otl-gray-200 dark:border-otl-gray-200">
              <th
                class="px-6 py-4 text-left text-body-xs font-medium text-txt-black-500 dark:text-txt-black-500 uppercase tracking-wider"
              >
                Name
              </th>
              <th
                class="px-6 py-4 text-left text-body-xs font-medium text-txt-black-500 dark:text-txt-black-500 uppercase tracking-wider"
              >
                Description
              </th>
              <th
                class="px-6 py-4 text-left text-body-xs font-medium text-txt-black-500 dark:text-txt-black-500 uppercase tracking-wider"
              >
                Order
              </th>
              <th
                class="px-6 py-4 text-left text-body-xs font-medium text-txt-black-500 dark:text-txt-black-500 uppercase tracking-wider"
              >
                Status
              </th>
              <th
                class="px-6 py-4 text-right text-body-xs font-medium text-txt-black-500 dark:text-txt-black-500 uppercase tracking-wider"
              >
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-otl-gray-200 dark:divide-otl-gray-200">
            @foreach ($items as $item)
              <tr
                class="hover:bg-bg-white-50 dark:hover:bg-bg-white-50 transition-colors"
              >
                <td class="px-6 py-4">
                  <div
                    class="text-body-sm font-medium text-txt-black-900 dark:text-txt-black-900"
                  >
                    {{ $item->name }}
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div
                    class="text-body-sm text-txt-black-700 dark:text-txt-black-700 max-w-xs"
                  >
                    @if ($item->description)
                      <span title="{{ $item->description }}">
                        {{ Str::limit($item->description, 50) }}
                      </span>
                    @else
                      <span
                        class="text-txt-black-400 dark:text-txt-black-400 italic"
                      >
                        No description
                      </span>
                    @endif
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div
                    class="text-body-sm text-txt-black-700 dark:text-txt-black-700"
                  >
                    {{ $item->order_column }}
                  </div>
                </td>
                <td class="px-6 py-4">
                  <button
                    wire:click="toggleItemStatus({{ $item->id }})"
                    class="inline-flex items-center transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary dark:focus:ring-fr-primary rounded-full"
                    aria-pressed="{{ $item->is_active ? 'true' : 'false' }}"
                    title="Toggle status"
                  >
                    <x-myds.tag
                      :variant="$item->is_active ? 'success' : 'gray'"
                    >
                      <svg
                        class="w-3 h-3 mr-1"
                        fill="currentColor"
                        viewBox="0 0 8 8"
                      >
                        <circle cx="4" cy="4" r="3" />
                      </svg>
                      {{ $item->is_active ? 'Active' : 'Inactive' }}
                    </x-myds.tag>
                  </button>
                </td>
                <td class="px-6 py-4 text-right">
                  <div class="flex items-center justify-end space-x-2">
                    <button
                      wire:click="editItem({{ $item->id }})"
                      class="p-1 text-primary-600 hover:text-primary-700 dark:text-primary-600 dark:hover:text-primary-700 focus:outline-none focus:ring-2 focus:ring-fr-primary dark:focus:ring-fr-primary rounded"
                      title="Edit item"
                      aria-label="Edit {{ $item->name }}"
                    >
                      <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        ></path>
                      </svg>
                    </button>
                    <button
                      wire:click="confirmDelete({{ $item->id }})"
                      class="p-1 text-danger-600 hover:text-danger-700 dark:text-danger-600 dark:hover:text-danger-700 focus:outline-none focus:ring-2 focus:ring-fr-danger dark:focus:ring-fr-danger rounded"
                      title="Delete item"
                      aria-label="Delete {{ $item->name }}"
                    >
                      <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        ></path>
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

  <!-- Add/Edit Form Modal -->
  @if ($showAddForm)
    <div
      class="fixed inset-0 bg-gray-600/50 dark:bg-gray-900/50 overflow-y-auto h-full w-full z-50 backdrop-blur-sm"
      wire:click.self="resetForm"
      role="dialog"
      aria-modal="true"
      aria-labelledby="modal-title"
      x-show="true"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
    >
      <div
        class="relative top-20 mx-auto p-0 border-0 max-w-md shadow-context-menu rounded-lg bg-bg-white-0 dark:bg-bg-white-0"
      >
        <div class="p-6">
          <div class="flex items-center justify-between mb-6">
            <h3
              id="modal-title"
              class="text-heading-s font-semibold text-txt-black-900 dark:text-txt-black-900"
            >
              {{ $editingItemId ? 'Edit Item' : 'Add New Item' }}
            </h3>
            <button
              wire:click="resetForm"
              class="p-1 text-txt-black-400 hover:text-txt-black-600 dark:text-txt-black-400 dark:hover:text-txt-black-600 focus:outline-none focus:ring-2 focus:ring-fr-primary rounded"
              aria-label="Close modal"
            >
              <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                ></path>
              </svg>
            </button>
          </div>

          <form wire:submit="saveItem" class="space-y-6">
            <x-myds.input
              name="itemName"
              label="Name"
              wire:model.blur="itemName"
              required
              placeholder="Enter item name"
            />

            <x-myds.textarea
              name="itemDescription"
              label="Description"
              wire:model.blur="itemDescription"
              placeholder="Enter item description (optional)"
              :maxlength="500"
            />

            <div class="grid grid-cols-2 gap-4">
              <x-myds.input
                name="itemOrder"
                label="Order"
                type="number"
                wire:model.blur="itemOrder"
                min="1"
                max="100"
                placeholder="10"
              />

              <div class="myds-field">
                <label class="myds-label">Status</label>
                <div
                  class="flex items-center mt-2"
                  x-data="{ active: @entangle('itemActive') }"
                >
                  <label class="flex items-center cursor-pointer">
                    <input
                      type="checkbox"
                      wire:model.live="itemActive"
                      class="sr-only"
                    />
                    <div class="relative">
                      <div
                        class="w-10 h-6 rounded-full shadow-inner transition duration-200"
                        :class="active ? 'bg-primary-600' : 'bg-otl-gray-300 dark:bg-otl-gray-300'"
                      ></div>
                      <div
                        class="absolute w-4 h-4 bg-bg-white-0 dark:bg-bg-white-0 rounded-full shadow -left-1 -top-1 transition duration-200 transform"
                        :class="active ? 'translate-x-full' : ''"
                      ></div>
                    </div>
                    <span
                      class="ml-3 text-body-sm text-txt-black-700 dark:text-txt-black-700"
                    >
                      <span x-text="active ? 'Active' : 'Inactive'"></span>
                    </span>
                  </label>
                </div>
              </div>
            </div>

            <div
              class="flex justify-end space-x-3 pt-4 border-t border-otl-gray-200 dark:border-otl-gray-200"
            >
              <x-myds.button
                type="button"
                variant="secondary"
                wire:click="resetForm"
              >
                Cancel
              </x-myds.button>

              <x-myds.button
                type="submit"
                variant="primary"
                :loading="$loading"
                wire:loading.attr="disabled"
                wire:target="saveItem"
              >
                <span wire:loading.remove wire:target="saveItem">
                  {{ $editingItemId ? 'Update Item' : 'Save Item' }}
                </span>
                <span wire:loading wire:target="saveItem">Saving...</span>
              </x-myds.button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif

  <!-- Delete Confirmation Modal -->
  @if ($showDeleteModal && $itemToDelete)
    <div
      class="fixed inset-0 bg-gray-600/50 dark:bg-gray-900/50 overflow-y-auto h-full w-full z-50 backdrop-blur-sm"
      wire:click.self="$set('showDeleteModal', false)"
      role="dialog"
      aria-modal="true"
      aria-labelledby="delete-modal-title"
      x-show="true"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
    >
      <div
        class="relative top-20 mx-auto p-0 border-0 max-w-md shadow-context-menu rounded-lg bg-bg-white-0 dark:bg-bg-white-0"
      >
        <div class="p-6">
          <div class="flex items-start space-x-4 mb-6">
            <div class="flex-shrink-0">
              <div
                class="w-10 h-10 bg-danger-50 dark:bg-danger-50 rounded-full flex items-center justify-center"
              >
                <svg
                  class="w-6 h-6 text-danger-600 dark:text-danger-600"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"
                  ></path>
                </svg>
              </div>
            </div>

            <div class="flex-1 min-w-0">
              <h3
                id="delete-modal-title"
                class="text-heading-s font-semibold text-txt-black-900 dark:text-txt-black-900 mb-2"
              >
                Delete Item
              </h3>
              <p
                class="text-body-sm text-txt-black-700 dark:text-txt-black-700 leading-relaxed"
              >
                Are you sure you want to delete
                <span
                  class="font-medium text-txt-black-900 dark:text-txt-black-900"
                >
                  "{{ $itemToDelete->name }}"
                </span>
                ? This action cannot be undone.
              </p>
            </div>

            <button
              wire:click="$set('showDeleteModal', false)"
              class="p-1 text-txt-black-400 hover:text-txt-black-600 dark:text-txt-black-400 dark:hover:text-txt-black-600 focus:outline-none focus:ring-2 focus:ring-fr-primary rounded"
              aria-label="Close modal"
            >
              <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                ></path>
              </svg>
            </button>
          </div>

          <div
            class="flex justify-end space-x-3 pt-4 border-t border-otl-gray-200 dark:border-otl-gray-200"
          >
            <x-myds.button
              type="button"
              variant="secondary"
              wire:click="$set('showDeleteModal', false)"
            >
              Cancel
            </x-myds.button>

            <x-myds.button
              type="button"
              variant="danger"
              wire:click="deleteItem"
              :loading="$loading"
              wire:loading.attr="disabled"
              wire:target="deleteItem"
            >
              <span wire:loading.remove wire:target="deleteItem">Delete</span>
              <span wire:loading wire:target="deleteItem">Deleting...</span>
            </x-myds.button>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
