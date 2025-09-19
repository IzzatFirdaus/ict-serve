<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\EquipmentItem;
use App\Models\HelpdeskTicket;
use App\Models\TicketCategory;
use App\Models\TicketStatus;
use App\Models\User;
use App\Notifications\HelpdeskTicketSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class PublicHelpdeskController extends Controller
{
    public function create()
    {
        $categories = TicketCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $equipment = EquipmentItem::with('category')
            ->where('is_active', true)
            ->orderBy('category_id')
            ->orderBy('brand')
            ->orderBy('model')
            ->get()
            ->groupBy('category.name');

        /** @var view-string $view */
        $view = 'public.helpdesk.create';

        return view($view, compact('categories', 'equipment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reporter_name' => 'required|string|max:255',
            'reporter_email' => 'required|email|max:255',
            'reporter_phone' => 'nullable|string|max:20',
            'staff_id' => 'required|string|max:20',
            'department' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'category_id' => 'required|exists:ticket_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'location' => 'required|string|max:255',
            'equipment_item_id' => 'nullable|exists:equipment_items,id',
            'contact_phone' => 'nullable|string|max:20',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,txt', // 10MB max per file
            'data_consent' => 'accepted',
        ], [
            'reporter_name.required' => 'Nama pelapor diperlukan / Reporter name is required',
            'reporter_email.required' => 'E-mel pelapor diperlukan / Reporter email is required',
            'staff_id.required' => 'ID Staf diperlukan / Staff ID is required',
            'department.required' => 'Jabatan diperlukan / Department is required',
            'category_id.required' => 'Kategori masalah diperlukan / Issue category is required',
            'title.required' => 'Tajuk masalah diperlukan / Issue title is required',
            'description.required' => 'Huraian masalah diperlukan / Issue description is required',
            'priority.required' => 'Keutamaan diperlukan / Priority is required',
            'location.required' => 'Lokasi diperlukan / Location is required',
            'attachments.*.max' => 'Saiz fail tidak boleh melebihi 10MB / File size cannot exceed 10MB',
            'attachments.*.mimes' => 'Format fail tidak disokong / Unsupported file format',
            'data_consent.accepted' => 'Persetujuan data diperlukan / Data consent is required',
        ]);

        DB::beginTransaction();

        try {
            // Generate ticket number
            $ticketNumber = 'TKT-'.date('Ymd').'-'.Str::upper(Str::random(6));

            // Get or create user
            $user = User::firstOrCreate(
                ['email' => $request->reporter_email],
                [
                    'name' => $request->reporter_name,
                    'staff_id' => $request->staff_id,
                    'department' => $request->department,
                    'division' => $request->division,
                    'position' => $request->position,
                    'phone' => $request->reporter_phone,
                    'role' => 'user',
                    'password' => bcrypt(Str::random(32)), // Random password, user can reset if needed
                ]
            );

            // Get new status
            $newStatus = TicketStatus::where('code', 'new')->first()
                ?? TicketStatus::where('code', 'open')->first()
                ?? TicketStatus::first();

            // Handle file uploads
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $filename = time().'_'.Str::random(10).'.'.$file->getClientOriginalExtension();
                    $path = $file->storeAs('helpdesk-attachments', $filename, 'public');

                    $attachments[] = [
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getMimeType(),
                    ];
                }
            }

            // Create helpdesk ticket
            $ticket = HelpdeskTicket::create([
                'ticket_number' => $ticketNumber,
                'user_id' => $user->id,
                'category_id' => $request->category_id,
                'status_id' => $newStatus->id,
                'title' => $request->title,
                'description' => $request->description,
                'priority' => $request->priority,
                'urgency' => $this->calculateUrgency($request->priority, $request->category_id),
                'location' => $request->location,
                'equipment_item_id' => $request->equipment_item_id,
                'contact_phone' => $request->contact_phone ?? $request->reporter_phone,
                'attachments' => $attachments,
                'due_at' => $this->calculateDueDate($request->priority, $request->category_id),
            ]);

            // Send notifications
            $this->sendNotifications($ticket, $request);

            DB::commit();

            return redirect()->route('public.helpdesk.success')
                ->with('ticket_number', $ticketNumber)
                ->with('success', __('Issue reported successfully! Your ticket number is: :ticket', ['ticket' => $ticketNumber]));

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Public helpdesk ticket failed', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return back()->withInput()
                ->with('error', __('An error occurred while submitting your report. Please try again.'));
        }
    }

    public function success()
    {
        if (! session('ticket_number')) {
            return redirect()->route('public.helpdesk.create');
        }

        return view('public.helpdesk.success');
    }

    public function trackTicket(Request $request)
    {
        $request->validate([
            'ticket_number' => 'required|string',
        ]);

        $ticket = HelpdeskTicket::with(['status', 'category', 'equipmentItem', 'user'])
            ->where('ticket_number', $request->ticket_number)
            ->first();

        if (! $ticket) {
            return back()->with('error', __('Ticket number not found. Please check and try again.'));
        }

        /** @var view-string $view */
        $view = 'public.track-result';

        return view($view, compact('ticket'));
    }

    private function calculateUrgency(string $priority, int $categoryId): string
    {
        $category = TicketCategory::find($categoryId);

        // Combine priority and category importance to determine urgency
        $urgencyMatrix = [
            'urgent' => 'urgent',
            'high' => $category?->priority === 'high' ? 'urgent' : 'high',
            'medium' => 'medium',
            'low' => 'low',
        ];

        return $urgencyMatrix[$priority] ?? 'medium';
    }

    private function calculateDueDate(string $priority, int $categoryId): \Carbon\Carbon
    {
        $category = TicketCategory::find($categoryId);
        $slaHours = ($category ? $category->default_sla_hours : null) ?? 24;

        // Adjust SLA based on priority
        $priorityMultiplier = match ($priority) {
            'urgent' => 0.25, // 6 hours for urgent
            'high' => 0.5,    // 12 hours for high
            'medium' => 1.0,   // Standard SLA
            'low' => 2.0,     // Double the SLA
            default => 1.0
        };

        $adjustedHours = $slaHours * $priorityMultiplier;

        return now()->addHours((int) $adjustedHours);
    }

    private function sendNotifications(HelpdeskTicket $ticket, Request $request): void
    {
        try {
            // Send email to reporter (confirmation)
            Mail::send('emails.helpdesk.ticket-confirmation', [
                'ticket' => $ticket,
                'reporterName' => $request->reporter_name,
            ], function ($message) use ($request, $ticket) {
                $message->to($request->reporter_email)
                    ->subject(__('Ticket Confirmation - :ticket', ['ticket' => $ticket->ticket_number]));
            });

            // Notify ICT admins and support staff
            $supportStaff = User::query()
                ->whereIn('role', ['ict_admin', 'super_admin'])
                ->get();
            if ($supportStaff->count() > 0) {
                Notification::send($supportStaff, new HelpdeskTicketSubmitted($ticket));
            }

        } catch (\Exception $e) {
            logger()->error('Failed to send helpdesk ticket notifications', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
