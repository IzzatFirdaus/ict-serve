<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /** @var list<string> */
    protected array $fillable = [
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
     * Get the category this equipment belongs to
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }

    /**
     * Get loan requests that include this equipment
     */
    public function loanRequests(): BelongsToMany
    {
        return $this->belongsToMany(LoanRequest::class, 'loan_items', 'equipment_item_id', 'loan_request_id')
            ->withPivot(['quantity', 'condition_out', 'condition_in', 'notes_out', 'notes_in', 'damage_reported'])
            ->withTimestamps();
    }

    /**
     * Get loan items for this equipment
     */
    public function loanItems(): HasMany
    {
        return $this->hasMany(LoanItem::class);
    }

    /**
     * Get helpdesk tickets related to this equipment
     */
    public function helpdeskTickets(): HasMany
    {
        return $this->hasMany(HelpdeskTicket::class);
    }

    /**
     * Scope for active equipment only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for available equipment
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->where('is_active', true);
    }

    /**
     * Scope for equipment on loan
     */
    public function scopeOnLoan($query)
    {
        return $query->where('status', 'on_loan');
    }

    /**
     * Check if equipment is currently available for loan
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available' && $this->is_active;
    }

    /**
     * Check if equipment is currently on loan
     */
    public function isOnLoan(): bool
    {
        return $this->status === 'on_loan';
    }

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
