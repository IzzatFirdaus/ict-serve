<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $status
 * @property string|null $notes
 * @property int $user_id
 * @property string $approvable_type
 * @property int $approvable_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 */
class Approval extends Model
{
    protected $fillable = [
        'status',
        'notes',
        'user_id',
        'approvable_type',
        'approvable_id',
    ];

    /**
     * Get the parent approvable model (LoanRequest, etc).
     */
    public function approvable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who made the approval.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
