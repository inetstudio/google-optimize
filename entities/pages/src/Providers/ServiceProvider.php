<?php

namespace InetStudio\GoogleOptimizePackage\Pages\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Загрузка сервиса.
     */
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
    }

    /**
     * Регистрация команд.
     */
    protected function registerConsoleCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands(
            [
                'InetStudio\GoogleOptimizePackage\Pages\Console\Commands\SetupCommand',
            ]
        );
    }

    /**
     * Регистрация ресурсов.
     */
    protected function registerPublishes(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../../config/google_optimize_pages.php' => config_path('google_optimize_pages.php'),
        ], 'config');

        if (Schema::hasTable('google_optimize_pages')) {
            return;
        }

        $timestamp = date('Y_m_d_His', time());
        $this->publishes(
            [
                __DIR__.'/../../database/migrations/create_google_optimize_pages_tables.php.stub' => database_path(
                    'migrations/'.$timestamp.'_create_google_optimize_pages_tables.php'
                ),
            ],
            'migrations'
        );
    }
}
