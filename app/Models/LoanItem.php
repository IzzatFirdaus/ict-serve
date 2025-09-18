<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $loan_request_id
 * @property int $equipment_item_id
 * @property int $quantity
 * @property string|null $condition_out
 * @property string|null $condition_in
 * @property string|null $notes_out
 * @property string|null $notes_in
 * @property bool $damage_reported
 * @property-read \App\Models\LoanRequest $loanRequest
 * @property-read \App\Models\EquipmentItem $equipmentItem
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LoanItem extends Model
{
    use HasFactory;

    /**
     * Get the loan request this item belongs to
     */
    public function loanRequest(): BelongsTo
    {
        return $this->belongsTo(LoanRequest::class);
    }

    /**
     * Get the equipment item
     */
    public function equipmentItem(): BelongsTo
    {
        return $this->belongsTo(EquipmentItem::class);
    }

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'damage_reported' => 'boolean',
        ];
    }
}
