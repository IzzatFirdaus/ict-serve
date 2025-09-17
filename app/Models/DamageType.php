<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $name_bm
 * @property string|null $description
 * @property string|null $description_bm
 * @property string|null $icon
 * @property string $severity
 * @property bool $is_active
 * @property int $sort_order
 * @property string|null $color_code
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DamageType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_bm',
        'description',
        'description_bm',
        'icon',
        'severity',
        'is_active',
        'sort_order',
        'color_code',
        'metadata',
    ];

    /**
     * Get audit logs for this damage type
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'auditable_id')->where('auditable_type', static::class);
    }

    /**
     * Scope for active damage types only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by name_en
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * Scope to filter by severity
     */
    public function scopeBySeverity($query, string $severity)
    {
        return $query->where('severity', $severity);
    }

    /**
     * Get display name based on locale
     */
    public function getDisplayName(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'ms' || $locale === 'bm'
            ? $this->name_bm
            : $this->name;
    }

    /**
     * Alias for name column - for backward compatibility.
     */
    public function getNameEnAttribute(): string
    {
        return $this->name;
    }

    /**
     * Get display description based on locale
     */
    public function getDisplayDescription(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'ms' || $locale === 'bm'
            ? ($this->description_bm ?? $this->description ?? '')
            : ($this->description ?? $this->description_bm ?? '');
    }

    // Alias used by some tests or legacy code
    public function getDisplayDescriptionText(?string $locale = null): string
    {
        return $this->getDisplayDescription($locale);
    }

    /**
     * Boot the model to add audit logging
     */
    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($model): void {
            static::logAuditEvent($model, 'created', null, $model->toArray());
        });

        static::updated(function ($model): void {
            static::logAuditEvent($model, 'updated', $model->getOriginal(), $model->getChanges());
        });

        static::deleted(function ($model): void {
            static::logAuditEvent($model, 'deleted', $model->toArray(), null);
        });
    }

    /**
     * Log audit events
     */
    protected static function logAuditEvent($model, string $action, ?array $oldValues, ?array $newValues): void
    {
        try {
            AuditLog::create([
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'action' => $action,
                'auditable_type' => static::class,
                'auditable_id' => $model->id,
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'notes' => "Damage type {$action}: {$model->name}",
            ]);
        } catch (\Exception $e) {
            // Log error but don't fail the operation
            logger('Failed to create audit log: '.$e->getMessage());
        }
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'metadata' => 'array',
        ];
    }
}
