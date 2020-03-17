<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Responses\Back\Resource\UpdateResponseContract;

/**
 * Class UpdateResponse.
 */
class UpdateResponse implements UpdateResponseContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $resourceService;

    /**
     * UpdateResponse constructor.
     *
     * @param  ItemsServiceContract  $resourceService
     */
    public function __construct(ItemsServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|null
     *
     * @throws ValidationException
     */
    public function toResponse($request)
    {
        $data = $request->get('itemData');

        $item = $this->resourceService->save($data);

        if (! $item) {
            throw ValidationException::withMessages([
                'id' => 'При сохранении произошла ошибка',
            ]);
        }

        Session::flash('success', 'Эксперимент «'.$item['name'].'» успешно обновлен');

        return response()->redirectToRoute('back.google-optimize-package.experiments.edit', $item['id']);
    }
}
