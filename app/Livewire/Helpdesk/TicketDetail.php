<?php
/**
 * @property-read array $statusProgress
 */

namespace App\Livewire\Helpdesk;

use App\Models\HelpdeskTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * @property array $statusProgress
 */
#[Layout('layouts.app')]
class TicketDetail extends Component
{
    public HelpdeskTicket $ticket;

    /**
     * @var array|null
     * @internal Only for static analysis. Real value is provided by computed property accessor.
     */
    protected $statusProgress = null;

    public $showFullDescription = false;

    public function mount($ticketNumber)
    {
        $this->ticket = HelpdeskTicket::with([
            'user',
            'category',
            'ticketStatus',
            'equipmentItem',
            'assignedTo',
            'resolvedBy',
        ])
            ->where('ticket_number', $ticketNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Page title will be set in the view template
    }

    public function toggleDescription()
    {
        $this->showFullDescription = ! $this->showFullDescription;
    }

    public function downloadAttachment($filename)
    {
        $path = "ticket-attachments/{$this->ticket->id}/{$filename}";

        if (Storage::exists($path)) {
            return response()->download(Storage::path($path));
        }

        session()->flash('error', 'File not found.');
    }

    public function getStatusProgressProperty()
    {
        $statusOrder = [
            'open' => 1,
            'assigned' => 2,
            'in_progress' => 3,
            'resolved' => 4,
            'closed' => 5,
        ];

        $currentStatus = strtolower($this->ticket->ticketStatus->name ?? 'open');
        $currentStep = $statusOrder[$currentStatus] ?? 1;

        return [
            'current' => $currentStep,
            'total' => 5,
            'percentage' => ($currentStep / 5) * 100,
        ];
    }

    public function render()
    {
        return view('livewire.helpdesk.ticket-detail', [
            'statusProgress' => $this->statusProgress,
        ]);
    }
}
