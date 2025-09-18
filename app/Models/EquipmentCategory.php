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
 * @property bool $is_active
 * @property int $sort_order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EquipmentItem[] $equipmentItems
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EquipmentItem[] $activeEquipmentItems
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EquipmentItem[] $availableEquipmentItems
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */

class EquipmentCategory extends Model
{
    use HasFactory;

    /**
     * Accessor for name property (stub for Larastan).
     */
    public function getNameAttribute(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    /**
     * Get the equipment items in this category.
     */
    public function equipmentItems(): HasMany
    {
        return $this->hasMany(EquipmentItem::class, 'category_id');
    }

    /**
     * Get active equipment items in this category
     */
    public function activeEquipmentItems(): HasMany
    {
        return $this->hasMany(EquipmentItem::class, 'category_id')
            ->where('is_active', true);
    }

    /**
     * Get available equipment items for loan
     */
    public function availableEquipmentItems(): HasMany
    {
        return $this->hasMany(EquipmentItem::class, 'category_id')
            ->where('is_active', true)
            ->where('status', 'available');
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
            'sort_order' => 'integer',
        ];
    }
}
