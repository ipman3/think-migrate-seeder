<?php
// src/provider.php
namespace Ipman3\MigrateSeeder;


use think\Service;

class Provider extends Service
{
    public function boot()
    {
        $this->commands([
            \Ipman3\MigrateSeeder\command\Migrate::class,
            \Ipman3\MigrateSeeder\command\Seed::class,
        ]);
    }
}
