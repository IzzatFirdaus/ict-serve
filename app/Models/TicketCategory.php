<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $name_bm
 * @property string|null $description
 * @property string|null $description_bm
 * @property string|null $icon
 * @property string $priority
 * @property int|null $default_sla_hours
 * @property bool $is_active
 * @property int $sort_order
 * @property int $total
 * @property int $met_sla
 * @property int $breached_sla
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TicketCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'default_sla_hours' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Get the tickets in this category.
     */
    public function tickets(): HasMany
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
}
