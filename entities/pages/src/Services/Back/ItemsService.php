<?php

namespace InetStudio\GoogleOptimizePackage\Pages\Services\Back;

use InetStudio\GoogleOptimizePackage\Pages\Contracts\DTO\ItemDataContract;
use InetStudio\GoogleOptimizePackage\Pages\Contracts\Models\PageModelContract;
use InetStudio\GoogleOptimizePackage\Pages\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService implements ItemsServiceContract
{
    /**
     * @var PageModelContract
     */
    protected $model;

    /**
     * ItemsService constructor.
     *
     * @param  PageModelContract  $model
     */
    public function __construct(PageModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Возвращаем модель.
     *
     * @return PageModelContract
     */
    public function getModel(): PageModelContract
    {
        return $this->model;
    }

    /**
     * Сохраняем модель.
     *
     * @param  ItemDataContract  $data
     *
     * @return PageModelContract
     */
    public function save(ItemDataContract $data): PageModelContract
    {
        return $this->model::updateOrCreate(
            [
                'id' => $data->id,
            ],
            $data->toArray()
        );
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
