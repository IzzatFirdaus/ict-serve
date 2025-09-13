<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $asset_number
 * @property string|null $serial_number
 * @property string $category
 * @property string $brand
 * @property string $model
 * @property string|null $description
 * @property \Carbon\Carbon|null $purchase_date
 * @property \Carbon\Carbon|null $warranty_expiry
 * @property float|null $purchase_value
 * @property string $status
 * @property string $condition
 * @property string|null $location
 * @property int|null $assigned_to
 * @property \Carbon\Carbon|null $assigned_date
 * @property string|null $notes
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, DamageComplaint> $damageComplaints
 * @property-read string $formatted_purchase_value
 */
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
        return 'RM '.number_format((float) $this->purchase_value, 2);
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
