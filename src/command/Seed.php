<?php

namespace Ipman3\MigrateSeeder\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;

class Seed extends Command
{
    protected function configure()
    {
        $this->setName('seed')
             ->addArgument('class', \think\console\input\Argument::OPTIONAL, 'Seeder class to run')
             ->setDescription('Run seeders (all or specific)');
    }

    protected function execute(Input $input, Output $output)
    {
        $class = $input->getArgument('class');

        if ($class) {
            $file = root_path() . "database/seeds/{$class}.php";
            if (!is_file($file)) {
                $output->error("Seeder file {$class}.php not found.");
                return;
            }
            include_once $file;
            $seeder = new $class();
            $output->writeln("🌱 Running seeder: {$class}");
            $seeder->run();
            $output->writeln("✅ Done: {$class}");
        } else {
            $files = glob(root_path() . 'database/seeds/*.php');
            foreach ($files as $file) {
                $className = pathinfo($file, PATHINFO_FILENAME);
                include_once $file;
                $output->writeln("🌱 Seeding: {$className}");
                $seeder = new $className();
                $seeder->run();
                $output->writeln("✅ Done: {$className}");
            }
        }
    }
}
