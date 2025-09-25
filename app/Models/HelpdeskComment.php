<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HelpdeskTicket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

/**
 * Class HelpdeskComment
 *
 * @property int $id
 * @property int $helpdesk_ticket_id
 * @property int $user_id
 * @property string $comment
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read HelpdeskTicket $ticket
 * @property-read User $user
 */
class HelpdeskComment extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'helpdesk_ticket_id', 'user_id', 'comment', 'created_by', 'updated_by', 'deleted_by',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<HelpdeskTicket, HelpdeskComment>
     */
    public function ticket(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(HelpdeskTicket::class, 'helpdesk_ticket_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, HelpdeskComment>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
