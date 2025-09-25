<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LoanApplication;
use App\Models\User;
use App\Models\LoanTransactionItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

/**
 * Class LoanTransaction
 *
 * @property int $id
 * @property int $loan_application_id
 * @property int $user_id
 * @property string $status
 * @property string|null $remarks
 * @property \Illuminate\Support\Carbon|null $issued_at
 * @property \Illuminate\Support\Carbon|null $returned_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read LoanApplication $loanApplication
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|LoanTransactionItem[] $items
 */
class LoanTransaction extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'loan_application_id', 'user_id', 'status', 'remarks', 'issued_at', 'returned_at', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<LoanApplication, LoanTransaction>
     */
    public function loanApplication(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(LoanApplication::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, LoanTransaction>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<LoanTransactionItem>
     */
    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LoanTransactionItem::class);
    }
}
