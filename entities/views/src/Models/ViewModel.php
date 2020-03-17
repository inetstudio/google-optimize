<?php

namespace InetStudio\GoogleOptimizePackage\Views\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\GoogleOptimizePackage\Views\Contracts\Models\ViewModelContract;

/**
 * Class ViewModel.
 */
class ViewModel extends Model implements ViewModelContract
{
    use Auditable;
    use SoftDeletes;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'google_optimize_view';

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
    protected $table = 'google_optimize_views';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'content',
        'variation_id',
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
     * Отношение "один к одному" с моделью варианта.
     *
     * @return HasOne
     *
     * @throws BindingResolutionException
     */
    public function variation(): HasOne
    {
        $variationModel = app()->make('InetStudio\GoogleOptimizePackage\Variations\Contracts\Models\VariationModelContract');

        return $this->hasOne(
            get_class($variationModel),
            'id',
            'variation_id'
        );
    }
}
