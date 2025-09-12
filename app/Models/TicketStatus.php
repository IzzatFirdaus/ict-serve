<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color',
        'is_active',
        'is_default',
        'is_closed',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'is_closed' => 'boolean',
        ];
    }

    /**
     * Get the tickets with this status.
     */
    public function tickets()
    {
        return $this->hasMany(HelpdeskTicket::class, 'status_id');
    }
}
