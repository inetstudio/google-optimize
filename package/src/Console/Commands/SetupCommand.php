<?php

namespace InetStudio\GoogleOptimizePackage\Console\Commands;

use InetStudio\AdminPanel\Base\Console\Commands\BaseSetupCommand;

/**
 * Class SetupCommand.
 */
class SetupCommand extends BaseSetupCommand
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:google-optimize-package:setup';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Setup google optimize package';

    /**
     * Инициализация команд.
     */
    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => 'Google optimize experiments setup',
                'command' => 'inetstudio:google-optimize-package:experiments:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Google optimize variations setup',
                'command' => 'inetstudio:google-optimize-package:variations:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Google optimize views setup',
                'command' => 'inetstudio:google-optimize-package:views:setup',
            ],
        ];
    }
}
