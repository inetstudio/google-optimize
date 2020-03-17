<?php

namespace InetStudio\GoogleOptimizePackage\Variations\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\GoogleOptimizePackage\Variations\Contracts\Models\VariationModelContract;

/**
 * Class VariationModel.
 */
class VariationModel extends Model implements VariationModelContract
{
    use Auditable;
    use SoftDeletes;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'google_optimize_variation';

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
    protected $table = 'google_optimize_variations';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'experiment_id',
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
     * Отношение "один к одному" с моделью эксперимента.
     *
     * @return HasOne
     *
     * @throws BindingResolutionException
     */
    public function experiment(): HasOne
    {
        $experimentModel = app()->make('InetStudio\GoogleOptimizePackage\Experiments\Contracts\Models\ExperimentModelContract');

        return $this->hasOne(
            get_class($experimentModel),
            'id',
            'experiment_id'
        );
    }

    /**
     * Связь с моделью представлений.
     *
     * @return HasMany
     *
     * @throws BindingResolutionException
     */
    public function views(): HasMany
    {
        $viewModel = app()->make('InetStudio\GoogleOptimizePackage\Views\Contracts\Models\ViewModelContract');

        return $this->hasMany(
            get_class($viewModel),
            'variation_id',
            'id'
        );
    }
}
