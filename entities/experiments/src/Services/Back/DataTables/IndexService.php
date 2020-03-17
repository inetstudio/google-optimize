<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Services\Back\DataTables;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Models\ExperimentModelContract;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Services\Back\DataTables\IndexServiceContract;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Resources\Back\Resource\Index\ItemResourceContract;

/**
 * Class IndexService.
 */
class IndexService extends DataTable implements IndexServiceContract
{
    /**
     * @var ExperimentModelContract
     */
    protected $model;

    /**
     * @var ItemResourceContract
     */
    protected $resource;

    /**
     * IndexService constructor.
     *
     * @param  ExperimentModelContract  $model
     *
     * @throws BindingResolutionException
     */
    public function __construct(ExperimentModelContract $model)
    {
        $this->model = $model;
        $this->resource = app()->make(
            ItemResourceContract::class,
            [
                'resource' => null,
            ]
        );
    }

    /**
     * Запрос на получение данных таблицы.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function ajax(): JsonResponse
    {
        return DataTables::of($this->query())
            ->setTransformer(function ($item) {
                return $this->resource::make($item)->resolve();
            })
            ->rawColumns(['actions'])
            ->make();
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        return $this->model->query();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html(): Builder
    {
        /** @var Builder $table */
        $table = app('datatables.html');

        return $table
            ->columns($this->getColumns())
            ->ajax($this->getAjaxOptions())
            ->parameters($this->getParameters());
    }

    /**
     * Получаем колонки.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            ['data' => 'is_active', 'name' => 'is_active', 'title' => 'Активен', 'searchable' => false, 'orderable' => false],
            ['data' => 'name', 'name' => 'name', 'title' => 'Название'],
            ['data' => 'event', 'name' => 'event', 'title' => 'Событие'],
            ['data' => 'experiment_id', 'name' => 'experiment_id', 'title' => 'ID'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Дата создания'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Дата обновления'],
            [
                'data' => 'actions',
                'name' => 'actions',
                'title' => 'Действия',
                'orderable' => false,
                'searchable' => false,
            ],
        ];
    }

    /**
     * Свойства ajax datatables.
     *
     * @return array
     */
    protected function getAjaxOptions(): array
    {
        return [
            'url' => route('back.google-optimize-package.experiments.data.index'),
            'type' => 'POST',
        ];
    }

    /**
     * Свойства datatables.
     *
     * @return array
     */
    protected function getParameters(): array
    {
        $translation = trans('admin::datatables');

        return [
            'paging' => true,
            'pagingType' => 'full_numbers',
            'searching' => true,
            'info' => false,
            'searchDelay' => 350,
            'language' => $translation,
        ];
    }
}
