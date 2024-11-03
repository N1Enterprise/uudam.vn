<?php

namespace App\Common;

use App\Models\SystemSetting;
use Illuminate\Support\Str;
use Illuminate\Contracts\Container\BindingResolutionException;

class IntegrationClassResolver
{
    protected $service;

    protected $config;

    protected $name;

    public function __construct($service, $config, $name = null)
    {
        $this->service = $service;
        $this->config = is_string($config) ? SystemSetting::from($config)->get() : $config;
        $this->name = $name;
    }

    /**
     * @param string $service
     * @param mixed $config
     * @param ?string $name
     * @return static
     * @throws BindingResolutionException
     */
    public static function make($service, $config, $name = null)
    {
        return app(static::class, [
            'service' => $service,
            'config' => $config,
            'name' => $name
        ]);
    }

    /**
     * @return mixed
     * @throws Exception
     * @throws BindingResolutionException
     */
    public function resolve()
    {
        $name = $this->getName();
        $config = $this->getConfig();

        if (blank($config) || blank($name)) {
            return null;
        }

        $className = Str::studly($name);
        $integrationService = Str::studly($this->service);
        $integrationClass = implode('\\', array_filter(['App', 'Integrations', $integrationService, $className]));
        $integrationInterface = implode('\\', array_filter(['App', 'Integrations', $integrationService, "{$integrationService}Interface"]));

        $integrationInstance = app($integrationClass, ['setting' => $config]);

        if (! $integrationInstance instanceof $integrationInterface) {
            throw new \Exception("[$name] The  provider service must be implement ".$integrationInterface);
        }

        return $integrationInstance;
    }

    public function getConfig()
    {
        return data_get($this->config, $this->getName());
    }

    public function getName()
    {
        $config = collect($this->config);

        if (blank($config)) {
            return null;
        }

        if (blank($config->where('enable', true)->keys()->first())) {
            return null;
        }

        return $this->name ?? $config->where('enable', true)->keys()->first();
    }
}
