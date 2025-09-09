<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\DamageType;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.iserve')]
class DropdownManager extends Component
{
    use WithPagination;

    // Form fields
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:255')]
    public string $name_bm = '';

    #[Validate('nullable|string|max:1000')]
    public string $description = '';

    #[Validate('nullable|string|max:1000')]
    public string $description_bm = '';

    #[Validate('nullable|string|max:50')]
    public string $icon = '';

    #[Validate('required|in:low,medium,high,critical')]
    public string $severity = 'medium';

    #[Validate('boolean')]
    public bool $is_active = true;

    #[Validate('required|integer|min:0')]
    public int $sort_order = 0;

    #[Validate('nullable|string|regex:/^#[0-9A-Fa-f]{6}$/')]
    public string $color_code = '';

    // Component state
    public ?int $editingId = null;
    public bool $showForm = false;
    public string $search = '';
    public string $severityFilter = '';
    public string $statusFilter = '';

    protected $paginationTheme = 'simple-bootstrap-4';

    public function mount(): void
    {
        $this->search = '';
        $this->severityFilter = '';
        $this->statusFilter = '';
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSeverityFilter(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editingId = null;
    }

    public function edit(int $id): void
    {
        $damageType = DamageType::findOrFail($id);
        
        $this->editingId = $id;
        $this->name = $damageType->name;
        $this->name_bm = $damageType->name_bm;
        $this->description = $damageType->description ?? '';
        $this->description_bm = $damageType->description_bm ?? '';
        $this->icon = $damageType->icon ?? '';
        $this->severity = $damageType->severity;
        $this->is_active = $damageType->is_active;
        $this->sort_order = $damageType->sort_order;
        $this->color_code = $damageType->color_code ?? '';
        
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        try {
            DB::transaction(function (): void {
                $data = [
                    'name' => $this->name,
                    'name_bm' => $this->name_bm,
                    'description' => $this->description ?: null,
                    'description_bm' => $this->description_bm ?: null,
                    'icon' => $this->icon ?: null,
                    'severity' => $this->severity,
                    'is_active' => $this->is_active,
                    'sort_order' => $this->sort_order,
                    'color_code' => $this->color_code ?: null,
                ];

                if ($this->editingId) {
                    DamageType::whereId($this->editingId)->update($data);
                    $message = 'Jenis kerosakan telah dikemaskini. / Damage type has been updated.';
                } else {
                    DamageType::create($data);
                    $message = 'Jenis kerosakan baru telah ditambah. / New damage type has been added.';
                }

                session()->flash('success', $message);
            });

            $this->resetForm();
            $this->showForm = false;
            $this->dispatch('damage-type-updated');

        } catch (\Exception $e) {
            logger('Error saving damage type: ' . $e->getMessage());
            $this->addError('save', 'Ralat semasa menyimpan: ' . $e->getMessage() . ' / Error saving: ' . $e->getMessage());
        }
    }

    public function delete(int $id): void
    {
        try {
            DB::transaction(function () use ($id): void {
                $damageType = DamageType::findOrFail($id);
                $damageType->delete();
            });

            session()->flash('success', 'Jenis kerosakan telah dipadam. / Damage type has been deleted.');
            $this->dispatch('damage-type-updated');

        } catch (\Exception $e) {
            logger('Error deleting damage type: ' . $e->getMessage());
            session()->flash('error', 'Ralat semasa memadam: ' . $e->getMessage() . ' / Error deleting: ' . $e->getMessage());
        }
    }

    public function toggleStatus(int $id): void
    {
        try {
            DB::transaction(function () use ($id): void {
                $damageType = DamageType::findOrFail($id);
                $damageType->update(['is_active' => !$damageType->is_active]);
            });

            $this->dispatch('damage-type-updated');

        } catch (\Exception $e) {
            logger('Error toggling damage type status: ' . $e->getMessage());
            session()->flash('error', 'Ralat semasa mengubah status. / Error changing status.');
        }
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    protected function resetForm(): void
    {
        $this->name = '';
        $this->name_bm = '';
        $this->description = '';
        $this->description_bm = '';
        $this->icon = '';
        $this->severity = 'medium';
        $this->is_active = true;
        $this->sort_order = 0;
        $this->color_code = '';
        $this->editingId = null;
        
        $this->resetValidation();
    }

    public function render()
    {
        $damageTypes = DamageType::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('name_bm', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('description_bm', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->severityFilter, function ($query) {
                $query->where('severity', $this->severityFilter);
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter === '1');
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('livewire.admin.dropdown-manager', [
            'damageTypes' => $damageTypes,
        ]);
    }
}
