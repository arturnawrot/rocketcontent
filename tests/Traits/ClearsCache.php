<?php

namespace Tests\Traits;

trait ClearsCache
{
    protected function setUp() : void
    {
        parent::setUp();

        $this->clearCache();
    }

    protected function clearCache()
    {
        $commands = ['clear-compiled', 'cache:clear', 'view:clear', 'config:clear', 'route:clear'];
        foreach ($commands as $command) {
            \Illuminate\Support\Facades\Artisan::call($command);
        }
    }
}