<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Responses\Back\Resource\CreateResponseContract;

/**
 * Class CreateResponse.
 */
class CreateResponse implements CreateResponseContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $resourceService;

    /**
     * CreateResponse constructor.
     *
     * @param  ItemsServiceContract  $resourceService
     */
    public function __construct(ItemsServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    /**
     * Возвращаем ответ при создании объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|null
     */
    public function toResponse($request)
    {
        $item = $this->resourceService->create();

        return response()->view('admin.module.google-optimize-package.experiments::back.pages.form', compact('item'));
    }
}
