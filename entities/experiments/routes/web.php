<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\GoogleOptimizePackage\Experiments\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/google-optimize-package',
    ],
    function () {
        Route::any('google-optimize-package/experiments/data', 'DataControllerContract@getIndexData')
            ->name('back.google-optimize-package.experiments.data.index');

        Route::resource(
            'experiments', 'ResourceControllerContract',
            [
                'as' => 'back.google-optimize-package',
            ]
        );
    }
);
