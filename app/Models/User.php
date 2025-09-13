<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
<<<<<<< HEAD
=======
        'last_login_at',
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9
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
<<<<<<< HEAD
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
=======
     * Get the supervisor of this user
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9
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
     * Get the helpdesk tickets assigned to this user.
     */
    public function assignedTickets()
    {
        return $this->hasMany(HelpdeskTicket::class, 'assigned_to');
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
<<<<<<< HEAD
     * Get the activity logs for this user.
=======
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
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9
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
