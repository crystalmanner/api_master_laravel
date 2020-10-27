<?php

namespace FreshinUp\ActivityApi\Commands;

use FreshinUp\ActivityApi\ActivityApi;
use Illuminate\Console\Command;

class Version extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View the current version of Fresh BUS';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fresh-activity:version';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $busPath = base_path() . '/' . ActivityApi::$packagePath;
        $isFreshBusLinked = is_link($busPath);
        $version = $isFreshBusLinked ? 'local link (see ' . $busPath . ')' : ActivityApi::getVersion();
        $this->line('<info>Fresh Activity</info> version <comment>' . $version . '</comment>');
    }
}
