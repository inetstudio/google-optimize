<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Models\ExperimentModelContract;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var ExperimentModelContract
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param  ExperimentModelContract  $item
     */
    public function __construct(ExperimentModelContract $item)
    {
        $this->item = $item;
    }
}
