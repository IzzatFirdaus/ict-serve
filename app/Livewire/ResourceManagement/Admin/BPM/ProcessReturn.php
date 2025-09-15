<?php

namespace App\Livewire\ResourceManagement\Admin\BPM;

use App\Models\EquipmentItem;
use App\Models\LoanRequest;
use App\Services\LoanApplicationService;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Proses Pemulangan Peralatan')]
class ProcessReturn extends Component
{
    use WithPagination;

    public string $search = '';

    public int $perPage = 10;

    // Return form properties
    public ?LoanRequest $selectedLoan = null;

    public array $returnedEquipment = [];

    public array $equipmentConditions = [];

    public array $equipmentNotes = [];

    public array $accessoriesChecklist = [];

    public string $returnNotes = '';

    public bool $processing = false;

    public function mount()
    {
        // Check if user has permission to process returns
        $this->authorize('return', EquipmentItem::class);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function selectLoan($loanId)
    {
        $this->selectedLoan = LoanRequest::with(['user', 'loanItems.equipmentItem.equipment'])->findOrFail($loanId);
        $this->returnedEquipment = [];
        $this->equipmentConditions = [];
        $this->equipmentNotes = [];
        $this->accessoriesChecklist = [];
        $this->returnNotes = '';

        // Initialize return form with issued equipment
        $issuedItems = $this->selectedLoan->loanItems()
            ->whereHas('equipmentItem', function ($query) {
                $query->where('status', 'on_loan');
            })
            ->get();

        /** @var \App\Models\LoanItem $item */
        foreach ($issuedItems as $item) {
            if ($item->equipmentItem) {
                $this->returnedEquipment[] = $item->equipmentItem->id;
                $this->equipmentConditions[$item->equipmentItem->id] = 'good';
                $this->equipmentNotes[$item->equipmentItem->id] = '';
            }
        }
    }

    public function processReturn()
    {
        $this->processing = true;

        try {
            if (! $this->selectedLoan) {
                throw new \Exception('Tiada permohonan dipilih.');
            }

            if (empty($this->returnedEquipment)) {
                throw new \Exception('Sila pilih sekurang-kurangnya satu peralatan untuk dipulangkan.');
            }

            $loanApplicationService = app(LoanApplicationService::class);

            $returnData = [
                'equipment_items' => collect($this->returnedEquipment)->map(function ($equipmentId) {
                    return [
                        'equipment_id' => $equipmentId,
                        'condition' => $this->equipmentConditions[$equipmentId] ?? 'good',
                        'notes' => $this->equipmentNotes[$equipmentId] ?? null,
                    ];
                })->toArray(),
                'accessories_checklist' => $this->accessoriesChecklist,
                'notes' => $this->returnNotes,
            ];

            $loanApplicationService->completeReturn($this->selectedLoan, $this->returnedEquipment, \Illuminate\Support\Facades\Auth::user(), $this->returnNotes);

            session()->flash('success', 'Peralatan telah berjaya dipulangkan untuk permohonan '.$this->selectedLoan->request_number);

            $this->reset(['selectedLoan', 'returnedEquipment', 'equipmentConditions', 'equipmentNotes', 'accessoriesChecklist', 'returnNotes']);

        } catch (\Exception $e) {
            session()->flash('error', 'Ralat semasa memproses pemulangan: '.$e->getMessage());
        } finally {
            $this->processing = false;
        }
    }

    public function cancelSelection()
    {
        $this->reset(['selectedLoan', 'returnedEquipment', 'equipmentConditions', 'equipmentNotes', 'accessoriesChecklist', 'returnNotes']);
    }

    public function render()
    {
        $issuedLoans = LoanRequest::with(['user', 'status', 'loanItems.equipmentItem.equipment'])
            ->whereHas('status', function ($query) {
                $query->where('code', 'issued');
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('request_number', 'like', '%'.$this->search.'%')
                        ->orWhere('purpose', 'like', '%'.$this->search.'%')
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->orderBy('requested_to', 'asc') // Sort by return date
            ->paginate($this->perPage);

        return view('livewire.resource-management.admin.bpm.process-return', [
            'issuedLoans' => $issuedLoans,
        ]);
    }
}
