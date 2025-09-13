<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EquipmentCondition;
use App\Enums\EquipmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $category_id
 * @property string|null $asset_tag
 * @property string|null $serial_number
 * @property string|null $brand
 * @property string|null $model
 * @property array|null $specifications
 * @property string|null $description
 * @property string $condition
 * @property string $status
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

<<<<<<< HEAD
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

=======
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9
    /**
     * Get the category this equipment belongs to.
     */
    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }

    /**
     * Get the loan requests for this equipment.
     */
    public function loanRequests()
    {
        return $this->hasMany(LoanRequest::class, 'equipment_id');
    }

    /**
     * Get the current active loan for this equipment.
     */
    public function currentLoan()
    {
        return $this->hasOne(LoanRequest::class, 'equipment_id')
            ->whereIn('status', ['approved', 'collected'])
            ->latest();
    }

    /**
     * Get the helpdesk tickets related to this equipment.
     */
    public function tickets()
    {
        return $this->hasMany(HelpdeskTicket::class, 'equipment_id');
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
        if (!$this->warranty_expiry) {
            return 'Unknown';
        }

<<<<<<< HEAD
        if ($this->warranty_expiry > now()) {
            return 'Under Warranty';
        }

        return 'Warranty Expired';
=======
    /**
     * Get the current active loan for this equipment
     */
    public function currentLoan(): ?LoanRequest
    {
        return LoanRequest::query()
            ->whereHas('equipmentItems', function ($query): void {
                $query->where('equipment_item_id', $this->id);
            })
            ->whereIn('status_id', function ($query): void {
                $query->select('id')
                    ->from('loan_statuses')
                    ->whereIn('code', ['ict_approved', 'active']);
            })
            ->first();
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'purchase_price' => 'decimal:2',
            'purchase_date' => 'date',
            'warranty_expiry' => 'date',
        ];
    }
}
