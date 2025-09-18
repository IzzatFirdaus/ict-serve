<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;



class TicketCategory extends Model
{
    use HasFactory;

    /**
     * Accessor for total property (stub for Larastan compatibility)
     */
    public function getTotalAttribute(): int
    {
        return $this->attributes['total'] ?? 0;
    }

    /**
     * Accessor for met_sla property (stub for Larastan compatibility)
     */
    public function getMetSlaAttribute(): int
    {
        return $this->attributes['met_sla'] ?? 0;
    }

    /**
     * Accessor for breached_sla property (stub for Larastan compatibility)
     */
    public function getBreachedSlaAttribute(): int
    {
        return $this->attributes['breached_sla'] ?? 0;
    }
    use HasFactory;

    /**
     * Accessor for priority property (stub for Larastan compatibility)
     */
    public function getPriorityAttribute(): ?string
    {
        return $this->attributes['priority'] ?? null;
    }

    /**
     * Accessor for default_sla_hours property (stub for Larastan compatibility)
     */
    public function getDefaultSlaHoursAttribute(): ?int
    {
        return $this->attributes['default_sla_hours'] ?? null;
    }

    /**
     * Accessor for name property (stub for Larastan).
     */
    public function getNameAttribute(): ?string
    {
        return $this->attributes['name'] ?? null;
    }


    /**
     * Get helpdesk tickets in this category
     */
    public function helpdeskTickets(): HasMany
    {
        return $this->hasMany(HelpdeskTicket::class, 'category_id');
    }

    /**
     * Scope for active categories only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'default_sla_hours' => 'integer',
            'sort_order' => 'integer',
        ];
    }
}
