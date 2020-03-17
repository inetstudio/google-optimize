<?php

namespace InetStudio\GoogleOptimizePackage\Variations\Services\Back;

use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\GoogleOptimizePackage\Variations\Contracts\DTO\ItemDataContract;
use InetStudio\GoogleOptimizePackage\Variations\Contracts\Models\VariationModelContract;
use InetStudio\GoogleOptimizePackage\Variations\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService implements ItemsServiceContract
{
    /**
     * @var VariationModelContract
     */
    protected $model;

    /**
     * ItemsService constructor.
     *
     * @param  VariationModelContract  $model
     */
    public function __construct(VariationModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Возвращаем модель.
     *
     * @return VariationModelContract
     */
    public function getModel(): VariationModelContract
    {
        return $this->model;
    }

    /**
     * Сохраняем модель.
     *
     * @param  ItemDataContract  $data
     *
     * @return VariationModelContract
     *
     * @throws BindingResolutionException
     */
    public function save(ItemDataContract $data): VariationModelContract
    {
        $viewsService = app()->make('InetStudio\GoogleOptimizePackage\Views\Contracts\Services\Back\ItemsServiceContract');

        $item = $this->model::updateOrCreate(
            [
                'id' => $data->id,
            ],
            $data->except('views')->toArray()
        );

        $viewsIds = collect($data->only('views')->toArray()['views'])->pluck('id')->toArray();

        $viewsService->getModel()
            ->where('variation_id', $data->id)
            ->whereNotIn('id', $viewsIds)
            ->get()
            ->each(function ($variation) use ($viewsService) {
                $viewsService->destroy($variation['id']);
            });

        foreach ($data->views as $view) {
            $view->variation_id = $item->id;

            $viewsService->save($view);
        }

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
