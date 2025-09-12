<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

<<<<<<< HEAD
=======
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
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9
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
     * {@inheritDoc}
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getLabelAttribute(): string
    {
        return app()->getLocale() === 'ms' ? $this->name_bm : $this->name;
    }

    /**
     * Get the loan requests with this status.
     */
    public function loanRequests()
    {
        return $this->hasMany(LoanRequest::class, 'status_id');
    }
}
