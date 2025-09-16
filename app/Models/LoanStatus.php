<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $name_bm
 * @property string|null $description
 * @property string|null $description_bm
 * @property string|null $color
 * @property bool $is_active
 * @property int $sort_order
 * @property-read string $label
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LoanStatus extends Model
{
    use HasFactory;

    /**
     * Public getter for id property.
     */
    public function getId(): int
    {
        return $this->id;
    }

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
     * {@inheritDoc}
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getLabelAttribute(): string
    {
        return app()->getLocale() === 'ms' ? $this->name_bm : $this->name;
    }

    /**
     * Get the loan requests with this status.
     */
    public function loanRequests(): HasMany
    {
        return $this->hasMany(LoanRequest::class, 'status_id');
    }

    /**
     * Check if loan requests with this status can be edited.
     */
    public function canBeEdited(): bool
    {
        return in_array($this->code, ['draft', 'pending', 'supervisor_approved']);
    }

    /**
     * Check if loan requests with this status can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->code, ['draft', 'pending', 'supervisor_approved']);
    }
}
