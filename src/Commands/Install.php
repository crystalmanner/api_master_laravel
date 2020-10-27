<?php
namespace FreshinUp\ActivityApi\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    protected $signature = 'fresh-activity:install';
    protected $description = 'Install Fresh Activity Api into you application';

    public function handle()
    {
        $msg = "If this is not the first time you're running this command in this project, enter 'no'";

        if ($this->confirm($msg)) {
            // Publish config file
            $this->call('vendor:publish', [
                '--tag' => 'fresh-activity-api.config',
            ]);

            // Prevent duplicate migration for the same table
            array_map('unlink', glob('database/migrations/*_create_media_table.php'));
            $this->call('vendor:publish', [
                '--provider' => 'Spatie\MediaLibrary\MediaLibraryServiceProvider',
                '--tag' => 'migrations',
            ]);
        }
    }
}
