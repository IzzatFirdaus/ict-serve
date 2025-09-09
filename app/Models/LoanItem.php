<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanItem extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected array $fillable = [
        'loan_request_id',
        'equipment_item_id',
        'quantity',
        'condition_out',
        'condition_in',
        'notes_out',
        'notes_in',
        'damage_reported',
    ];

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
