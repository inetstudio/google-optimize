<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use InetStudio\GoogleOptimizePackage\Pages\DTO\ItemData as PageItemData;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\DTO\ItemDataContract;
use InetStudio\GoogleOptimizePackage\Variations\DTO\ItemData as VariationItemData;

class ItemData extends DataTransferObject implements ItemDataContract
{
    public int $id;

    public string $name;

    public string $event;

    public string $experiment_id;

    public int $is_active;

    /** @var \InetStudio\GoogleOptimizePackage\Variations\DTO\ItemData[] */
    #[CastWith(ArrayCaster::class, itemType: VariationItemData::class)]
    public $variations;

    /** @var \InetStudio\GoogleOptimizePackage\Pages\DTO\ItemData[] */
    #[CastWith(ArrayCaster::class, itemType: PageItemData::class)]
    public $pages;
}
