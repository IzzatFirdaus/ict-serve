<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;



class TicketStatus extends Model
{
    use HasFactory;


    use HasFactory;

    /**
     * Accessor for code property (stub for Larastan).
     */
    public function getCodeAttribute(): ?string
    {
        return $this->attributes['code'] ?? null;
    }

    /**
     * Accessor for name property (stub for Larastan).
     */
    public function getNameAttribute(): ?string
    {
        return $this->attributes['name'] ?? null;
    }


    /**
     * Get helpdesk tickets with this status
     */
    public function helpdeskTickets(): HasMany
    {
        return $this->hasMany(HelpdeskTicket::class, 'status_id');
    }

    /**
     * Scope for active statuses only
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
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Get status by code
     */
    public static function getByCode(string $code): ?self
    {
        return static::where('code', $code)->first();
    }

    protected function casts(): array
    /**
     * @property string $code
     * @property bool   $is_final
     */
    {
        return [
            'is_active' => 'boolean',
            'is_final' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
