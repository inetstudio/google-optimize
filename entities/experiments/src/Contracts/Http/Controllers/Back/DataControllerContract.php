<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Controllers\Back;

use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Requests\Back\Data\GetIndexDataRequestContract;
use InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract;

/**
 * Interface DataControllerContract.
 */
interface DataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param  GetIndexDataRequestContract  $request
     * @param  GetIndexDataResponseContract  $response
     *
     * @return GetIndexDataResponseContract
     */
    public function getIndexData(
        GetIndexDataRequestContract $request,
        GetIndexDataResponseContract $response
    ): GetIndexDataResponseContract;
}
