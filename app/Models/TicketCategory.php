<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_bm',
        'description',
        'description_bm',
        'icon',
        'priority',
        'default_sla_hours',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'priority' => 'string',
            'default_sla_hours' => 'integer',
        ];
    }

    /**
     * Get the tickets in this category.
     */
    public function tickets()
    {
        return $this->hasMany(HelpdeskTicket::class, 'category_id');
    }
}
