<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Providers;

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
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\DTO\ItemDataContract' => 'InetStudio\GoogleOptimizePackage\Experiments\DTO\ItemData',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Events\Back\ModifyItemEvent',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Controllers\Back\ResourceController',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Controllers\Back\DataController',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Middlewares\Front\InitializeExperimentsMiddlewareContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Middlewares\Front\InitializeExperimentsMiddleware',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Requests\Back\Data\GetIndexDataRequestContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Requests\Back\Data\GetIndexDataRequest',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Requests\Back\Resource\CreateRequestContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Requests\Back\Resource\CreateRequest',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Requests\Back\Resource\DestroyRequestContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Requests\Back\Resource\DestroyRequest',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Requests\Back\Resource\EditRequestContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Requests\Back\Resource\EditRequest',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Requests\Back\Resource\IndexRequestContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Requests\Back\Resource\IndexRequest',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Requests\Back\Resource\ShowRequestContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Requests\Back\Resource\ShowRequest',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Requests\Back\Resource\StoreRequestContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Requests\Back\Resource\StoreRequest',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Requests\Back\Resource\UpdateRequestContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Requests\Back\Resource\UpdateRequest',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Resources\Back\Resource\Index\ItemResourceContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Resources\Back\Resource\Index\ItemResource',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Responses\Back\Data\GetIndexDataResponse',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Responses\Back\Resource\CreateResponseContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Responses\Back\Resource\CreateResponse',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Responses\Back\Resource\EditResponseContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Responses\Back\Resource\EditResponse',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Responses\Back\Resource\ShowResponseContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Responses\Back\Resource\ShowResponse',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Responses\Back\Resource\StoreResponseContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Responses\Back\Resource\StoreResponse',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Responses\Back\Resource\UpdateResponseContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Http\Responses\Back\Resource\UpdateResponse',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Models\ExperimentModelContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Models\ExperimentModel',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Services\Back\DataTables\IndexServiceContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Services\Back\DataTables\IndexService',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Services\Back\ItemsService',
        'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\GoogleOptimizePackage\Experiments\Services\Front\ItemsService',
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
