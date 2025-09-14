<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $staff_id
 * @property string|null $department
 * @property string|null $phone
 * @property string|null $position
 * @property string|null $profile_picture
 * @property \App\Enums\UserRole|null $role
 * @property array|null $preferences
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property-read string|null $avatar_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HelpdeskTicket> $helpdeskTickets
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LoanRequest> $loanRequests
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'staff_id',
        'role',
        'division',
        'department',
        'position',
        'phone',
        'supervisor_id',
        'is_active',
        'last_login_at',
        'profile_picture',
        'preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => \App\Enums\UserRole::class,
            'preferences' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the supervisor that this user reports to.
     */
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    /**
     * Get the subordinates that report to this user.
     */
    public function subordinates()
    {
        return $this->hasMany(User::class, 'supervisor_id');
    }

    /**
     * Get the loan requests created by this user.
     */
    public function loanRequests()
    {
        return $this->hasMany(LoanRequest::class, 'user_id');
    }

    /**
     * Get the loan requests supervised by this user.
     */
    public function supervisedLoanRequests()
    {
        return $this->hasMany(LoanRequest::class, 'supervisor_id');
    }

    /**
     * Get the helpdesk tickets created by this user.
     */
    public function helpdeskTickets(): HasMany
    {
        return $this->hasMany(HelpdeskTicket::class, 'user_id');
    }

    /**
     * Get the helpdesk tickets created by this user (alias).
     */
    public function tickets(): HasMany
    {
        return $this->helpdeskTickets();
    }

    /**
     * Get the helpdesk tickets assigned to this user.
     */
    public function assignedTickets(): HasMany
    {
        return $this->hasMany(HelpdeskTicket::class, 'assigned_to');
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string|array $role): bool
    {
        if (is_array($role)) {
            return in_array($this->getCurrentRole(), $role);
        }

        return $this->getCurrentRole() === $role;
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole(array|string $roles): bool
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }

        return in_array($this->getCurrentRole(), $roles);
    }

    /**
     * Get activities for this user - alias for audit logs.
     */
    public function activities()
    {
        return $this->auditLogs();
    }

    /**
     * Get roles relationship - for compatibility.
     * In this system, role is stored as an enum field, not a relationship.
     */
    public function roles()
    {
        // Return a collection containing the current role
        return collect([$this->role]);
    }

    /**
     * Get the current role value as string.
     */
    private function getCurrentRole(): string
    {
        return $this->role->value ?? '';
    }

    /**
     * Get audit logs for this user.
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(\OwenIt\Auditing\Models\Audit::class, 'user_id');
    }

    /**
     * Get the application's custom notifications for this user.
     * Note: Laravel's built-in database notifications are available via Notifiable::notifications().
     */
    public function appNotifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    /**
     * Get notifications for this user
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get unread notifications for this user
     */
    public function unreadNotifications(): HasMany
    {
        return $this->hasMany(Notification::class)->unread()->notExpired();
    }

    /**
     * Check if user has specific role
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // ...existing code...

    /**
     * Get the user's avatar URL.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if ($this->profile_picture) {
            return asset('storage/'.$this->profile_picture);
        }

        // Return gravatar or default avatar
        return 'https://www.gravatar.com/avatar/'.md5(strtolower($this->email)).'?d=mp&s=80';
    }
}
