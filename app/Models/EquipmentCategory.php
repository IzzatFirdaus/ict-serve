<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentCategory extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected array $fillable = [
        'code',
        'name',
        'name_bm',
        'description',
        'description_bm',
        'is_active',
        'sort_order',
    ];

    /**
     * Get all equipment items in this category
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
