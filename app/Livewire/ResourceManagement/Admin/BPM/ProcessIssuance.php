<?php

namespace App\Livewire\ResourceManagement\Admin\BPM;

use App\Models\EquipmentItem;
use App\Models\LoanRequest;
use App\Services\LoanApplicationService;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Proses Pengeluaran Peralatan')]
class ProcessIssuance extends Component
{
    use WithPagination;

    public string $search = '';

    public int $perPage = 10;

    // Issue form properties
    public ?LoanRequest $selectedLoan = null;

    public array $selectedEquipment = [];

    public array $accessoriesChecklist = [];

    public string $issueNotes = '';

    public bool $processing = false;

    public function mount()
    {
        // Check if user has permission to issue equipment
        $this->authorize('issue', EquipmentItem::class);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function selectLoan($loanId)
    {
        $this->selectedLoan = LoanRequest::with(['user', 'loanItems.equipmentItem.equipment'])->findOrFail($loanId);
        $this->selectedEquipment = [];
        $this->accessoriesChecklist = [];
        $this->issueNotes = '';

        // Initialize equipment selection based on loan items
        foreach ($this->selectedLoan->loanItems as $item) {
            if ($item->equipmentItem && $item->equipmentItem->status === \App\Enums\EquipmentStatus::AVAILABLE) {
                $this->selectedEquipment[] = $item->equipmentItem->id;
            }
        }
    }

    public function processIssuance()
    {
        $this->processing = true;

        try {
            if (! $this->selectedLoan) {
                throw new \Exception('Tiada permohonan dipilih.');
            }

            if (empty($this->selectedEquipment)) {
                throw new \Exception('Sila pilih sekurang-kurangnya satu peralatan untuk dikeluarkan.');
            }

            $loanApplicationService = app(LoanApplicationService::class);

            $equipmentData = [
                'equipment_items' => collect($this->selectedEquipment)->map(function ($equipmentId) {
                    return [
                        'equipment_id' => $equipmentId,
                        'condition' => 'good',
                        'notes' => null,
                    ];
                })->toArray(),
                'accessories_checklist' => $this->accessoriesChecklist,
                'notes' => $this->issueNotes,
            ];

            $loanApplicationService->issue($this->selectedLoan, $this->selectedEquipment, \Illuminate\Support\Facades\Auth::user());

            session()->flash('success', 'Peralatan telah berjaya dikeluarkan untuk permohonan '.$this->selectedLoan->request_number);

            $this->reset(['selectedLoan', 'selectedEquipment', 'accessoriesChecklist', 'issueNotes']);

        } catch (\Exception $e) {
            session()->flash('error', 'Ralat semasa mengeluarkan peralatan: '.$e->getMessage());
        } finally {
            $this->processing = false;
        }
    }

    public function cancelSelection()
    {
        $this->reset(['selectedLoan', 'selectedEquipment', 'accessoriesChecklist', 'issueNotes']);
    }

    public function render()
    {
        $approvedLoans = LoanRequest::with(['user', 'status', 'loanItems.equipmentItem.equipment'])
            ->whereHas('status', function ($query) {
                $query->where('code', 'approved');
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
            ->orderBy('created_at', 'asc')
            ->paginate($this->perPage);

        return view('livewire.resource-management.admin.bpm.process-issuance', [
            'approvedLoans' => $approvedLoans,
        ]);
    }
}
