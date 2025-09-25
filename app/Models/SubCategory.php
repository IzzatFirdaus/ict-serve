<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EquipmentCategory;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

/**
 * Class SubCategory
 *
 * @property int $id
 * @property int $equipment_category_id
 * @property string $name
 * @property string|null $description
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read EquipmentCategory $equipmentCategory
 * @property-read \Illuminate\Database\Eloquent\Collection|Equipment[] $equipment
 */
class SubCategory extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'equipment_category_id', 'name', 'description', 'is_active', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the equipment category for this subcategory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\EquipmentCategory, self>
     */
    public function equipmentCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class);
    }

    /**
     * Get the equipment for this subcategory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Equipment>
     */
    public function equipment(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Equipment::class);
    }
}
