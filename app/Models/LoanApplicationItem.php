<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LoanApplication;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

/**
 * Class LoanApplicationItem
 *
 * @property int $id
 * @property int $loan_application_id
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
 * @property-read LoanApplication $loanApplication
 * @property-read Equipment $equipment
 */
class LoanApplicationItem extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'loan_application_id', 'equipment_id', 'quantity', 'remarks', 'created_by', 'updated_by', 'deleted_by',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<LoanApplication, LoanApplicationItem>
     */
    public function loanApplication(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(LoanApplication::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Equipment, LoanApplicationItem>
     */
    public function equipment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
