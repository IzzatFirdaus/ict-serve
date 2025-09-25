<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HelpdeskTicket;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

/**
 * Class DamageReport
 *
 * @property int $id
 * @property int $helpdesk_ticket_id
 * @property int $equipment_id
 * @property string $description
 * @property string|null $resolution
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $reported_at
 * @property \Illuminate\Support\Carbon|null $resolved_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read HelpdeskTicket $ticket
 * @property-read Equipment $equipment
 */
class DamageReport extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'helpdesk_ticket_id', 'equipment_id', 'description', 'resolution', 'status', 'reported_at', 'resolved_at', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<HelpdeskTicket, DamageReport>
     */
    public function ticket(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(HelpdeskTicket::class, 'helpdesk_ticket_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Equipment, DamageReport>
     */
    public function equipment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
