<?php

namespace InetStudio\GoogleOptimizePackage\Experiments\Providers;

use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\ViewServiceProvider as BaseViewServiceProvider;
use InetStudio\GoogleOptimizePackage\Experiments\View\Engines\CompilerEngine;
use InetStudio\GoogleOptimizePackage\Experiments\View\Compilers\BladeCompiler;

/**
 * Class ViewServiceProvider.
 */
class ViewServiceProvider extends BaseViewServiceProvider
{
    /**
     * Register the Blade compiler implementation.
     *
     * @return void
     */
    public function registerBladeCompiler()
    {
        $this->app->singleton('blade.compiler', function ($app) {
            return new BladeCompiler($app['files'], $app['config']['view.compiled']);
        });
    }

    /**
     * Register the Blade engine implementation.
     *
     * @param  EngineResolver  $resolver
     * @return void
     */
    public function registerBladeEngine($resolver)
    {
        $resolver->register('blade', function () {
            return new CompilerEngine($this->app['blade.compiler']);
        });
    }
}
