

/**
 * @property int $id
 * @property int $user_id
 * @property string $purpose
 * @property string $location
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property string $status
 * @property array $equipment_items
 * @property array $accessories_checklist_on_issue
 * @property array $accessories_checklist_on_return
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, EquipmentItem> $equipmentItems
 * @property-read \Illuminate\Database\Eloquent\Collection<int, LoanTransaction> $transactions
 */
class LoanRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'purpose',
        'location',
        'start_date',
        'end_date',
        'status',
        'equipment_items',
        'accessories_checklist_on_issue',
        'accessories_checklist_on_return',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'equipment_items' => 'array',
            'accessories_checklist_on_issue' => 'array',
            'accessories_checklist_on_return' => 'array',
        ];
    }

    /**
     * Get the user who made the loan request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the equipment items associated with the loan request.
     */
    public function equipmentItems(): BelongsToMany
    {
        return $this->belongsToMany(EquipmentItem::class, 'loan_request_equipment', 'loan_request_id', 'equipment_item_id');
    }

    /**
     * Get the transactions for the loan request.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(LoanTransaction::class, 'loan_request_id');
    }

    /**
     * Check if the loan request is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if the loan request is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the loan request is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->end_date < now() && $this->status !== 'completed';
    }
}
