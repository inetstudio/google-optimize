<?php

namespace InetStudio\GoogleOptimizePackage\Views\Providers;

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
        'InetStudio\GoogleOptimizePackage\Views\Contracts\DTO\ItemDataContract' => 'InetStudio\GoogleOptimizePackage\Views\DTO\ItemData',
        'InetStudio\GoogleOptimizePackage\Views\Contracts\Models\ViewModelContract' => 'InetStudio\GoogleOptimizePackage\Views\Models\ViewModel',
        'InetStudio\GoogleOptimizePackage\Views\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\GoogleOptimizePackage\Views\Services\Back\ItemsService',
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
