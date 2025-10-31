<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\FilamentInfoCommand;

class FilamentInfoServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FilamentInfoCommand::class,
            ]);
        }
    }
}
