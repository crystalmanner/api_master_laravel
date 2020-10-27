<?php

namespace FreshinUp\ActivityApi\Commands;

use Illuminate\Console\Command;

class Link extends Command
{
    protected $name = 'fresh-activity:link';
    protected $description = 'Link FreshBUS for development inside of a project or running a specific branch';

    public function handle()
    {
        if (!is_link('vendor/freshinup/fresh-activity')) {
            passthru('rm -rf vendor/freshinup/fresh-activity');
            passthru('ln -s ../../../fresh-activity/ vendor/freshinup/fresh-activity');
            $this->info('Using local version Fresh Activity');
        } else {
            @unlink('vendor/freshinup/fresh-activity');
            passthru('composer install');
            $this->info('Using version defined in composer.json');
        }
    }
}
