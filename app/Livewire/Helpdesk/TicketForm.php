<?php

namespace App\Livewire\Helpdesk;

use App\Enums\TicketPriority;
use App\Enums\TicketUrgency;
use App\Models\EquipmentItem;
use App\Models\HelpdeskTicket;
use App\Models\TicketCategory;
use App\Models\TicketStatus;
use App\Notifications\TicketCreatedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class TicketForm extends Component
{
    use WithFileUploads;

    // Basic Information
    #[Rule('required|string|max:255')]
    public $title = '';

    #[Rule('required|string')]
    public $description = '';

    #[Rule('required|exists:ticket_categories,id')]
    public $category_id = '';

    #[Rule('required')]
    public $priority = TicketPriority::MEDIUM->value;

    #[Rule('required')]
    public $urgency = TicketUrgency::MEDIUM->value;

    // Contact Information
    #[Rule('required|string|max:20')]
    public $contact_phone = '';

    #[Rule('required|string|max:255')]
    public $location = '';

    // Equipment Related (optional)
    #[Rule('nullable|exists:equipment_items,id')]
    public $equipment_item_id = null;

    // File Attachments
    #[Rule('nullable|array|max:5')]
    #[Rule('attachments.*|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx')]
    public $attachments = [];

    // UI State
    public $showEquipmentSelection = false;

    public $selectedCategory = null;

    protected $listeners = ['categoryChanged' => 'updateCategory'];

    public function mount()
    {
        // Pre-fill user information if authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $this->contact_phone = $user->phone ?? '';
            $this->location = $user->division ?? '';
        }
    }

    public function getCategories()
    {
        return TicketCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function getEquipmentItems()
    {
        return EquipmentItem::where('is_active', true)
            ->where('status', 'available')
            ->with('category')
            ->orderBy('asset_tag')
            ->get();
    }

    public function getPriorityOptions()
    {
        return collect(TicketPriority::cases())->map(function ($priority) {
            return [
                'value' => $priority->value,
                'label' => $priority->label(),
                'description' => $priority->description(),
            ];
        });
    }

    public function getUrgencyOptions()
    {
        return collect(TicketUrgency::cases())->map(function ($urgency) {
            return [
                'value' => $urgency->value,
                'label' => $urgency->label(),
                'description' => $urgency->description(),
            ];
        });
    }

    public function updatedCategoryId()
    {
        $this->selectedCategory = TicketCategory::find($this->category_id);

        // Check if this category typically requires equipment selection
        $equipmentCategories = ['hardware-issue', 'equipment-damage', 'printer-issue'];
        $this->showEquipmentSelection = $this->selectedCategory &&
            in_array($this->selectedCategory->name, $equipmentCategories);

        if (! $this->showEquipmentSelection) {
            $this->equipment_item_id = null;
        }
    }

    public function removeAttachment($index)
    {
        if (isset($this->attachments[$index])) {
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments);
        }
    }

    public function submit()
    {
        $this->validate();

        // Check if user is authenticated, if not require guest information
        if (! Auth::check()) {
            $this->validate([
                'contact_phone' => 'required|string|max:20',
                'location' => 'required|string|max:255',
            ]);
        }

        try {
            // Get initial status
            $initialStatus = TicketStatus::where('code', 'open')->first();

            // Create ticket
            $ticket = HelpdeskTicket::create([
                'ticket_number' => HelpdeskTicket::generateTicketNumber(),
                'user_id' => Auth::id(),
                'category_id' => $this->category_id,
                'status_id' => $initialStatus->id,
                'title' => $this->title,
                'description' => $this->description,
                'priority' => TicketPriority::from($this->priority),
                'urgency' => TicketUrgency::from($this->urgency),
                'equipment_item_id' => $this->equipment_item_id,
                'location' => $this->location,
                'contact_phone' => $this->contact_phone,
                'due_at' => $this->calculateDueDate(),
            ]);

            // Handle file attachments
            if (! empty($this->attachments)) {
                $attachmentPaths = [];
                foreach ($this->attachments as $attachment) {
                    if ($attachment instanceof TemporaryUploadedFile) {
                        $path = $attachment->store('ticket-attachments/'.$ticket->id, 'public');
                        $attachmentPaths[] = [
                            'name' => $attachment->getClientOriginalName(),
                            'path' => $path,
                            'size' => $attachment->getSize(),
                            'type' => $attachment->getMimeType(),
                        ];
                    }
                }
                $ticket->update(['attachments' => $attachmentPaths]);
            }

            // Send notification to helpdesk team
            $this->notifyHelpdeskTeam($ticket);

            // Send notification to user
            Auth::user()->notify(new TicketCreatedNotification($ticket));

            session()->flash('success', 'Your helpdesk ticket has been successfully created. Ticket number: '.$ticket->ticket_number);

            // Redirect to ticket view or dashboard
            if (Auth::check()) {
                return redirect()->route('dashboard');
            } else {
                // For guest users, show the ticket details
                return redirect()->route('dashboard');
            }

        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while creating the ticket. Please try again.');
            Log::error('Ticket creation error: '.$e->getMessage());
        }
    }

    private function calculateDueDate()
    {
        $category = TicketCategory::find($this->category_id);
        $priority = TicketPriority::from($this->priority);

        // Calculate SLA based on category and priority
        $slaHours = $category->default_sla_hours ?? 24;

        // Adjust based on priority
        $multiplier = match ($priority) {
            TicketPriority::CRITICAL => 0.25, // 25% of normal SLA
            TicketPriority::HIGH => 0.5,     // 50% of normal SLA
            TicketPriority::MEDIUM => 1.0,   // Normal SLA
            TicketPriority::LOW => 2.0,      // 200% of normal SLA
        };

        return now()->addHours($slaHours * $multiplier);
    }

    private function notifyHelpdeskTeam($ticket)
    {
        // TODO: Implement notification system
        // This will be implemented in the notification todo item
    }

    public function getSlaHours()
    {
        if (! $this->category_id) {
            return 24; // Default SLA
        }

        $category = TicketCategory::find($this->category_id);
        if (! $category) {
            return 24;
        }

        $priority = TicketPriority::from($this->priority);
        $slaHours = $category->default_sla_hours ?? 24;

        // Adjust based on priority
        $multiplier = match ($priority) {
            TicketPriority::CRITICAL => 0.25, // 25% of normal SLA
            TicketPriority::HIGH => 0.5,     // 50% of normal SLA
            TicketPriority::MEDIUM => 1.0,   // Normal SLA
            TicketPriority::LOW => 2.0,      // 200% of normal SLA
        };

        return $slaHours * $multiplier;
    }

    public function resetForm()
    {
        $this->reset([
            'title', 'description', 'category_id', 'priority', 'urgency',
            'contact_phone', 'location', 'equipment_item_id', 'attachments',
        ]);
        $this->resetValidation();
        $this->showEquipmentSelection = false;
        $this->selectedCategory = null;
    }

    public function render()
    {
        return view('livewire.helpdesk.ticket-form', [
            'categories' => $this->getCategories(),
            'equipmentItems' => $this->getEquipmentItems(),
            'priorityOptions' => $this->getPriorityOptions(),
            'urgencyOptions' => $this->getUrgencyOptions(),
        ]);
    }
}
