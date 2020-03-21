<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Http\Middlewares\Front;

use Closure;
use Illuminate\Http\Request;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Middlewares\Front\InitializeExperimentsMiddlewareContract;

/**
 * Class InitializeExperimentsMiddleware.
 */
class InitializeExperimentsMiddleware implements InitializeExperimentsMiddlewareContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $itemsService;

    /**
     * InitializeExperimentsMiddleware constructor.
     *
     * @param  ItemsServiceContract  $itemsService
     */
    public function __construct(ItemsServiceContract $itemsService)
    {
        $this->itemsService = $itemsService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  $guard
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $this->itemsService->initialize($request);

        return $next($request);
    }
}
