<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Models\ExperimentModelContract;

/**
 * Class ExperimentModel.
 */
class ExperimentModel extends Model implements ExperimentModelContract
{
    use Auditable;
    use SoftDeletes;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'google_optimize_experiment';

    /**
     * Should the timestamps be audited?
     *
     * @var bool
     */
    protected $auditTimestamps = true;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'google_optimize_experiments';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'event',
        'experiment_id',
        'is_active',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Геттер атрибута type.
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return self::ENTITY_TYPE;
    }

    /**
     * Связь с моделью вариантов.
     *
     * @return HasMany
     *
     * @throws BindingResolutionException
     */
    public function variations(): HasMany
    {
        $variationModel = app()->make('InetStudio\GoogleOptimizePackage\Variations\Contracts\Models\VariationModelContract');

        return $this->hasMany(
            get_class($variationModel),
            'experiment_id',
            'id'
        );
    }

    /**
     * Связь с моделью страниц.
     *
     * @return HasMany
     *
     * @throws BindingResolutionException
     */
    public function pages(): HasMany
    {
        $pageModel = app()->make('InetStudio\GoogleOptimizePackage\Pages\Contracts\Models\PageModelContract');

        return $this->hasMany(
            get_class($pageModel),
            'experiment_id',
            'id'
        );
    }
}
