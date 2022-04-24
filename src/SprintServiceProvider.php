<?php

namespace Awgst\Sprint;

use App\Providers\AppServiceProvider;

class SprintServiceProvider extends AppServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/sprint.php',
            'sprint'
        );
    }
}