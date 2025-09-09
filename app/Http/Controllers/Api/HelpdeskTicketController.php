<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHelpdeskTicketRequest;
use App\Models\HelpdeskTicket;
use App\Models\TicketStatus;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HelpdeskTicketController extends Controller
{
    public function __construct(
        private NotificationService $notificationService
    ) {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of tickets.
     */
    public function index(Request $request): JsonResponse
    {
        $query = HelpdeskTicket::with(['user', 'category', 'status', 'assignedToUser'])
            ->when(! in_array($request->user()->role, ['ict_admin', 'super_admin'], true), function ($q) use ($request) {
                return $q->where('user_id', $request->user()->id);
            })
            ->when($request->status, function ($q, $status) {
                return $q->whereHas('status', fn ($sq) => $sq->where('name', $status));
            })
            ->when($request->priority, function ($q, $priority) {
                return $q->where('priority', $priority);
            })
            ->when($request->category, function ($q, $category) {
                return $q->where('category_id', $category);
            })
            ->orderBy('created_at', 'desc');

        $tickets = $query->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $tickets,
        ]);
    }

    /**
     * Store a newly created ticket.
     */
    public function store(StoreHelpdeskTicketRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Create ticket
            $ticket = HelpdeskTicket::create([
                'user_id' => $request->user()->id,
                'category_id' => $request->validated()['category_id'],
                'title' => $request->validated()['title'],
                'description' => $request->validated()['description'],
                'priority' => $request->validated()['priority'],
                'location' => $request->validated()['location'] ?? null,
                'equipment_item_id' => $request->validated()['equipment_item_id'] ?? null,
                'status_id' => TicketStatus::where('name', 'new')->first()->id,
            ]);

            // Handle file attachments
            if ($request->hasFile('attachments')) {
                $attachments = [];
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('helpdesk-attachments', 'public');
                    $attachments[] = [
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                    ];
                }
                $ticket->update(['attachments' => $attachments]);
            }

            // Send notification to admins
            $this->notificationService->notifyTicketEvent($ticket, 'ticket_created');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tiket telah berjaya dicipta.',
                'data' => $ticket->load(['category', 'status', 'user']),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Ralat berlaku semasa menyimpan tiket.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified ticket.
     */
    public function show(Request $request, HelpdeskTicket $ticket): JsonResponse
    {
        // Check authorization
        if (! in_array($request->user()->role, ['ict_admin', 'super_admin'], true) && $ticket->user->id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dibenarkan.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $ticket->load([
                'user',
                'category',
                'status',
                'assignedToUser',
                'equipmentItem.category',
            ]),
        ]);
    }

    /**
     * Update the specified ticket.
     */
    public function update(Request $request, HelpdeskTicket $ticket): JsonResponse
    {
        // Only admins or assigned users can update tickets
        if (! in_array($request->user()->role, ['ict_admin', 'super_admin'], true) && $ticket->assignedToUser?->id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dibenarkan.',
            ], 403);
        }

        $request->validate([
            'status' => 'sometimes|in:in_progress,resolved,closed',
            'priority' => 'sometimes|in:low,medium,high,urgent',
            'assigned_to' => 'sometimes|nullable|integer|exists:users,id',
            'admin_remarks' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $oldStatus = $ticket->status->name;
            $oldAssigned = $ticket->assignedToUser?->id;

            // Update ticket
            $updateData = [];
            if ($request->has('status')) {
                $status = TicketStatus::where('name', $request->status)->first();
                $updateData['status_id'] = $status->id;
            }
            if ($request->has('priority')) {
                $updateData['priority'] = $request->priority;
            }
            if ($request->has('assigned_to')) {
                $updateData['assigned_to'] = $request->assigned_to;
            }
            if ($request->has('admin_remarks')) {
                $updateData['admin_remarks'] = $request->admin_remarks;
            }

            $ticket->update($updateData);

            // Send notifications for status changes
            if (isset($updateData['status_id']) && $request->status !== $oldStatus) {
                $this->notificationService->notifyTicketEvent(
                    $ticket->fresh(),
                    'ticket_status_updated',
                    "Status tiket telah berubah kepada: {$request->status}"
                );
            }

            // Send notifications for assignment changes
            if (isset($updateData['assigned_to']) && $request->assigned_to !== $oldAssigned) {
                $this->notificationService->notifyTicketEvent(
                    $ticket->fresh(),
                    'ticket_assigned',
                    'Tiket telah ditugaskan'
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tiket telah dikemas kini.',
                'data' => $ticket->fresh(['user', 'category', 'status', 'assignedToUser']),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Ralat berlaku semasa mengemaskini tiket.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified ticket.
     */
    public function destroy(Request $request, HelpdeskTicket $ticket): JsonResponse
    {
        // Check authorization - only ticket creator or admin can delete
        if ($ticket->user_id !== $request->user()->id && $request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dibenarkan untuk memadam tiket ini.',
            ], 403);
        }

        // Only allow deletion of new tickets
        if ($ticket->status->name !== 'new') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya tiket baharu yang boleh dipadam.',
            ], 422);
        }

        try {
            // Delete attachments from storage
            if ($ticket->attachments) {
                foreach ($ticket->attachments as $attachment) {
                    Storage::disk('public')->delete($attachment['path']);
                }
            }

            $ticket->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tiket telah berjaya dipadam.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ralat berlaku semasa memadam tiket.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
