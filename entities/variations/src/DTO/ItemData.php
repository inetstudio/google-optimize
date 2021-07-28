<?php

namespace InetStudio\GoogleOptimizePackage\Variations\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use InetStudio\GoogleOptimizePackage\Views\DTO\ItemData as ViewItemData;
use InetStudio\GoogleOptimizePackage\Variations\Contracts\DTO\ItemDataContract;

class ItemData extends DataTransferObject implements ItemDataContract
{
    public int|string $id;

    public string $value;

    public int $experiment_id;

    /** @var \InetStudio\GoogleOptimizePackage\Views\DTO\ItemData[] */
    #[CastWith(ArrayCaster::class, itemType: ViewItemData::class)]
    public $views;
}
