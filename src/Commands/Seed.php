<?php

namespace FreshinUp\ActivityApi\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;

class Seed extends Command
{
    protected $name = 'fresh-activity:seed';
    protected $description = 'FreshBUS Seed the Database with Users and Companies';

    public function handle()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            $this->error('Could not connect to the database, please check your configuration:' . "\n" . $e);

            return;
        }
        $this->call('db:seed', [
            '--class' => 'FreshinUp\\FreshBusForms\\Seeds\\DatabaseSeederRequired',
            '--force' => $this->hasOption('force')
        ]);

        if ($this->option('quickstart')) {
            $this->call('db:seed', [
                '--class' => 'FreshinUp\\FreshBusForms\\Seeds\\DatabaseSeederQuickStart',
                '--force' => $this->hasOption('force')
            ]);
        }
    }

    /*
    **
    * Get the console command options.
    *
    * @return array
    */
    protected function getOptions()
    {
        return [
            [
                'quickstart',
                null,
                InputOption::VALUE_NONE,
                'Load sample users, companies, and teams. Helpful for local dev and staging environments'
            ],
            [
                'force',
                null,
                InputOption::VALUE_NONE,
                'Force the database change without requesting user interaction / acceptance'
            ]
        ];
    }
}
