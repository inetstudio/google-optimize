<?php

namespace InetStudio\GoogleOptimizePackage\Variations\DTO;

use Spatie\DataTransferObject\FlexibleDataTransferObject;
use InetStudio\GoogleOptimizePackage\Variations\Contracts\DTO\ItemDataContract;

/**
 * Class ItemData.
 */
class ItemData extends FlexibleDataTransferObject implements ItemDataContract
{
    /**
     * @var int|string
     */
    public $id;

    /**
     * @var string
     */
    public $value;

    /**
     * @var int
     */
    public $experiment_id;

    /**
     * @var \InetStudio\GoogleOptimizePackage\Views\DTO\ItemData[]
     */
    public $views;
}
