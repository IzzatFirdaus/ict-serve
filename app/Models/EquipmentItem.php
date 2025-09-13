<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EquipmentCondition;
use App\Enums\EquipmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $category_id
 * @property string $asset_tag
 * @property string|null $serial_number
 * @property string $brand
 * @property string $model
 * @property string|null $specifications
 * @property string|null $description
 * @property EquipmentCondition $condition
 * @property EquipmentStatus $status
 * @property float|null $purchase_price
 * @property \Carbon\Carbon|null $purchase_date
 * @property \Carbon\Carbon|null $warranty_expiry
 * @property string|null $location
 * @property string|null $notes
 * @property bool $is_active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read EquipmentCategory $category
 * @property-read LoanItem|null $currentLoan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, LoanItem> $loanItems
 * @property-read \Illuminate\Database\Eloquent\Collection<int, HelpdeskTicket> $tickets
 * @property-read string $warranty_status
 * @property-read string $name
 */
class EquipmentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
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

    protected function casts(): array
    {
        return [
            'condition' => EquipmentCondition::class,
            'status' => EquipmentStatus::class,
            'purchase_price' => 'decimal:2',
            'purchase_date' => 'date',
            'warranty_expiry' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the category this equipment belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }

    /**
     * Get the loan items for this equipment.
     */
    public function loanItems(): HasMany
    {
        return $this->hasMany(LoanItem::class, 'equipment_item_id');
    }

    /**
     * Get the helpdesk tickets related to this equipment.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(HelpdeskTicket::class, 'equipment_item_id');
    }

    /**
     * Check if equipment is available for loan.
     */
    public function isAvailable(): bool
    {
        return $this->status === EquipmentStatus::AVAILABLE
            && $this->is_active
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

    /**
     * Get the equipment name (brand + model).
     */
    public function getNameAttribute(): string
    {
        return trim($this->brand.' '.$this->model);
    }
}
