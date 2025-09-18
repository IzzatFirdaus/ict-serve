<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanRequestRequest;
use App\Models\LoanRequest;
use App\Models\LoanStatus;
use App\Services\NotificationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanRequestController extends Controller
{
    public function __construct(
        private NotificationService $notificationService
    ) {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of loan requests.
    *
    * @param \Illuminate\Http\Request $request
     */
    public function index(Request $request): JsonResponse
    {
    /** @var \Illuminate\Http\Request $request */
    $query = LoanRequest::with(['user', 'loanItems.equipmentItem', 'status'])
            ->when(! in_array(Auth::user()->role, ['ict_admin', 'super_admin'], true), function ($q) {
                return $q->where('user_id', Auth::id());
            })
            ->when($request->status, function ($q, $status) {
                return $q->whereHas('status', fn ($sq) => $sq->where('name', $status));
            })
            ->when($request->search, function ($q, $search) {
                $q->where(function ($sq) use ($search) {
                    $sq->where('purpose', 'like', "%$search%")
                        ->orWhere('remarks', 'like', "%$search%")
                        ->orWhereHas('user', fn ($uq) => $uq->where('name', 'like', "%$search%"));
                });
            })
            ->orderBy('created_at', 'desc');

        $loanRequests = $query->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $loanRequests,
        ]);
    }

    /**
     * Store a newly created loan request.
     */
    public function store(StoreLoanRequestRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Create loan request
            $loanRequest = LoanRequest::create([
                'user_id' => Auth::id(),
                'purpose' => $request->validated()['purpose'],
                'start_date' => $request->validated()['start_date'],
                'end_date' => $request->validated()['end_date'],
                'remarks' => $request->validated()['remarks'] ?? null,
                'status_id' => LoanStatus::where('name', 'pending')->first()->id,
            ]);

            // Add equipment items to loan request
            foreach ($request->validated()['equipment_items'] as $equipmentItemId) {
                $loanRequest->loanItems()->create([
                    'equipment_item_id' => $equipmentItemId,
                    'quantity' => 1, // Default quantity
                ]);
            }

            // Send notification to admins
            $this->notificationService->notifyNewLoanRequest($loanRequest);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permohonan peminjaman telah berjaya dihantar.',
                'data' => $loanRequest->load(['loanItems.equipmentItem', 'status']),
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Ralat berlaku semasa menyimpan permohonan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified loan request.
     */
    public function show(Request $request, LoanRequest $loanRequest): JsonResponse
    {
        // Check authorization
        if (! in_array($request->user()->role, ['ict_admin', 'super_admin'], true) && $loanRequest->user->id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dibenarkan.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $loanRequest->load([
                'user',
                'loanItems.equipmentItem.category',
                'status',
            ]),
        ]);
    }

    /**
     * Update the specified loan request status.
     */
    public function update(Request $request, LoanRequest $loanRequest): JsonResponse
    {
        // Only admins can update loan request status
        if (! in_array($request->user()->role, ['ict_admin', 'super_admin'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dibenarkan.',
            ], 403);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_remarks' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $status = LoanStatus::where('name', $request->status)->first();

            $loanRequest->update([
                'status_id' => $status->id,
                'admin_remarks' => $request->admin_remarks,
                'approved_by' => $request->status === 'approved' ? $request->user()->id : null,
                'approved_at' => $request->status === 'approved' ? now() : null,
            ]);

            // If approved, mark equipment as unavailable
            if ($request->status === 'approved') {
                foreach ($loanRequest->loanItems as $loanItem) {
                    $loanItem->equipmentItem->update(['is_available' => false]);
                }
            }

            // Send notification to user
            $this->notificationService->notifyLoanStatusUpdate($loanRequest);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status permohonan telah dikemas kini.',
                'data' => $loanRequest->fresh(['user', 'loanItems.equipmentItem', 'status']),
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Ralat berlaku semasa mengemaskini status.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified loan request.
     */
    public function destroy(Request $request, LoanRequest $loanRequest): JsonResponse
    {
        // Check authorization - user can only delete their own pending requests
        if ($loanRequest->user->id !== $request->user()->id || $loanRequest->status->name !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dibenarkan untuk memadam permohonan ini.',
            ], 403);
        }

        try {
            $loanRequest->delete();

            return response()->json([
                'success' => true,
                'message' => 'Permohonan telah berjaya dipadam.',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ralat berlaku semasa memadam permohonan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Bulk approve loan requests.
     */
    public function bulkApprove(Request $request): JsonResponse
    {
        $ids = $request->input('ids', []);
        $updated = LoanRequest::whereIn('id', $ids)
            ->whereHas('status', fn($q) => $q->where('name', 'pending'))
            ->update(['status_id' => LoanStatus::where('name', 'approved')->first()->id]);
        return response()->json(['success' => true, 'updated' => $updated]);
    }

    /**
     * Bulk reject loan requests.
     */
    public function bulkReject(Request $request): JsonResponse
    {
        $ids = $request->input('ids', []);
        $updated = LoanRequest::whereIn('id', $ids)
            ->whereHas('status', fn($q) => $q->where('name', 'pending'))
            ->update(['status_id' => LoanStatus::where('name', 'rejected')->first()->id]);
        return response()->json(['success' => true, 'updated' => $updated]);
    }
}
