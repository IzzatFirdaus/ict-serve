<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EquipmentCategory;
use App\Models\SubCategory;
use App\Models\Location;
use App\Models\Department;
use App\Models\LoanTransactionItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

/**
 * Class Equipment
 *
 * @property int $id
 * @property string $asset_type
 * @property string $brand
 * @property string $model
 * @property string $serial_number
 * @property string $tag_id
 * @property \Illuminate\Support\Carbon|null $purchase_date
 * @property \Illuminate\Support\Carbon|null $warranty_expiry_date
 * @property string $status
 * @property string|null $current_location
 * @property string|null $notes
 * @property string $condition_status
 * @property int $department_id
 * @property int $equipment_category_id
 * @property int $sub_category_id
 * @property int $location_id
 * @property string|null $item_code
 * @property string|null $description
 * @property float|null $purchase_price
 * @property string|null $acquisition_type
 * @property string|null $classification
 * @property string|null $funded_by
 * @property string|null $supplier_name
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read EquipmentCategory $equipmentCategory
 * @property-read SubCategory $subCategory
 * @property-read Location $location
 * @property-read Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection|LoanTransactionItem[] $loanTransactionItems
 */
class Equipment extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'asset_type', 'brand', 'model', 'serial_number', 'tag_id', 'purchase_date', 'warranty_expiry_date',
        'status', 'current_location', 'notes', 'condition_status', 'department_id', 'equipment_category_id',
        'sub_category_id', 'location_id', 'item_code', 'description', 'purchase_price', 'acquisition_type',
        'classification', 'funded_by', 'supplier_name', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expiry_date' => 'date',
        'purchase_price' => 'float',
    ];

    /**
     * Get the equipment category for this equipment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\EquipmentCategory, self>
     */
    public function equipmentCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class);
    }

    /**
     * Get the subcategory for this equipment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\SubCategory, self>
     */
    public function subCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * Get the location for this equipment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Location, self>
     */
    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the department for this equipment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Department, self>
     */
    public function department(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the loan transaction items for this equipment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\LoanTransactionItem>
     */
    public function loanTransactionItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LoanTransactionItem::class);
    }

    public function isLoanable(): bool
    {
        return $this->status === 'available' && $this->condition_status === 'good';
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}
