<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property string|null $role
 * @property array|null $preferences
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HelpdeskTicket> $helpdeskTickets
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LoanRequest> $loanRequests
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected array $fillable = [
        'name',
        'email',
        'password',
        'staff_id',
        'division',
        'department',
        'position',
        'phone',
        'role',
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
    protected array $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the supervisor of this user
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    /**
     * Get users supervised by this user
     */
    public function subordinates(): HasMany
    {
        return $this->hasMany(User::class, 'supervisor_id');
    }

    /**
     * Get loan requests made by this user
     */
    public function loanRequests(): HasMany
    {
        return $this->hasMany(LoanRequest::class);
    }

    /**
     * Get loan requests supervised by this user
     */
    public function supervisedLoanRequests(): HasMany
    {
        return $this->hasMany(LoanRequest::class, 'supervisor_id');
    }

    /**
     * Get loan requests approved by this user as ICT admin
     */
    public function ictApprovedLoanRequests(): HasMany
    {
        return $this->hasMany(LoanRequest::class, 'ict_admin_id');
    }

    /**
     * Get helpdesk tickets created by this user
     */
    public function helpdeskTickets(): HasMany
    {
        return $this->hasMany(HelpdeskTicket::class);
    }

    /**
     * Get helpdesk tickets assigned to this user
     */
    public function assignedTickets(): HasMany
    {
        return $this->hasMany(HelpdeskTicket::class, 'assigned_to');
    }

    /**
     * Get audit logs for this user
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
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
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is supervisor
     */
    public function isSupervisor(): bool
    {
        return $this->role === 'supervisor';
    }

    /**
     * Check if user is ICT admin
     */
    public function isIctAdmin(): bool
    {
        return $this->role === 'ict_admin';
    }

    /**
     * Check if user is helpdesk staff
     */
    public function isHelpdeskStaff(): bool
    {
        return $this->role === 'helpdesk_staff';
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Get full name with staff ID
     */
    public function getFullNameWithStaffIdAttribute(): string
    {
        return $this->name.' ('.$this->staff_id.')';
    }

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
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'preferences' => 'array',
        ];
    }
}
