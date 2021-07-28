<?php

namespace InetStudio\GoogleOptimizePackage\Pages\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use InetStudio\GoogleOptimizePackage\Pages\Contracts\DTO\ItemDataContract;

class ItemData extends DataTransferObject implements ItemDataContract
{
    public int|string $id;

    public int|string $experiment_id;

    public string $pageable_type;

    public int $pageable_id;

    public array $additional_info;
}
