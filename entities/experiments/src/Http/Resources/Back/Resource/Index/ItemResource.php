<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Http\Resources\Back\Resource\Index;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Resources\Back\Resource\Index\ItemResourceContract;

/**
 * Class ItemResource.
 */
class ItemResource extends JsonResource implements ItemResourceContract
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array
     *
     * @throws Throwable
     */
    public function toArray($request)
    {
        return [
            'id' => (int) $this['id'],
            'is_active' => view(
                'admin.module.google-optimize-package.experiments::back.partials.datatables.active',
                    [
                        'isActive' => $this['is_active'],
                    ]
                )
                ->render(),
            'name' => $this['name'],
            'event' => $this['event'],
            'experiment_id' => $this['experiment_id'],
            'created_at' => (string) $this['created_at'],
            'updated_at' => (string) $this['updated_at'],
            'actions' => view(
                    'admin.module.google-optimize-package.experiments::back.partials.datatables.actions',
                    [
                        'item' => $this,
                    ]
                )
                ->render(),
        ];
    }
}
