<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EquipmentItem;
use App\Models\HelpdeskTicket;
use App\Models\LoanRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Get unified dashboard data for ICT Serve system.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        // Base statistics
        $stats = [
            'user_stats' => $this->getUserStats($user),
            'loan_stats' => $this->getLoanStats($user),
            'helpdesk_stats' => $this->getHelpdeskStats($user),
        ];

        // Admin gets system-wide stats
        if (in_array($user->role, ['ict_admin', 'super_admin'], true)) {
            $stats['admin_stats'] = $this->getAdminStats();
        }

        // Recent activities
        $recentActivities = $this->getRecentActivities($user);

        return response()->json([
            'success' => true,
            'data' => [
                'statistics' => $stats,
                'recent_activities' => $recentActivities,
                'quick_actions' => $this->getQuickActions($user),
            ],
        ]);
    }

    private function getUserStats($user): array
    {
        return [
            'name' => $user->name,
            'role' => $user->role,
            'division' => $user->division,
            'total_loan_requests' => $user->loanRequests()->count(),
            'total_tickets' => $user->helpdeskTickets()->count(),
        ];
    }

    private function getLoanStats($user): array
    {
        $query = in_array($user->role, ['ict_admin', 'super_admin'], true)
            ? LoanRequest::query()
            : $user->loanRequests();

        return [
            'total_requests' => $query->count(),
            'pending_requests' => $query->whereHas('status', fn ($q) => $q->where('name', 'pending'))->count(),
            'active_loans' => $query->whereHas('status', fn ($q) => $q->where('name', 'approved'))->count(),
            'completed_loans' => $query->whereHas('status', fn ($q) => $q->where('name', 'returned'))->count(),
        ];
    }

    private function getHelpdeskStats($user): array
    {
        $query = in_array($user->role, ['ict_admin', 'super_admin'], true)
            ? HelpdeskTicket::query()
            : $user->helpdeskTickets();

        return [
            'total_tickets' => $query->count(),
            'open_tickets' => $query->whereHas('status', fn ($q) => $q->whereIn('name', ['new', 'in_progress']))->count(),
            'resolved_tickets' => $query->whereHas('status', fn ($q) => $q->where('name', 'resolved'))->count(),
            'closed_tickets' => $query->whereHas('status', fn ($q) => $q->where('name', 'closed'))->count(),
        ];
    }

    private function getAdminStats(): array
    {
        return [
            'total_users' => User::where('is_active', true)->count(),
            'total_equipment' => EquipmentItem::count(),
            'available_equipment' => EquipmentItem::where('is_available', true)->count(),
            'pending_approvals' => LoanRequest::whereHas('status', fn ($q) => $q->where('name', 'pending'))->count(),
            'urgent_tickets' => HelpdeskTicket::where('priority', 'urgent')
                ->whereHas('status', fn ($q) => $q->whereIn('name', ['new', 'in_progress']))
                ->count(),
        ];
    }

    private function getRecentActivities($user): array
    {
        $activities = collect();

        // Recent loan requests
        $loanQuery = $user->role === 'admin'
            ? LoanRequest::with(['user', 'status'])
            : $user->loanRequests()->with(['status']);

        $recentLoans = $loanQuery->latest()->limit(5)->get();
        foreach ($recentLoans as $loan) {
            $activities->push([
                'type' => 'loan',
                'title' => 'Permohonan Peminjaman',
                'description' => $loan->purpose,
                'status' => $loan->status->name,
                'user' => $user->role === 'admin' ? $loan->user->name : $user->name,
                'created_at' => $loan->created_at,
            ]);
        }

        // Recent tickets
        $ticketQuery = $user->role === 'admin'
            ? HelpdeskTicket::with(['user', 'status'])
            : $user->helpdeskTickets()->with(['status']);

        $recentTickets = $ticketQuery->latest()->limit(5)->get();
        foreach ($recentTickets as $ticket) {
            $activities->push([
                'type' => 'helpdesk',
                'title' => 'Tiket Helpdesk',
                'description' => $ticket->title,
                'status' => $ticket->status->name,
                'priority' => $ticket->priority,
                'user' => $user->role === 'admin' ? $ticket->user->name : $user->name,
                'created_at' => $ticket->created_at,
            ]);
        }

        // Sort by created date and return latest 10
        return $activities->sortByDesc('created_at')->take(10)->values()->toArray();
    }

    private function getQuickActions($user): array
    {
        $actions = [
            [
                'title' => 'Mohon Peminjaman',
                'description' => 'Buat permohonan baharu untuk meminjam peralatan ICT',
                'icon' => 'plus-circle',
                'route' => '/loan/create',
                'color' => 'primary',
            ],
            [
                'title' => 'Lapor Masalah',
                'description' => 'Laporkan kerosakan atau masalah teknikal',
                'icon' => 'exclamation-triangle',
                'route' => '/helpdesk/create',
                'color' => 'warning',
            ],
        ];

        if ($user->role !== 'admin') {

            return $actions;
        }
        $actions[] = [
            'title' => 'Senarai Kelulusan',
            'description' => 'Semak dan luluskan permohonan peminjaman',
            'icon' => 'check-circle',
            'route' => '/admin/approvals',
            'color' => 'success',
        ];
        $actions[] = [
            'title' => 'Urus Tiket',
            'description' => 'Urus dan tugaskan tiket helpdesk',
            'icon' => 'cog',
            'route' => '/admin/tickets',
            'color' => 'info',
        ];

        return $actions;
    }
}
