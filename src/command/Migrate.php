<?php// src/command/Migrate.php

namespace Ipman3\MigrateSeeder\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\Db;

class Migrate extends Command
{
    protected function configure()
    {
        $this->setName('migrate')
            ->addOption('rollback', null, \think\console\Option::VALUE_NONE, 'Rollback last migration batch')
            ->setDescription('Run or rollback custom migrations');
    }

    protected function execute(Input $input, Output $output)
    {
        // Similar to earlier logic, check your custom migration path here
        $dir = root_path() . 'ipman3/think-migrate-seeder/src/migration/';
    }
}
