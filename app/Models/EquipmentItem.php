<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
            'is_active' => 'boolean',
            'purchase_price' => 'decimal:2',
            'purchase_date' => 'date',
            'warranty_expiry' => 'date',
        ];
    }

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
        return $this->loanRequests()
            ->whereIn('status_id', function ($query) {
                $query->select('id')
                    ->from('loan_statuses')
                    ->whereIn('code', ['ict_approved', 'active']);
            })
            ->first();
    }
}
