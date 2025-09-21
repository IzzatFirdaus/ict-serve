<?php

declare(strict_types=1);

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.iserve')]

class UserProfile extends Component
{
    use WithFileUploads;

    // Privacy Controls
    public bool $showDeleteMemoryDialog = false;

    /**
     * Show the delete memory confirmation dialog.
     */
    public function confirmDeleteMemory(): void
    {
        $this->showDeleteMemoryDialog = true;
    }

    /**
     * Cancel the delete memory dialog.
     */
    public function cancelDeleteMemory(): void
    {
        $this->showDeleteMemoryDialog = false;
    }

    /**
     * Delete all user memory via privacy API endpoint.
     */
    public function deleteMemory(): void
    {
        $this->showDeleteMemoryDialog = false;
        try {
            $client = new \GuzzleHttp\Client([
                'base_uri' => config('app.url'),
                'timeout' => 10.0,
            ]);
            $token = Auth::user()->createToken('privacy')->plainTextToken;
            $response = $client->delete('/api/privacy/memory', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.$token,
                ],
            ]);
            if ($response->getStatusCode() === 200) {
                $this->dispatch('profile-updated', [
                    'message' => __('Memori anda telah dipadam. / Your memory has been deleted.'),
                    'type' => 'success',
                ]);
            } else {
                $this->dispatch('profile-updated', [
                    'message' => __('Gagal memadam memori. / Failed to delete memory.'),
                    'type' => 'error',
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('profile-updated', [
                'message' => __('Ralat: :msg', ['msg' => $e->getMessage()]),
                'type' => 'error',
            ]);
        }
    }

    // User Profile Data
    public string $name = '';

    public string $email = '';

    public string $staff_id = '';

    public string $department = '';

    public string $phone = '';

    public string $position = '';

    // Password Change
    public string $current_password = '';

    public string $new_password = '';

    public string $new_password_confirmation = '';

    // Preferences
    public string $preferred_language = 'ms';

    public string $theme_preference = 'system';

    public bool $email_notifications = true;

    public bool $sms_notifications = false;

    public bool $browser_notifications = true;

    public array $notification_types = [];

    // Profile Picture
    #[Validate(['image', 'max:2048'])] // 2MB Max
    public $profile_picture;

    public ?string $current_profile_picture = null;

    // Activity and Statistics
    public array $userStats = [];

    public array $recentActivity = [];

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'staff_id' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'department' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'current_password' => 'nullable|current_password',
            'new_password' => 'nullable|min:8|confirmed',
            'new_password_confirmation' => 'nullable|same:new_password',
            'preferred_language' => 'required|in:ms,en',
            'theme_preference' => 'required|in:light,dark,system',
            'profile_picture' => 'nullable|image|max:2048',
        ];
    }

    protected array $messages = [
        'name.required' => 'Nama diperlukan / Name is required',
        'email.required' => 'E-mel diperlukan / Email is required',
        'email.email' => 'Format e-mel tidak sah / Invalid email format',
        'email.unique' => 'E-mel telah digunakan / Email already taken',
        'staff_id.required' => 'ID Staf diperlukan / Staff ID is required',
        'staff_id.unique' => 'ID Staf telah digunakan / Staff ID already taken',
        'department.required' => 'Jabatan diperlukan / Department is required',
        'current_password.current_password' => 'Kata laluan semasa tidak betul / Current password is incorrect',
        'new_password.min' => 'Kata laluan baru mesti sekurang-kurangnya 8 aksara / New password must be at least 8 characters',
        'new_password.confirmed' => 'Pengesahan kata laluan tidak sama / Password confirmation does not match',
        'profile_picture.image' => 'Fail mesti imej / File must be an image',
        'profile_picture.max' => 'Saiz imej tidak boleh melebihi 2MB / Image size cannot exceed 2MB',
    ];

    public function mount(): void
    {
        $user = Auth::user();

        // Load user data
        $this->name = $user->name;
        $this->email = $user->email;
        $this->staff_id = $user->staff_id ?? '';
        $this->department = $user->department ?? '';
        $this->phone = $user->phone ?? '';
        $this->position = $user->position ?? '';

        // Load preferences
        $preferences = $user->preferences ?? [];
        $this->preferred_language = $preferences['language'] ?? 'ms';
        $this->theme_preference = $preferences['theme'] ?? 'system';
        $this->email_notifications = $preferences['email_notifications'] ?? true;
        $this->sms_notifications = $preferences['sms_notifications'] ?? false;
        $this->browser_notifications = $preferences['browser_notifications'] ?? true;
        $this->notification_types = $preferences['notification_types'] ?? [
            'ticket_updates' => true,
            'loan_approvals' => true,
            'equipment_reminders' => true,
            'system_announcements' => true,
        ];

        $this->current_profile_picture = $user->profile_picture;

        $this->loadUserStats();
        $this->loadRecentActivity();
    }

    public function updateProfile(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'staff_id' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'department' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
        ]);

        try {
            $user = Auth::user();

            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'staff_id' => $this->staff_id,
                'department' => $this->department,
                'phone' => $this->phone,
                'position' => $this->position,
            ]);

            session()->flash('success', 'Profil berjaya dikemaskini / Profile updated successfully');
        } catch (\Exception $e) {
            logger('Profile update error: '.$e->getMessage());
            session()->flash('error', 'Ralat mengemaskini profil / Error updating profile');
        }
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);

        try {
            Auth::user()->update([
                'password' => Hash::make($this->new_password),
            ]);

            // Reset password fields
            $this->current_password = '';
            $this->new_password = '';
            $this->new_password_confirmation = '';

            session()->flash('success', 'Kata laluan berjaya dikemaskini / Password updated successfully');
        } catch (\Exception $e) {
            logger('Password update error: '.$e->getMessage());
            session()->flash('error', 'Ralat mengemaskini kata laluan / Error updating password');
        }
    }

    public function updatePreferences(): void
    {
        try {
            $user = Auth::user();

            $preferences = [
                'language' => $this->preferred_language,
                'theme' => $this->theme_preference,
                'email_notifications' => $this->email_notifications,
                'sms_notifications' => $this->sms_notifications,
                'browser_notifications' => $this->browser_notifications,
                'notification_types' => $this->notification_types,
            ];

            $user->update(['preferences' => $preferences]);

            // Update app locale if changed
            if ($this->preferred_language !== session('locale')) {
                session(['locale' => $this->preferred_language]);
                app()->setLocale($this->preferred_language);
            }

            session()->flash('success', 'Keutamaan berjaya dikemaskini / Preferences updated successfully');
        } catch (\Exception $e) {
            logger('Preferences update error: '.$e->getMessage());
            session()->flash('error', 'Ralat mengemaskini keutamaan / Error updating preferences');
        }
    }

    public function updateProfilePicture(): void
    {
        $this->validate([
            'profile_picture' => 'required|image|max:2048',
        ]);

        try {
            $user = Auth::user();

            // Delete old profile picture
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Store new profile picture
            $path = $this->profile_picture->store('profile-pictures', 'public');

            $user->update(['profile_picture' => $path]);

            $this->current_profile_picture = $path;
            $this->profile_picture = null;

            session()->flash('success', 'Gambar profil berjaya dikemaskini / Profile picture updated successfully');
        } catch (\Exception $e) {
            logger('Profile picture update error: '.$e->getMessage());
            session()->flash('error', 'Ralat mengemaskini gambar profil / Error updating profile picture');
        }
    }

    public function deleteProfilePicture(): void
    {
        try {
            $user = Auth::user();

            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
                $user->update(['profile_picture' => null]);
                $this->current_profile_picture = null;

                session()->flash('success', 'Gambar profil berjaya dipadam / Profile picture deleted successfully');
            }
        } catch (\Exception $e) {
            logger('Profile picture deletion error: '.$e->getMessage());
            session()->flash('error', 'Ralat memadam gambar profil / Error deleting profile picture');
        }
    }

    private function loadUserStats(): void
    {
        $user = Auth::user();

        // Get user statistics
        $this->userStats = [
            'total_tickets' => $user->helpdeskTickets()->count(),
            'resolved_tickets' => $user->helpdeskTickets()
                ->whereHas('status', fn ($q) => $q->where('is_final', true))
                ->count(),
            'active_loans' => $user->loanRequests()
                ->whereIn('status', [
                    \App\Enums\LoanRequestStatus::READY_PICKUP->value,
                    \App\Enums\LoanRequestStatus::IN_USE->value,
                ])
                ->count(),
            'total_loans' => $user->loanRequests()->count(),
            'join_date' => $user->created_at,
            'last_login' => $user->last_login_at ?? $user->created_at,
            'tickets_this_month' => $user->helpdeskTickets()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'loans_this_month' => $user->loanRequests()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
    }

    private function loadRecentActivity(): void
    {
        $user = Auth::user();

        // Recent tickets
        $recentTicketsCollection = $user->helpdeskTickets()
            ->with(['category', 'status'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // @phpstan-ignore-next-line
        $recentTickets = $recentTicketsCollection->map(function (\App\Models\HelpdeskTicket $ticket) {
            return [
                'type' => 'ticket',
                'title' => $ticket->title,
                'description' => 'Tiket '.$ticket->ticket_number.' - '.$ticket->category->name,
                'status' => $ticket->status->name,
                'created_at' => $ticket->created_at,
                'url' => route('helpdesk.index-enhanced'),
            ];
        });

        // Recent loans
        $recentLoansCollection = $user->loanRequests()
            ->with(['equipmentItem'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentLoans = $recentLoansCollection->map(function (\App\Models\LoanRequest $loan) {
            return [
                'type' => 'loan',
                'title' => 'Pinjaman Peralatan',
                'description' => $loan->equipmentItem->name ?? 'Equipment Loan',
                'status' => ucfirst($loan->loanStatus->label ?? 'Unknown'),
                'created_at' => $loan->created_at,
                'url' => route('loan.index'),
            ];
        });

        // Combine and sort by date
        $this->recentActivity = $recentTickets->merge($recentLoans)
            ->sortByDesc('created_at')
            ->take(10)
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.profile.user-profile');
    }
}
