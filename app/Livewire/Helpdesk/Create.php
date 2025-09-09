<?php

declare(strict_types=1);

namespace App\Livewire\Helpdesk;

use App\Models\EquipmentItem;
use App\Models\HelpdeskTicket;
use App\Models\TicketCategory;
use App\Models\TicketStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.iserve')]
class Create extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string|max:2000')]
    public string $description = '';

    #[Validate('required|integer|exists:ticket_categories,id')]
    public int $category_id = 0;

    #[Validate('required|in:low,medium,high,critical')]
    public string $priority = 'medium';

    #[Validate('nullable|integer|exists:equipment_items,id')]
    public ?int $equipment_item_id = null;

    #[Validate('nullable|string|max:255')]
    public string $location = '';

    #[Validate('nullable|string|max:20')]
    public string $contact_phone = '';

    #[Validate('nullable|array|max:5')]
    public array $attachments = [];

    public array $ticketCategories = [];

    public array $equipmentItems = [];

    public bool $showEquipmentSelector = false;

    public function mount(): void
    {
        $this->loadTicketCategories();
        $this->loadEquipmentItems();
        $this->contact_phone = Auth::user()->phone ?? '';
        $this->location = Auth::user()->division ?? '';
    }

    public function loadTicketCategories(): void
    {
        try {
            $this->ticketCategories = TicketCategory::active()
                ->ordered()
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            $this->ticketCategories = [];
        }
    }

    public function loadEquipmentItems(): void
    {
        try {
            $this->equipmentItems = EquipmentItem::with('category')
                ->where('is_active', true)
                ->orderBy('brand')
                ->orderBy('model')
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            $this->equipmentItems = [];
        }
    }

    public function updatedCategoryId(): void
    {
        // Show equipment selector for equipment-related categories
        $category = TicketCategory::find($this->category_id);
        $this->showEquipmentSelector = $category && in_array($category->name, [
            'Hardware Issues',
            'Equipment Damage',
            'Printer Issues',
        ]);

        if (! $this->showEquipmentSelector) {
            $this->equipment_item_id = null;
        }
    }

    public function submit()
    {
        try {
            $this->validate();
        } catch (\Exception $e) {
            // Log validation errors for debugging
            logger('Validation error in helpdesk create: '.$e->getMessage());
            $this->addError('submit', 'Validation error: '.$e->getMessage());

            return;
        }

        try {
            DB::transaction(function () {
                // Get initial status (new)
                $newStatus = TicketStatus::where('code', 'new')->first();

                if (! $newStatus) {
                    throw new \Exception('Initial ticket status not found');
                }

                // Create the helpdesk ticket
                $ticket = HelpdeskTicket::create([
                    'user_id' => Auth::id(),
                    'category_id' => $this->category_id,
                    'status_id' => $newStatus->id,
                    'title' => $this->title,
                    'description' => $this->description,
                    'priority' => $this->priority,
                    'equipment_item_id' => $this->equipment_item_id,
                    'location' => $this->location,
                    'contact_phone' => $this->contact_phone,
                    'attachments' => $this->attachments,
                ]);

                session()->flash('success',
                    'Tiket bantuan telah berjaya diwujudkan. / Helpdesk ticket has been successfully created. '.
                    'Nombor tiket / Ticket number: '.$ticket->ticket_number
                );
            });

            return redirect()->route('helpdesk.index');
        } catch (\Exception $e) {
            logger('Helpdesk ticket creation error: '.$e->getMessage());
            $this->addError('submit', 'Ralat semasa mewujudkan tiket: '.$e->getMessage().' / Error creating ticket: '.$e->getMessage());

            return null;
        }
    }

    public function render()
    {
        return view('livewire.helpdesk.create');
    }
}
