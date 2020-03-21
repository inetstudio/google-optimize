<?php

namespace InetStudio\GoogleOptimizePackage\Pages\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\GoogleOptimizePackage\Pages\Contracts\Models\PageModelContract;

/**
 * Class PageModel.
 */
class PageModel extends Model implements PageModelContract
{
    use Auditable;
    use SoftDeletes;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'google_optimize_page';

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
    protected $table = 'google_optimize_pages';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'experiment_id',
        'pageable_type',
        'pageable_id',
        'additional_info',
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
     * Атрибуты, которые должны быть преобразованы к базовым типам.
     *
     * @var array
     */
    protected $casts = [
        'additional_info' => 'array',
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
}
