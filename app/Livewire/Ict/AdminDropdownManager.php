<?php

namespace App\Livewire\Ict;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AdminDropdownManager extends Component
{
    // Form properties
    #[Validate('required|string|in:damage_types,departments,priorities,categories')]
    public $activeCategory = 'damage_types';

    #[Validate('required|string|min:2|max:255')]
    public $itemName = '';

    #[Validate('nullable|string|max:500')]
    public $itemDescription = '';

    #[Validate('nullable|integer|min:1|max:100')]
    public $itemOrder = 10;

    #[Validate('nullable|boolean')]
    public $itemActive = true;

    // Component state
    public $editingItemId = null;

    public $showAddForm = false;

    public $showDeleteModal = false;

    public $itemToDelete = null;

    public $loading = false;

    // Data collections
    public $categories = [];

    public $items = [];

    public $searchTerm = '';

    protected $categories_config = [
        'damage_types' => [
            'label' => 'Damage Types',
            'description' => 'Types of damage that can be reported for ICT equipment',
            'table' => 'dropdown_damage_types',
            'icon' => 'exclamation-triangle',
            'default_items' => [
                'Hardware Failure',
                'Software Issues',
                'Physical Damage',
                'Network Problems',
                'Display Issues',
                'Power Issues',
                'Connectivity Problems',
                'Performance Issues',
                'Other',
            ],
        ],
        'departments' => [
            'label' => 'Departments',
            'description' => 'Organization departments for user categorization',
            'table' => 'dropdown_departments',
            'icon' => 'office-building',
            'default_items' => [
                'Information Technology',
                'Human Resources',
                'Finance',
                'Operations',
                'Administration',
                'Legal',
                'Communications',
                'Security',
                'Facilities',
            ],
        ],
        'priorities' => [
            'label' => 'Priority Levels',
            'description' => 'Priority levels for ticket categorization',
            'table' => 'dropdown_priorities',
            'icon' => 'flag',
            'default_items' => [
                'Low',
                'Medium',
                'High',
                'Urgent',
                'Critical',
            ],
        ],
        'categories' => [
            'label' => 'Ticket Categories',
            'description' => 'Categories for helpdesk ticket classification',
            'table' => 'dropdown_categories',
            'icon' => 'tag',
            'default_items' => [
                'ICT Damage Report',
                'Software Issue',
                'Hardware Request',
                'Network Problem',
                'Account Access',
                'Training Request',
                'Other',
            ],
        ],
    ];

    public function mount()
    {
        $this->categories = collect($this->categories_config)->map(function ($config, $key) {
            return array_merge($config, ['key' => $key]);
        })->values()->toArray();

        $this->loadItems();
    }

    public function loadItems()
    {
        $config = $this->categories_config[$this->activeCategory] ?? null;
        if (! $config) {
            $this->items = [];

            return;
        }

        // Create table if it doesn't exist
        $this->createCategoryTable($this->activeCategory);

        // Load items from database
        $query = DB::table($config['table']);

        if (! empty($this->searchTerm)) {
            $query->where('name', 'like', '%'.$this->searchTerm.'%')
                ->orWhere('description', 'like', '%'.$this->searchTerm.'%');
        }

        $this->items = $query->orderBy('order_column', 'asc')
            ->orderBy('name', 'asc')
            ->get()
            ->toArray();
    }

    public function updatedActiveCategory()
    {
        $this->reset(['itemName', 'itemDescription', 'itemOrder', 'editingItemId', 'showAddForm', 'searchTerm']);
        $this->itemActive = true;
        $this->loadItems();
    }

    public function updatedSearchTerm()
    {
        $this->loadItems();
    }

    public function showAddModal()
    {
        $this->reset(['itemName', 'itemDescription', 'editingItemId']);
        $this->itemOrder = $this->getNextOrderNumber();
        $this->itemActive = true;
        $this->showAddForm = true;
    }

    public function editItem($itemId)
    {
        $config = $this->categories_config[$this->activeCategory];
        $item = DB::table($config['table'])->where('id', $itemId)->first();

        if ($item) {
            $this->editingItemId = $item->id;
            $this->itemName = $item->name;
            $this->itemDescription = $item->description ?? '';
            $this->itemOrder = $item->order_column;
            $this->itemActive = (bool) $item->is_active;
            $this->showAddForm = true;
        }
    }

    public function saveItem()
    {
        $this->validate([
            'itemName' => 'required|string|min:2|max:255',
            'itemDescription' => 'nullable|string|max:500',
            'itemOrder' => 'nullable|integer|min:1|max:100',
        ]);

        $this->loading = true;

        try {
            $config = $this->categories_config[$this->activeCategory];
            $data = [
                'name' => $this->itemName,
                'description' => $this->itemDescription,
                'order_column' => $this->itemOrder ?: $this->getNextOrderNumber(),
                'is_active' => $this->itemActive,
                'updated_at' => now(),
                'updated_by' => Auth::id(),
            ];

            if ($this->editingItemId) {
                // Update existing item
                DB::table($config['table'])
                    ->where('id', $this->editingItemId)
                    ->update($data);

                $message = "Item '{$this->itemName}' updated successfully";
            } else {
                // Create new item
                $data['created_at'] = now();
                $data['created_by'] = Auth::id();

                DB::table($config['table'])->insert($data);
                $message = "Item '{$this->itemName}' created successfully";
            }

            $this->dispatch('toast-show', [
                'type' => 'success',
                'title' => $this->editingItemId ? 'Item Updated' : 'Item Created',
                'message' => $message,
                'duration' => 3000,
            ]);

            $this->resetForm();
            $this->loadItems();

        } catch (\Exception $e) {
            $this->dispatch('toast-show', [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Failed to save item. Please try again.',
                'duration' => 5000,
            ]);

            Log::error('Admin dropdown manager save failed', [
                'category' => $this->activeCategory,
                'item_name' => $this->itemName,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
        } finally {
            $this->loading = false;
        }
    }

    public function confirmDelete($itemId)
    {
        $config = $this->categories_config[$this->activeCategory];
        $this->itemToDelete = DB::table($config['table'])->where('id', $itemId)->first();
        $this->showDeleteModal = true;
    }

    public function deleteItem()
    {
        if (! $this->itemToDelete) {
            return;
        }

        $this->loading = true;

        try {
            $config = $this->categories_config[$this->activeCategory];
            DB::table($config['table'])->where('id', $this->itemToDelete->id)->delete();

            $this->dispatch('toast-show', [
                'type' => 'success',
                'title' => 'Item Deleted',
                'message' => "Item '{$this->itemToDelete->name}' deleted successfully",
                'duration' => 3000,
            ]);

            $this->showDeleteModal = false;
            $this->itemToDelete = null;
            $this->loadItems();

        } catch (\Exception $e) {
            $this->dispatch('toast-show', [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Failed to delete item. Please try again.',
                'duration' => 5000,
            ]);

            Log::error('Admin dropdown manager delete failed', [
                'category' => $this->activeCategory,
                'item_id' => $this->itemToDelete->id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
        } finally {
            $this->loading = false;
        }
    }

    public function toggleItemStatus($itemId)
    {
        try {
            $config = $this->categories_config[$this->activeCategory];
            $item = DB::table($config['table'])->where('id', $itemId)->first();

            if ($item) {
                $newStatus = ! $item->is_active;
                DB::table($config['table'])
                    ->where('id', $itemId)
                    ->update([
                        'is_active' => $newStatus,
                        'updated_at' => now(),
                        'updated_by' => Auth::id(),
                    ]);

                $statusText = $newStatus ? 'enabled' : 'disabled';
                $this->dispatch('toast-show', [
                    'type' => 'success',
                    'title' => 'Status Updated',
                    'message' => "Item '{$item->name}' {$statusText}",
                    'duration' => 2000,
                ]);

                $this->loadItems();
            }
        } catch (\Exception $e) {
            $this->dispatch('toast-show', [
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Failed to update item status',
                'duration' => 3000,
            ]);
        }
    }

    public function initializeDefaults()
    {
        $config = $this->categories_config[$this->activeCategory];

        try {
            $this->createCategoryTable($this->activeCategory);

            $existingCount = DB::table($config['table'])->count();

            if ($existingCount === 0) {
                $items = [];
                foreach ($config['default_items'] as $index => $itemName) {
                    $items[] = [
                        'name' => $itemName,
                        'description' => null,
                        'order_column' => ($index + 1) * 10,
                        'is_active' => true,
                        'created_at' => now(),
                        'created_by' => Auth::id(),
                        'updated_at' => now(),
                        'updated_by' => Auth::id(),
                    ];
                }

                DB::table($config['table'])->insert($items);

                $this->dispatch('toast-show', [
                    'type' => 'success',
                    'title' => 'Defaults Initialized',
                    'message' => count($items)." default items created for {$config['label']}",
                    'duration' => 3000,
                ]);

                $this->loadItems();
            } else {
                $this->dispatch('toast-show', [
                    'type' => 'info',
                    'title' => 'Already Initialized',
                    'message' => "Default items already exist for {$config['label']}",
                    'duration' => 3000,
                ]);
            }

        } catch (\Exception $e) {
            $this->dispatch('toast-show', [
                'type' => 'error',
                'title' => 'Initialization Failed',
                'message' => 'Failed to initialize default items',
                'duration' => 5000,
            ]);

            Log::error('Admin dropdown manager initialization failed', [
                'category' => $this->activeCategory,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
        }
    }

    private function createCategoryTable($category)
    {
        $config = $this->categories_config[$category];
        $tableName = $config['table'];
        if (! \Illuminate\Support\Facades\Schema::hasTable($tableName)) {
            \Illuminate\Support\Facades\Schema::create($tableName, function ($table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->integer('order_column')->default(10);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();

                $table->index(['is_active', 'order_column']);
                $table->index('name');
            });
        }
    }

    private function getNextOrderNumber()
    {
        $config = $this->categories_config[$this->activeCategory];
        $maxOrder = DB::table($config['table'])->max('order_column') ?: 0;

        return $maxOrder + 10;
    }

    private function resetForm()
    {
        $this->reset(['itemName', 'itemDescription', 'itemOrder', 'editingItemId', 'showAddForm']);
        $this->itemActive = true;
    }

    public function render()
    {
        return view('livewire.ict.admin-dropdown-manager');
    }
}
