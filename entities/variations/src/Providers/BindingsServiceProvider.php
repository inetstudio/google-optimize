<?php

namespace InetStudio\GoogleOptimizePackage\Variations\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class BindingsServiceProvider.
 */
class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * @var  array
     */
    public $bindings = [
        'InetStudio\GoogleOptimizePackage\Variations\Contracts\DTO\ItemDataContract' => 'InetStudio\GoogleOptimizePackage\Variations\DTO\ItemData',
        'InetStudio\GoogleOptimizePackage\Variations\Contracts\Models\VariationModelContract' => 'InetStudio\GoogleOptimizePackage\Variations\Models\VariationModel',
        'InetStudio\GoogleOptimizePackage\Variations\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\GoogleOptimizePackage\Variations\Services\Back\ItemsService',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}
