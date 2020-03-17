<?php

namespace InetStudio\GoogleOptimizePackage\Views\DTO;

use Spatie\DataTransferObject\FlexibleDataTransferObject;
use InetStudio\GoogleOptimizePackage\Views\Contracts\DTO\ItemDataContract;

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
    public $name;

    /**
     * @var string
     */
    public $content;

    /**
     * @var int|string
     */
    public $variation_id;
}
