<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EquipmentCondition;
use App\Enums\EquipmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $category_id
 * @property string|null $asset_tag
 * @property string|null $serial_number
 * @property string|null $brand
 * @property string|null $model
 * @property array|null $specifications
 * @property string|null $description
 * @property EquipmentCondition $condition
 * @property EquipmentStatus $status
 * @property float|null $purchase_price
 * @property \Illuminate\Support\Carbon|null $purchase_date
 * @property \Illuminate\Support\Carbon|null $warranty_expiry
 * @property string|null $location
 * @property string|null $notes
 * @property bool $is_active
 * @property string $name
 * @property-read \App\Models\EquipmentCategory $category
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class EquipmentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'asset_tag',
        'serial_number',
        'brand',
        'model',
        'specifications',
        'description',
        'condition',
        'status',
        'purchase_price',
        'purchase_date',
        'warranty_expiry',
        'location',
        'notes',
        'is_active',
    ];

    /**
     * Get the category this equipment belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }

    /**
     * Get the loan requests for this equipment.
     */
    public function loanRequests(): HasMany
    {
        return $this->hasMany(LoanRequest::class, 'equipment_id');
    }

    /**
     * Get the current active loan for this equipment.
     */
    public function currentLoan(): HasOne
    {
        return $this->hasOne(LoanRequest::class, 'equipment_id')
            ->whereIn('status', ['approved', 'collected'])
            ->latest();
    }

    /**
     * Get the helpdesk tickets related to this equipment.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(HelpdeskTicket::class, 'equipment_id');
    }

    /**
     * Check if equipment is available for loan.
     */
    public function isAvailable(): bool
    {
        return $this->status === EquipmentStatus::AVAILABLE
            && (bool) $this->is_active === true
            && $this->condition !== EquipmentCondition::DAMAGED;
    }

    /**
     * Get the warranty status.
     */
    public function getWarrantyStatusAttribute(): string
    {
        if (! $this->warranty_expiry) {
            return 'Unknown';
        }

        if ($this->warranty_expiry > now()) {
            return 'Under Warranty';
        }

        return 'Warranty Expired';
    }

    protected function casts(): array
    {
        return [
            'specifications' => 'array',
            'condition' => EquipmentCondition::class,
            'status' => EquipmentStatus::class,
            'purchase_price' => 'decimal:2',
            'purchase_date' => 'date',
            'warranty_expiry' => 'date',
            'is_active' => 'boolean',
        ];
    }
}
