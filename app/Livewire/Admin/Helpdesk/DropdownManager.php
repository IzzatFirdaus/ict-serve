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
    public string $name_en = '';

    #[Validate('required|string|max:255')]
    public string $name_bm = '';

    #[Validate('boolean')]
    public bool $is_active = true;

    public ?int $editingId = null;

    public bool $showForm = false;

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

    public function showCreateForm(): void
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editingId = null;
    }

    public function edit(int $id): void
    {
        $damageType = DamageType::findOrFail($id);

        $this->editingId = $id;
        $this->name_en = $damageType->name;
        $this->name_bm = $damageType->name_bm;
        $this->is_active = $damageType->is_active;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        if ($this->editingId) {
            $damageType = DamageType::findOrFail($this->editingId);
            $damageType->update([
                'name_en' => $this->name_en,
                'name_bm' => $this->name_bm,
                'is_active' => $this->is_active,
            ]);

            session()->flash('message', 'Damage type updated successfully.');
        } else {
            DamageType::create([
                'name_en' => $this->name_en,
                'name_bm' => $this->name_bm,
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

    public function cancel(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    protected function resetForm(): void
    {
        $this->name_en = '';
        $this->name_bm = '';
        $this->is_active = true;
        $this->editingId = null;
        $this->resetErrorBag();
    }

    protected function getDamageTypes(): Collection
    {
        return DamageType::ordered()->get();
    }
}
