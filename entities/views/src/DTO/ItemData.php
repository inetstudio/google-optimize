<?php

namespace InetStudio\GoogleOptimizePackage\Views\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use InetStudio\GoogleOptimizePackage\Views\Contracts\DTO\ItemDataContract;

class ItemData extends DataTransferObject implements ItemDataContract
{
    public int|string $id;

    public string $name;

    public string $content;

    public int|string $variation_id;
}
