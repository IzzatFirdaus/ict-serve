<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Helpdesk;

use App\Models\DamageType;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DropdownManager extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:255')]
    public string $name_bm = '';

    #[Validate('nullable|string|max:1000')]
    public string $description = '';

    #[Validate('nullable|string|max:1000')]
    public string $description_bm = '';

    #[Validate('required|in:low,medium,high,critical')]
    public string $severity = 'medium';

    #[Validate('required|integer|min:0')]
    public int $sort_order = 0;

    #[Validate('boolean')]
    public bool $is_active = true;

    public ?int $editingId = null;

    public bool $showForm = false;

    // Filter properties for search functionality
    public string $search = '';
    public string $severityFilter = '';

    public function mount(): void
    {
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.admin.helpdesk.dropdown-manager', [
            'damageTypes' => $this->getDamageTypes(),
        ]);
    }

    // Computed property for testing
    public function getDamageTypesProperty()
    {
        return $this->getDamageTypes();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editingId = null;
    }

    public function showCreateForm(): void
    {
        $this->create();
    }

    public function edit(int $id): void
    {
        $damageType = DamageType::findOrFail($id);

        $this->editingId = $id;
        $this->name = $damageType->name;
        $this->name_bm = $damageType->name_bm;
        $this->description = $damageType->description ?? '';
        $this->description_bm = $damageType->description_bm ?? '';
        $this->severity = $damageType->severity;
        $this->sort_order = $damageType->sort_order;
        $this->is_active = $damageType->is_active;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        if ($this->editingId) {
            $damageType = DamageType::findOrFail($this->editingId);
            $damageType->update([
                'name' => $this->name,
                'name_bm' => $this->name_bm,
                'description' => $this->description,
                'description_bm' => $this->description_bm,
                'severity' => $this->severity,
                'sort_order' => $this->sort_order,
                'is_active' => $this->is_active,
            ]);

            session()->flash('message', 'Damage type updated successfully.');
        } else {
            DamageType::create([
                'name' => $this->name,
                'name_bm' => $this->name_bm,
                'description' => $this->description,
                'description_bm' => $this->description_bm,
                'severity' => $this->severity,
                'sort_order' => $this->sort_order,
                'is_active' => $this->is_active,
            ]);

            session()->flash('message', 'Damage type created successfully.');
        }

        $this->dispatch('damage-types-updated');
        $this->resetForm();
        $this->showForm = false;
    }

    public function delete(int $id): void
    {
        $damageType = DamageType::findOrFail($id);
        $damageType->delete();

        session()->flash('message', 'Damage type deleted successfully.');
        $this->dispatch('damage-types-updated');
    }

    public function toggleStatus(int $id): void
    {
        $damageType = DamageType::findOrFail($id);
        $damageType->update(['is_active' => !$damageType->is_active]);

        session()->flash('message', 'Damage type status updated successfully.');
        $this->dispatch('damage-types-updated');
    }

    public function cancel(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function cancelEdit(): void
    {
        $this->cancel();
    }

    protected function resetForm(): void
    {
        $this->name = '';
        $this->name_bm = '';
        $this->description = '';
        $this->description_bm = '';
        $this->severity = 'medium';
        $this->sort_order = 0;
        $this->is_active = true;
        $this->editingId = null;
        $this->resetErrorBag();
    }

    protected function getDamageTypes(): Collection
    {
        $query = DamageType::query();

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('name_bm', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('description_bm', 'like', '%' . $this->search . '%');
            });
        }

        // Apply severity filter
        if (!empty($this->severityFilter)) {
            $query->where('severity', $this->severityFilter);
        }

        return $query->ordered()->get();
    }
}
