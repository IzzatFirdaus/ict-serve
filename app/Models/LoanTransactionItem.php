<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LoanTransaction;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

/**
 * Class LoanTransactionItem
 *
 * @property int $id
 * @property int $loan_transaction_id
 * @property int $equipment_id
 * @property int $quantity
 * @property string|null $remarks
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read LoanTransaction $loanTransaction
 * @property-read Equipment $equipment
 */
class LoanTransactionItem extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'loan_transaction_id', 'equipment_id', 'quantity', 'remarks', 'created_by', 'updated_by', 'deleted_by',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<LoanTransaction, LoanTransactionItem>
     */
    public function loanTransaction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(LoanTransaction::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Equipment, LoanTransactionItem>
     */
    public function equipment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
