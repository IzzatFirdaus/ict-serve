<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Grade
 *
 * @property int $id
 * @property string $name
 * @property string $level
 * @property int|null $min_approval_grade_id
 * @property bool $is_approver_grade
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Position[] $positions
 * @property-read Grade|null $minApprovalGrade
 */
class Grade extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'name', 'level', 'min_approval_grade_id', 'is_approver_grade', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'is_approver_grade' => 'boolean',
    ];

    /**
     * Get the positions for the grade.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Position>
     */
    public function positions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Position::class);
    }

    /**
     * Get the minimum approval grade.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<self, self>
     */
    public function minApprovalGrade(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(self::class, 'min_approval_grade_id');
    }

    /**
     * Check if grade is an approver grade.
     */
    public function isApprover(): bool
    {
        return $this->is_approver_grade;
    }
}
