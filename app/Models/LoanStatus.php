<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $code
 */
class LoanStatus extends Model
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
        'sort_order',
    ];

    /**
     * Get loan requests with this status
     */
    public function loanRequests(): HasMany
    {
        return $this->hasMany(LoanRequest::class, 'status_id');
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
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
