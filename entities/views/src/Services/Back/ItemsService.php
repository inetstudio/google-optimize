<?php

namespace InetStudio\GoogleOptimizePackage\Views\Services\Back;

use InetStudio\GoogleOptimizePackage\Views\Contracts\DTO\ItemDataContract;
use InetStudio\GoogleOptimizePackage\Views\Contracts\Models\ViewModelContract;
use InetStudio\GoogleOptimizePackage\Views\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService implements ItemsServiceContract
{
    /**
     * @var ViewModelContract
     */
    protected $model;

    /**
     * ItemsService constructor.
     *
     * @param  ViewModelContract  $model
     */
    public function __construct(ViewModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Возвращаем модель.
     *
     * @return ViewModelContract
     */
    public function getModel(): ViewModelContract
    {
        return $this->model;
    }

    /**
     * Сохраняем модель.
     *
     * @param  ItemDataContract  $data
     *
     * @return ViewModelContract
     */
    public function save(ItemDataContract $data): ViewModelContract
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
