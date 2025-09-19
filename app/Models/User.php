<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $staff_id
 * @property string|null $employee_id
 * @property string|null $office_location
 * @property string|null $avatar_url
 * @property array|null $notification_preferences
 * @property string|null $department
 * @property string|null $phone
 * @property string|null $position
 * @property int|null $supervisor_id
 * @property string|null $profile_picture
 * @property UserRole $role
 * @property array|null $preferences
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HelpdeskTicket> $helpdeskTickets
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LoanRequest> $loanRequests
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Authenticatable implements MustVerifyEmail
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
        'employee_id',
        'office_location',
        'role',
        'division',
        'department',
        'position',
        'phone',
        'supervisor_id',
        'is_active',
        'last_login_at',
        'profile_picture',
        'avatar_url',
        'preferences',
        'notification_preferences',
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
            'role' => UserRole::class,
            'preferences' => 'array',
            'notification_preferences' => 'array',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
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
    public function tickets()
    {
        return $this->hasMany(HelpdeskTicket::class, 'user_id');
    }

    /**
     * Alias for tickets relation used across codebase.
     */
    public function helpdeskTickets(): HasMany
    {
        return $this->tickets();
    }

    /**
     * Get the helpdesk tickets assigned to this user.
     */
    public function assignedTickets()
    {
        return $this->hasMany(HelpdeskTicket::class, 'assigned_to');
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
     * Get the activity logs for this user.
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    /**
     * Alias used by some components.
     */
    public function activities(): HasMany
    {
        return $this->activityLogs();
    }

    /**
     * Alias for activityLogs used by admin audit log viewer.
     */
    public function auditLogs(): HasMany
    {
        return $this->activityLogs();
    }

    /**
     * Simple role checker supporting string, enum and array of roles.
     * This project uses a role enum on the users table instead of Spatie roles.
     *
     * @param  string|array<int,string>|\App\Enums\UserRole|array<int,\App\Enums\UserRole>  $roles
     */
    public function hasRole(string|array|UserRole $roles): bool
    {
        $roleValues = [];
        if ($roles instanceof UserRole) {
            $roleValues = [$roles->value];
        } elseif (is_array($roles)) {
            foreach ($roles as $r) {
                $roleValues[] = $r instanceof UserRole ? $r->value : (string) $r;
            }
        } else {
            $roleValues = [(string) $roles];
        }

        return in_array($this->role->value, $roleValues, true);
    }

    /**
     * Check if the user has any of the given roles.
     *
     * @param  array<int,string|\App\Enums\UserRole>  $roles
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->hasRole($roles);
    }
}
