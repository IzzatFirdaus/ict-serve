<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\EquipmentItem;
use App\Models\LoanRequest;
use App\Models\LoanStatus;
use App\Models\User;
use App\Notifications\LoanRequestSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class PublicLoanController extends Controller
{
    public function create()
    {
        $availableEquipment = EquipmentItem::with('category')
            ->where('status', 'available')
            ->where('is_active', true)
            ->orderBy('category_id')
            ->orderBy('brand')
            ->orderBy('model')
            ->get()
            ->groupBy('category.name');

        return view('public.loan.create', compact('availableEquipment')); // @phpstan-ignore-line
    }

    public function store(Request $request)
    {
        $request->validate([
            'requester_name' => 'required|string|max:255',
            'requester_email' => 'required|email|max:255',
            'requester_phone' => 'nullable|string|max:20',
            'staff_id' => 'required|string|max:20',
            'department' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'supervisor_name' => 'required|string|max:255',
            'supervisor_email' => 'required|email|max:255',
            'equipment_items' => 'required|array|min:1',
            'equipment_items.*' => 'exists:equipment_items,id',
            'purpose' => 'required|string',
            'requested_from' => 'required|date|after_or_equal:today',
            'requested_to' => 'required|date|after:requested_from',
            'terms_accepted' => 'accepted',
            'data_consent' => 'accepted',
        ], [
            'requester_name.required' => 'Nama pemohon diperlukan / Requester name is required',
            'requester_email.required' => 'E-mel pemohon diperlukan / Requester email is required',
            'staff_id.required' => 'ID Staf diperlukan / Staff ID is required',
            'department.required' => 'Jabatan diperlukan / Department is required',
            'supervisor_email.required' => 'E-mel penyelia diperlukan / Supervisor email is required',
            'equipment_items.required' => 'Sila pilih sekurang-kurangnya satu peralatan / Please select at least one equipment',
            'purpose.required' => 'Tujuan pinjaman diperlukan / Purpose of loan is required',
            'requested_from.required' => 'Tarikh mula diperlukan / Start date is required',
            'requested_to.required' => 'Tarikh tamat diperlukan / End date is required',
            'terms_accepted.accepted' => 'Sila terima terma dan syarat / Please accept terms and conditions',
            'data_consent.accepted' => 'Persetujuan data diperlukan / Data consent is required',
        ]);

        DB::beginTransaction();

        try {
            // Generate reference number
            $referenceNumber = 'LOAN-'.date('Ymd').'-'.Str::upper(Str::random(6));

            // Get or create user
            $user = User::firstOrCreate(
                ['email' => $request->requester_email],
                [
                    'name' => $request->requester_name,
                    'staff_id' => $request->staff_id,
                    'department' => $request->department,
                    'division' => $request->division,
                    'position' => $request->position,
                    'phone' => $request->requester_phone,
                    'role' => 'user',
                    'password' => bcrypt(Str::random(32)), // Random password, user can reset if needed
                ]
            );

            // Get pending status
            $pendingStatus = LoanStatus::where('code', 'pending_supervisor')->first()
                ?? LoanStatus::where('code', 'pending')->first()
                ?? LoanStatus::first();

            // Create loan request
            $loanRequest = LoanRequest::create([
                'request_number' => $referenceNumber,
                'user_id' => $user->id,
                'status_id' => $pendingStatus->id,
                'purpose' => $request->purpose,
                'requested_from' => $request->requested_from,
                'requested_to' => $request->requested_to,
                'supervisor_email' => $request->supervisor_email,
                'supervisor_name' => $request->supervisor_name,
                'notes' => 'Public loan request submitted',
            ]);

            // Add equipment items
            foreach ($request->equipment_items as $equipmentId) {
                $loanRequest->loanItems()->create([
                    'equipment_item_id' => $equipmentId,
                    'quantity' => 1, // Default quantity
                    'condition_out' => 'good', // Default condition
                ]);
            }

            // Generate approval token for supervisor
            $approvalToken = Str::random(64);
            $loanRequest->update(['approval_token' => $approvalToken]);

            // Send notifications
            $this->sendNotifications($loanRequest, $request);

            DB::commit();

            return redirect()->route('public.loan.success')
                ->with('reference_number', $referenceNumber)
                ->with('success', __('Loan request submitted successfully! Your reference number is: :ref', ['ref' => $referenceNumber]));

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Public loan request failed', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return back()->withInput()
                ->with('error', __('An error occurred while submitting your request. Please try again.'));
        }
    }

    public function success()
    {
        if (! session('reference_number')) {
            return redirect()->route('public.loan.create');
        }

        return view('public.loan.success'); // @phpstan-ignore-line
    }

    public function track()
    {
        return view('public.track');
    }

    public function trackStatus(Request $request)
    {
        $request->validate([
            'reference_number' => 'required|string',
        ]);

        $loanRequest = LoanRequest::with(['status', 'loanItems.equipmentItem', 'user'])
            ->where('request_number', $request->reference_number)
            ->first();

        if (! $loanRequest) {
            return back()->with('error', __('Reference number not found. Please check and try again.'));
        }

        return view('public.track-result', compact('loanRequest'));
    }

    private function sendNotifications(LoanRequest $loanRequest, Request $request): void
    {
        try {
            // Send email to requester (confirmation)
            Mail::send('emails.loan.request-confirmation', [
                'loanRequest' => $loanRequest,
                'requesterName' => $request->requester_name,
            ], function ($message) use ($request, $loanRequest) {
                $message->to($request->requester_email)
                    ->subject(__('Loan Request Confirmation - :ref', ['ref' => $loanRequest->request_number]));
            });

            // Send email to supervisor (approval request)
            $approvalUrl = route('public.approve', [
                'token' => $loanRequest->approval_token,
                'action' => 'approve',
            ]);

            $rejectUrl = route('public.approve', [
                'token' => $loanRequest->approval_token,
                'action' => 'reject',
            ]);

            Mail::send('emails.loan.supervisor-approval', [
                'loanRequest' => $loanRequest,
                'requesterName' => $request->requester_name,
                'supervisorName' => $request->supervisor_name,
                'approvalUrl' => $approvalUrl,
                'rejectUrl' => $rejectUrl,
            ], function ($message) use ($request, $loanRequest) {
                $message->to($request->supervisor_email)
                    ->subject(__('Approval Required - Loan Request :ref', ['ref' => $loanRequest->request_number]));
            });

            // Notify ICT admins
            $ictAdmins = User::whereIn('role', ['admin', 'superuser_admin'])->get();
            if ($ictAdmins->count() > 0) {
                Notification::send($ictAdmins, new LoanRequestSubmitted($loanRequest));
            }

        } catch (\Exception $e) {
            logger()->error('Failed to send loan request notifications', [
                'loan_request_id' => $loanRequest->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
