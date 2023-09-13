<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BackofficeServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'backoffice';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLangs();
        $this->registerViews();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    protected function registerLangs()
    {
        $langPath = resource_path($this->moduleNameLower . '/lang');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        }
    }

    protected function registerViews()
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            dd($path);
            dd($path . '/modules/' . $this->moduleNameLower);
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
