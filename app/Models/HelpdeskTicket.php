<?php
namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketUrgency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $ticket_number
 * @property int $user_id
 * @property int $category_id
 * @property int $status_id
 * @property string $title
 * @property string $description
 * @property TicketPriority $priority
 * @property TicketUrgency $urgency
 * @property int|null $assigned_to
 * @property \Carbon\Carbon|null $assigned_at
 * @property int|null $equipment_item_id
 */
class HelpdeskTicket extends Model
{
	use HasFactory;

	// Add your model properties and methods here
}

