<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string|null $asset_number
 * @property string $complainant_name
 * @property string $complainant_division
 * @property string|null $complainant_position
 * @property string $contact_number
 * @property string $email
 * @property string $damage_type
 * @property string $damage_description
 * @property \Carbon\Carbon|null $incident_date
 * @property string|null $incident_time
 * @property string|null $location
 * @property string $priority
 * @property string $status
 * @property int|null $technician_assigned
 * @property \Carbon\Carbon|null $assigned_at
 * @property \Carbon\Carbon|null $resolved_at
 * @property string|null $resolution_notes
 * @property float|null $estimated_cost
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read Asset|null $asset
 * @property-read User|null $technician
 */
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
        return match ($this->status) {
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
        return match ($this->priority) {
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
