<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Class DestroyResponse.
 */
class DestroyResponse implements DestroyResponseContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $resourceService;

    /**
     * DestroyResponse constructor.
     *
     * @param  ItemsServiceContract  $resourceService
     */
    public function __construct(ItemsServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    /**
     * Возвращаем ответ при удалении объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|null
     */
    public function toResponse($request)
    {
        $id = $request->route('experiment');

        $result = $this->resourceService->destroy($id);

        return response()->json(
            [
                'success' => $result,
            ]
        );
    }
}
