<?php

namespace App\Http\Controllers;

use App\Models\EquipmentCategory;
use App\Models\HelpdeskTicket;
use App\Models\LoanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    /**
     * Show the equipment loan request form.
     */
    public function loanRequest()
    {
        $categories = EquipmentCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->with(['equipmentItems' => function ($query) {
                $query->where('is_active', true)
                    ->where('status', 'available')
                    ->orderBy('brand')
                    ->orderBy('model');
            }])
            ->get();

        return view('public.loan-request', compact('categories'));
    }

    /**
     * Store a new loan request.
     */
    public function storeLoanRequest(Request $request)
    {
        $validated = $request->validate([
            'purpose' => 'required|string|max:1000',
            'location' => 'required|string|max:255',
            'requested_from' => 'required|date|after_or_equal:today',
            'requested_to' => 'required|date|after:requested_from',
            'equipment_requests' => 'required|array|min:1',
            'equipment_requests.*.equipment_id' => 'required|exists:equipment_items,id',
            'equipment_requests.*.quantity' => 'required|integer|min:1',
            'equipment_requests.*.notes' => 'nullable|string|max:500',
            'responsible_officer_name' => 'required|string|max:255',
            'responsible_officer_position' => 'required|string|max:255',
            'responsible_officer_phone' => 'required|string|max:20',
            'same_as_applicant' => 'boolean',
        ]);

        DB::transaction(function () use ($validated) {
            $user = Auth::user();

            // Auto-fill applicant details from user
            $loanRequest = LoanRequest::create([
                'request_number' => LoanRequest::generateRequestNumber(),
                'user_id' => $user->id,
                'applicant_name' => $user->name,
                'applicant_position' => $user->position,
                'applicant_department' => $user->department,
                'applicant_phone' => $user->phone,
                'supervisor_id' => $user->supervisor_id,
                'purpose' => $validated['purpose'],
                'location' => $validated['location'],
                'requested_from' => $validated['requested_from'],
                'requested_to' => $validated['requested_to'],
                'responsible_officer_name' => $validated['responsible_officer_name'],
                'responsible_officer_position' => $validated['responsible_officer_position'],
                'responsible_officer_phone' => $validated['responsible_officer_phone'],
                'same_as_applicant' => $validated['same_as_applicant'] ?? false,
                'equipment_requests' => $validated['equipment_requests'],
                'status' => 'pending_bpm_review',
                'submitted_at' => now(),
            ]);

            // Send notification to supervisor if exists
            if ($user->supervisor_id) {
                // TODO: Create notification
            }
        });

        return redirect()->route('public.loan-request')
            ->with('success', 'Your loan request has been submitted successfully. You will be notified of the approval status.');
    }

    /**
     * Show the damage complaint form.
     */
    public function damageComplaint()
    {
        $categories = EquipmentCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->with(['equipmentItems' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('brand')
                    ->orderBy('model');
            }])
            ->get();

        return view('public.damage-complaint', compact('categories'));
    }

    /**
     * Store a new damage complaint.
     */
    public function storeDamageComplaint(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'equipment_item_id' => 'nullable|exists:equipment_items,id',
            'damage_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'priority' => 'required|in:low,medium,high,critical',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
        ]);

        DB::transaction(function () use ($validated, $request) {
            $user = Auth::user();

            // Handle file uploads
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('damage-complaints', 'public');
                    $attachments[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ];
                }
            }

            $ticket = HelpdeskTicket::create([
                'ticket_number' => HelpdeskTicket::generateTicketNumber(),
                'user_id' => $user->id,
                'category_id' => 1, // Default to first category, should be configurable
                'status_id' => 1, // Default status
                'title' => $validated['title'],
                'description' => $validated['description'],
                'equipment_item_id' => $validated['equipment_item_id'],
                'damage_type' => $validated['damage_type'],
                'location' => $validated['location'],
                'contact_phone' => $validated['contact_phone'],
                'priority' => $validated['priority'],
                'urgency' => 'medium', // Default urgency
                'status' => 'pending',
                'attachments' => $attachments,
            ]);

            // TODO: Send notification to ICT team
        });

        return redirect()->route('public.damage-complaint')
            ->with('success', 'Your damage complaint has been submitted successfully. Our team will contact you soon.');
    }

    /**
     * Show user's requests and tickets.
     */
    public function myRequests()
    {
        // Return the enhanced Livewire component view
        return view('public.my-requests-enhanced');
    }
}
