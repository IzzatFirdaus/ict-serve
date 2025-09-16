<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserProfile extends Component
{
    use WithFileUploads;

    // Profile Form Properties
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $department = '';

    public string $position = '';

    public string $employee_id = '';

    public string $office_location = '';

    // Password Change Properties
    public string $current_password = '';

    public string $new_password = '';

    public string $new_password_confirmation = '';

    // Notification Preferences
    public bool $email_notifications = true;

    public bool $sms_notifications = false;

    public bool $loan_reminders = true;

    public bool $approval_notifications = true;

    public bool $system_announcements = true;

    public bool $weekly_digest = false;

    // Avatar Upload
    public $avatar;

    public string $avatar_url = '';

    // UI State
    public string $activeTab = 'profile';

    public array $notifications = [];

    public bool $showPasswordForm = false;

    public bool $profileSaved = false;

    public bool $passwordChanged = false;

    protected array $rules = [
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['nullable', 'string', 'max:20'],
        'department' => ['required', 'string', 'max:255'],
        'position' => ['required', 'string', 'max:255'],
        'employee_id' => ['required', 'string', 'max:50'],
        'office_location' => ['required', 'string', 'max:255'],
        'current_password' => ['required_with:new_password', 'current_password'],
        'new_password' => ['required_with:current_password', Password::defaults()],
        'new_password_confirmation' => ['required_with:new_password', 'same:new_password'],
        'avatar' => ['nullable', 'image', 'max:2048'],
    ];

    protected array $messages = [
        'name.required' => 'Nama adalah wajib.',
        'department.required' => 'Jabatan adalah wajib.',
        'position.required' => 'Jawatan adalah wajib.',
        'employee_id.required' => 'ID Kakitangan adalah wajib.',
        'office_location.required' => 'Lokasi Pejabat adalah wajib.',
        'current_password.current_password' => 'Kata laluan semasa tidak tepat.',
        'new_password.min' => 'Kata laluan baharu mesti sekurang-kurangnya 8 aksara.',
        'new_password_confirmation.same' => 'Pengesahan kata laluan tidak sepadan.',
        'avatar.image' => 'Avatar mesti dalam format imej.',
        'avatar.max' => 'Avatar tidak boleh melebihi 2MB.',
    ];

    public function mount(): void
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->department = $user->department ?? '';
        $this->position = $user->position ?? '';
        $this->employee_id = $user->employee_id ?? '';
        $this->office_location = $user->office_location ?? '';
        $this->avatar_url = $user->avatar_url ?? '';

        // Load notification preferences
        $preferences = $user->notification_preferences ?? [];
        $this->email_notifications = $preferences['email_notifications'] ?? true;
        $this->sms_notifications = $preferences['sms_notifications'] ?? false;
        $this->loan_reminders = $preferences['loan_reminders'] ?? true;
        $this->approval_notifications = $preferences['approval_notifications'] ?? true;
        $this->system_announcements = $preferences['system_announcements'] ?? true;
        $this->weekly_digest = $preferences['weekly_digest'] ?? false;
    }

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetErrorBag();
        $this->profileSaved = false;
        $this->passwordChanged = false;
    }

    public function updateProfile(): void
    {
        $this->validate([
            'name' => $this->rules['name'],
            'phone' => $this->rules['phone'],
            'department' => $this->rules['department'],
            'position' => $this->rules['position'],
            'employee_id' => $this->rules['employee_id'],
            'office_location' => $this->rules['office_location'],
            'avatar' => $this->rules['avatar'],
        ]);

        $user = Auth::user();

        $data = [
            'name' => $this->name,
            'phone' => $this->phone,
            'department' => $this->department,
            'position' => $this->position,
            'employee_id' => $this->employee_id,
            'office_location' => $this->office_location,
        ];

        // Handle avatar upload
        if ($this->avatar) {
            $avatarPath = $this->avatar->store('avatars', 'public');
            $data['avatar_url'] = $avatarPath;
            $this->avatar_url = $avatarPath;
        }

        $user->update($data);

        $this->profileSaved = true;
        $this->avatar = null;

        $this->dispatch('profile-updated', [
            'message' => 'Profil berjaya dikemaskini!',
            'type' => 'success',
        ]);
    }

    public function changePassword(): void
    {
        $this->validate([
            'current_password' => $this->rules['current_password'],
            'new_password' => $this->rules['new_password'],
            'new_password_confirmation' => $this->rules['new_password_confirmation'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        // Clear password fields
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
        $this->showPasswordForm = false;
        $this->passwordChanged = true;

        $this->dispatch('password-changed', [
            'message' => 'Kata laluan berjaya ditukar!',
            'type' => 'success',
        ]);
    }

    public function updateNotificationPreferences(): void
    {
        $preferences = [
            'email_notifications' => $this->email_notifications,
            'sms_notifications' => $this->sms_notifications,
            'loan_reminders' => $this->loan_reminders,
            'approval_notifications' => $this->approval_notifications,
            'system_announcements' => $this->system_announcements,
            'weekly_digest' => $this->weekly_digest,
        ];

        $user = Auth::user();
        $user->update(['notification_preferences' => $preferences]);

        $this->dispatch('preferences-updated', [
            'message' => 'Tetapan notifikasi berjaya dikemaskini!',
            'type' => 'success',
        ]);
    }

    public function togglePasswordForm(): void
    {
        $this->showPasswordForm = ! $this->showPasswordForm;
        $this->resetErrorBag(['current_password', 'new_password', 'new_password_confirmation']);
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
    }

    public function removeAvatar(): void
    {
        $user = Auth::user();

        if ($user->avatar_url) {
            // Delete old avatar file
            Storage::disk('public')->delete($user->avatar_url);
            $user->update(['avatar_url' => null]);
        }

        $this->avatar_url = '';

        $this->dispatch('avatar-removed', [
            'message' => 'Avatar berjaya dipadamkan!',
            'type' => 'success',
        ]);
    }

    public function getRecentActivity(): array
    {
        $user = Auth::user();

        // Get recent loan requests
        $recentLoans = $user->loanRequests()
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($loan) {
                return [
                    'type' => 'loan',
                    'title' => "Permohonan Pinjaman #{$loan->id}",
                    'description' => 'Status: '.ucfirst($loan->status),
                    'date' => $loan->created_at->format('d/m/Y H:i'),
                    'icon' => 'clipboard-list',
                    'color' => $this->getStatusColor($loan->status),
                ];
            });

        return $recentLoans->toArray();
    }

    private function getStatusColor(string $status): string
    {
        return match ($status) {
            'approved' => 'text-success-600',
            'rejected' => 'text-danger-600',
            'pending' => 'text-warning-600',
            default => 'text-gray-600',
        };
    }

    public function render()
    {
        return view('livewire.user-profile', [
            'user' => Auth::user(),
            'recentActivity' => $this->getRecentActivity(),
        ]);
    }
}
