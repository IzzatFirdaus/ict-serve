<?php

namespace App\Livewire;

use App\Models\Asset;
use App\Models\EquipmentCategory;
use App\Models\EquipmentItem;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class EquipmentSelector extends Component
{
    use WithPagination;

    // Search and filter properties
    public $search = '';
    public $selectedCategory = '';
    public $availabilityFilter = 'available';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    // Selection properties
    public $selectedItems = [];
    public $quantities = [];
    public $notes = [];

    // UI state properties
    public $showFilters = false;
    public $viewMode = 'grid'; // grid or list
    public $itemsPerPage = 12;

    // Parent component communication
    public $parentModel = null; // For emitting back to parent

    protected $listeners = [
        'equipmentSelected' => 'handleEquipmentSelected',
        'resetSelection' => 'resetSelection'
    ];

    public function mount($selectedItems = [], $parentModel = null)
    {
        $this->selectedItems = $selectedItems;
        $this->parentModel = $parentModel;
        
        // Initialize quantities and notes for pre-selected items
        foreach ($this->selectedItems as $itemId) {
            $this->quantities[$itemId] = $this->quantities[$itemId] ?? 1;
            $this->notes[$itemId] = $this->notes[$itemId] ?? '';
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatedAvailabilityFilter()
    {
        $this->resetPage();
    }

    public function toggleSort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function toggleItem($itemId)
    {
        if (in_array($itemId, $this->selectedItems)) {
            $this->removeItem($itemId);
        } else {
            $this->addItem($itemId);
        }
    }

    public function addItem($itemId)
    {
        if (!in_array($itemId, $this->selectedItems)) {
            $this->selectedItems[] = $itemId;
            $this->quantities[$itemId] = 1;
            $this->notes[$itemId] = '';
            $this->emitToParent();
        }
    }

    public function removeItem($itemId)
    {
        $this->selectedItems = array_filter($this->selectedItems, fn($id) => $id != $itemId);
        unset($this->quantities[$itemId]);
        unset($this->notes[$itemId]);
        $this->emitToParent();
    }

    public function updateQuantity($itemId, $quantity)
    {
        $quantity = max(1, min(10, (int)$quantity)); // Limit between 1-10
        $this->quantities[$itemId] = $quantity;
        $this->emitToParent();
    }

    public function updateNotes($itemId, $notes)
    {
        $this->notes[$itemId] = $notes;
        $this->emitToParent();
    }

    public function clearSelection()
    {
        $this->selectedItems = [];
        $this->quantities = [];
        $this->notes = [];
        $this->emitToParent();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedCategory = '';
        $this->availabilityFilter = 'available';
        $this->sortBy = 'name';
        $this->sortDirection = 'asc';
        $this->resetPage();
    }

    private function emitToParent()
    {
        $selectedEquipment = [];
        foreach ($this->selectedItems as $itemId) {
            $selectedEquipment[] = [
                'equipment_item_id' => $itemId,
                'quantity' => $this->quantities[$itemId] ?? 1,
                'notes' => $this->notes[$itemId] ?? ''
            ];
        }

        $this->dispatch('equipmentSelectionUpdated', $selectedEquipment);
    }

    public function getEquipmentQuery()
    {
        $query = EquipmentItem::with(['category'])
            ->where('is_active', true)
            ->where('status', '!=', 'damaged')
            ->where('status', '!=', 'disposed');

        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('asset_tag', 'like', '%' . $this->search . '%')
                  ->orWhere('model', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%');
            });
        }

        // Apply category filter
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        // Apply availability filter
        switch ($this->availabilityFilter) {
            case 'available':
                $query->where('status', 'available');
                break;
            case 'on_loan':
                $query->where('status', 'on_loan');
                break;
            case 'maintenance':
                $query->where('status', 'under_maintenance');
                break;
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query;
    }

    public function getCategories()
    {
        return EquipmentCategory::where('is_active', true)
            ->withCount(['equipmentItems' => function($query) {
                $query->where('is_active', true)
                      ->where('status', '!=', 'damaged')
                      ->where('status', '!=', 'disposed');
            }])
            ->orderBy('name')
            ->get();
    }

    public function getSelectedEquipmentDetails()
    {
        return EquipmentItem::whereIn('id', $this->selectedItems)
            ->with('category')
            ->get()
            ->map(function($item) {
                return [
                    'equipment' => $item,
                    'quantity' => $this->quantities[$item->id] ?? 1,
                    'notes' => $this->notes[$item->id] ?? ''
                ];
            });
    }

    public function render()
    {
        $equipment = $this->getEquipmentQuery()->paginate($this->itemsPerPage);
        $categories = $this->getCategories();
        $selectedEquipmentDetails = $this->getSelectedEquipmentDetails();

        return view('livewire.equipment-selector', [
            'equipment' => $equipment,
            'categories' => $categories,
            'selectedEquipmentDetails' => $selectedEquipmentDetails,
            'totalSelected' => count($this->selectedItems),
            'availabilityOptions' => [
                'available' => 'Tersedia',
                'on_loan' => 'Sedang Dipinjam',
                'maintenance' => 'Dalam Pemeliharaan',
                'all' => 'Semua Status'
            ],
            'sortOptions' => [
                'name' => 'Nama',
                'asset_tag' => 'Tag Aset',
                'brand' => 'Jenama',
                'model' => 'Model',
                'created_at' => 'Tarikh Ditambah'
            ]
        ]);
    }
}
