<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Contracts\Services\Back;

use InetStudio\GoogleOptimizePackage\Experiments\Contracts\DTO\ItemDataContract;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Models\ExperimentModelContract;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract
{
    /**
     * Сохраняем модель.
     *
     * @param  ItemDataContract  $data
     *
     * @return ExperimentModelContract|null
     */
    public function save(ItemDataContract $data): ?ExperimentModelContract;
}
