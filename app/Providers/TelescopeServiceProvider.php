<?php

namespace App\Providers;

use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Telescope\Console\PruneCommand;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);

        $this->hideSensitiveRequestDetails();

        Telescope::tag(function(IncomingEntry $entry) {
            //
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     *
     * @return void
     */
    protected function hideSensitiveRequestDetails()
    {
        if ($this->app->environment('local') || $this->app->environment('development')) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
            'x-api-key',
        ]);
    }

    public function boot()
    {
        if (app()->runningInConsole()) {
            Telescope::startRecording();
        }

        $this->commands([
            PruneCommand::class
        ]);

        Telescope::auth(function ($request) {
            $adminEmail = null;
            try {
                $adminEmail = optional(Auth::guard('admin')->user())->email;

                return in_array($adminEmail, SystemSetting::from(SystemSettingKeyEnum::TELESCOPE_ACCESS)->get('access_list', []));
            } catch (\Exception $ex) {
                $message = $ex->getMessage();
                $url = $request->url();
                $ip = $request->ip();
                Log::error("ip address $ip try to access telescope at $url, error message is '$message'");

                return false;
            }
        });
    }
}
