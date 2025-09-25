<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use App\Models\User;

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
class Approval extends Model implements AuditableContract
{
    use SoftDeletes, Auditable;

    protected $fillable = [
        'status',
        'notes',
        'user_id',
        'approvable_type',
        'approvable_id',
        'remarks',
        'approved_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    /**
     * Get the parent approvable model (LoanRequest, etc).
     */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo<Model, Approval>
     */
    public function approvable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Approval>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
