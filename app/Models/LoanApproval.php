<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $loan_request_id
 * @property int $approved_by
 * @property string $status
 * @property string|null $comments
 * @property \Carbon\Carbon|null $approved_at
 * @property-read User $approver
 */
class LoanApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_request_id',
        'approved_by',
        'status',
        'comments',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
        ];
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
