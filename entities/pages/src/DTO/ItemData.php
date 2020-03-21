<?php

namespace InetStudio\GoogleOptimizePackage\Pages\DTO;

use Spatie\DataTransferObject\FlexibleDataTransferObject;
use InetStudio\GoogleOptimizePackage\Pages\Contracts\DTO\ItemDataContract;

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
     * @var int|string
     */
    public $experiment_id;

    /**
     * @var string
     */
    public $pageable_type;

    /**
     * @var int
     */
    public $pageable_id;

    /**
     * @var array
     */
    public $additional_info;
}
