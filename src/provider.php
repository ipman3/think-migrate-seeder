<?php
// src/provider.php

use think\Service;

class provider extends Service
{
    public function boot()
    {
        $this->commands([
            \ipman3\MigrateSeeder\command\Migrate::class,
            \ipman3\MigrateSeeder\command\Seed::class,
        ]);
    }
}
