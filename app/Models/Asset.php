<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_number',
        'serial_number',
        'category',
        'brand',
        'model',
        'description',
        'purchase_date',
        'warranty_expiry',
        'purchase_value',
        'status',
        'condition',
        'location',
        'assigned_to',
        'assigned_date',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expiry' => 'date',
        'assigned_date' => 'date',
        'purchase_value' => 'decimal:2',
    ];

    /**
     * Get the damage complaints for this asset.
     */
    public function damageComplaints(): HasMany
    {
        return $this->hasMany(DamageComplaint::class, 'asset_number', 'asset_number');
    }

    /**
     * Get the formatted purchase value.
     */
    public function getFormattedPurchaseValueAttribute(): string
    {
        return 'RM ' . number_format((float) $this->purchase_value, 2);
    }

    /**
     * Check if asset is available for loan.
     */
    public function isAvailableForLoan(): bool
    {
        return in_array($this->status, ['available', 'maintenance']) &&
               $this->condition !== 'damaged';
    }
}
