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
        
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/sprint.php',
            'sprint'
        );
        foreach (sprint_apps() as $key => $value) {
            $path = sprint_path($value, 'module.json');
            $module = json_decode(file_get_contents($path));
            foreach ($module->providers ?? [] as $provider) {
                $this->app->register($provider);
            }
        }
    }
}