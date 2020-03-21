<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\DTO;

use Spatie\DataTransferObject\FlexibleDataTransferObject;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\DTO\ItemDataContract;

/**
 * Class ItemData.
 */
class ItemData extends FlexibleDataTransferObject implements ItemDataContract
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $event;

    /**
     * @var string
     */
    public $experiment_id;

    /**
     * @var int
     */
    public $is_active;

    /**
     * @var \InetStudio\GoogleOptimizePackage\Variations\DTO\ItemData[]
     */
    public $variations;

    /**
     * @var \InetStudio\GoogleOptimizePackage\Pages\DTO\ItemData[]
     */
    public $pages;
}
