<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DamageComplaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_number',
        'complainant_name',
        'complainant_division',
        'complainant_position',
        'contact_number',
        'email',
        'damage_type',
        'damage_description',
        'incident_date',
        'incident_time',
        'location',
        'priority',
        'status',
        'technician_assigned',
        'assigned_at',
        'resolved_at',
        'resolution_notes',
        'estimated_cost',
        'actual_cost',
        'photos',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'assigned_at' => 'datetime',
        'resolved_at' => 'datetime',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'photos' => 'array',
    ];

    /**
     * Get the asset for this damage complaint.
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_number', 'asset_number');
    }

    /**
     * Get the status color for display.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'submitted' => 'warning',
            'in_progress' => 'primary',
            'resolved' => 'success',
            'closed' => 'gray',
            default => 'gray'
        };
    }

    /**
     * Get the priority color for display.
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            'critical' => 'danger',
            default => 'gray'
        };
    }

    /**
     * Check if the complaint can be assigned to a technician.
     */
    public function canBeAssigned(): bool
    {
        return $this->status === 'submitted';
    }

    /**
     * Check if the complaint can be resolved.
     */
    public function canBeResolved(): bool
    {
        return $this->status === 'in_progress';
    }
}
