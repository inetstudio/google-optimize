<?php

namespace InetStudio\GoogleOptimizePackage\Pages\Providers;

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
        'InetStudio\GoogleOptimizePackage\Pages\Contracts\DTO\ItemDataContract' => 'InetStudio\GoogleOptimizePackage\Pages\DTO\ItemData',
        'InetStudio\GoogleOptimizePackage\Pages\Contracts\Models\PageModelContract' => 'InetStudio\GoogleOptimizePackage\Pages\Models\PageModel',
        'InetStudio\GoogleOptimizePackage\Pages\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\GoogleOptimizePackage\Pages\Services\Back\ItemsService',
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
