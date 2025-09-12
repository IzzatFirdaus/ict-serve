<?php

namespace App\Models;

use App\Enums\EquipmentCondition;
use App\Enums\EquipmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

        if ($this->warranty_expiry > now()) {
            return 'Under Warranty';
        }

        return 'Warranty Expired';
    }
}
