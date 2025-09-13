<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $name_bm
 * @property string|null $description
 * @property string|null $description_bm
 * @property string|null $color
 * @property bool $is_active
 * @property bool $is_final
 * @property int $sort_order
 * @property-read string $label
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TicketStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'name_bm',
        'description',
        'description_bm',
        'color',
        'is_active',
        'is_final',
        'sort_order',
    ];

<<<<<<< HEAD
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_final' => 'boolean',
        ];
=======
    public function getLabelAttribute(): string
    {
        return app()->getLocale() === 'ms' ? $this->name_bm : $this->name;
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9
    }

    /**
     * Get the tickets with this status.
     */
    public function tickets()
    {
        return $this->hasMany(HelpdeskTicket::class, 'status_id');
    }
<<<<<<< HEAD
=======

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
    {
        return [
            'is_active' => 'boolean',
            'is_final' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9
}
