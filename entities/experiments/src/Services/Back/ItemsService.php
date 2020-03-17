<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Services\Back;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\DTO\ItemDataContract;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Models\ExperimentModelContract;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService implements ItemsServiceContract
{
    /**
     * @var ExperimentModelContract
     */
    protected $model;

    /**
     * ItemsService constructor.
     *
     * @param  ExperimentModelContract  $model
     */
    public function __construct(ExperimentModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Возвращаем модель.
     *
     * @return ExperimentModelContract
     */
    public function getModel(): ExperimentModelContract
    {
        return $this->model;
    }

    /**
     * Создаем модель.
     *
     * @return ExperimentModelContract
     */
    public function create(): ExperimentModelContract
    {
        return new $this->model;
    }

    /**
     * Получаем объект по id.
     *
     * @param  mixed  $id
     * @param  bool  $returnNew
     *
     * @return mixed
     */
    public function getItemById($id = 0, bool $returnNew = true)
    {
        return $this->model->find($id) ?? (($returnNew) ? $this->create() : null);
    }

    /**
     * Сохраняем модель.
     *
     * @param  ItemDataContract  $data
     *
     * @return ExperimentModelContract|null
     *
     * @throws BindingResolutionException
     */
    public function save(ItemDataContract $data): ?ExperimentModelContract
    {
        $item = null;

        $variationsService = app()->make('InetStudio\GoogleOptimizePackage\Variations\Contracts\Services\Back\ItemsServiceContract');

        $item = DB::transaction(function () use ($variationsService, $data) {
            $item = $this->model::updateOrCreate(
                [
                    'id' => $data->id,
                ],
                $data->except('variations')->toArray()
            );

            $variationsIds = collect($data->only('variations')->toArray()['variations'])->pluck('id')->toArray();

            $variationsService->getModel()
                ->where('experiment_id', $data->id)
                ->whereNotIn('id', $variationsIds)
                ->get()
                ->each(function ($variation) use ($variationsService) {
                    $variationsService->destroy($variation['id']);
                });

            foreach ($data->variations as $variation) {
                $variation->experiment_id = $item->id;

                $variationsService->save($variation);
            }

            event(
                app()->make(
                    'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Events\Back\ModifyItemEventContract',
                    compact('item')
                )
            );

            return $item;
        });

        return $item;
    }

    /**
     * Удаляем модель.
     *
     * @param  mixed  $id
     *
     * @return bool|null
     */
    public function destroy($id): ?bool
    {
        return $this->model::destroy($id);
    }
}
