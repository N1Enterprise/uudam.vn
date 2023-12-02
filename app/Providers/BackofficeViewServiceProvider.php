<?php

namespace App\Providers;

use App\Classes\AdminAuth;
use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use App\Services\BackofficeMenuService;
use App\Vendors\Localization\SystemCurrency;
use App\View\Components\Backoffice\ContentEditor;
use App\View\Components\Backoffice\PhoneInput;
use App\View\Components\Backoffice\SearchUsernameInput;
use App\View\Components\Backoffice\NumberInput;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class BackofficeViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(BackofficeMenuService::class, function() {
            return new BackofficeMenuService;
        });

        $this->registerViewComposer();
        $this->registerBladeComponent();
        $this->registerDirectives();
    }

    private function getMenuConfig()
    {
        return app(BackofficeMenuService::class)->getMenus();
    }

    private function registerBladeComponent()
    {
        Blade::component('search-username-input', SearchUsernameInput::class);
        Blade::component('phone-input', PhoneInput::class);
        Blade::component('number-input', NumberInput::class);
        Blade::component('content-editor', ContentEditor::class);
    }

    private function registerViewComposer()
    {
        $configurableFiatCurrencies = SystemCurrency::allFiatConfigurable();

        View::composer('frontend.*', function ($view) {
            $view->with('APP_NAME', config('name'));
            $view->with('AUTHENTICATED_ADMIN', AdminAuth::user());
        });

        View::composer('backoffice.*', function ($view) use ($configurableFiatCurrencies) {
            $view->with('LOGO', SystemSetting::from(SystemSettingKeyEnum::PAGE_SETTINGS)->get('logo', []));
            $view->with('APP_NAME', config('name'));
            $view->with('AUTHENTICATED_ADMIN', AdminAuth::user());
            $view->with('__CONFIGURABLE_FIAT_CURRENCIES', $configurableFiatCurrencies);
        });

        View::composer('backoffice.includes.left_menu', function($view) {
            $view->with('LEFT_MENU', $this->getMenuConfig());
        });
    }

    private function registerDirectives()
    {
        Blade::directive('anyerror', function ($expression) {
            return '<?php
            $__errorArgs = ['.$expression.'];
            $__bag = $errors->getBag($__errorArgs[1] ?? \'default\');
            $__anyErrors = array_map(\'trim\', explode(\',\', $__errorArgs[0]));
            $__messages = [];
            $__boolAnyError = false;
            foreach($__anyErrors as $__anyError) {
                if($__bag->has($__anyError)) {
                    $__messages[$__anyError] = $__bag->first($__anyError);
                    if($__boolAnyError == false) $__boolAnyError = true;
                }
            }
            if($__boolAnyError) :
            $displayMessages = function() use($__messages) {
                foreach($__messages ?? [] as $key => $message) {
                    echo "<div data-key=\'$key\' class=\'invalid-feedback\'>$message</div>";
                }
            };
            if (isset($messages)) { $__messagesOriginal = $messages; }
            $messages = $__messages; ?>';
        });

        Blade::directive('endanyerror', function () {
            return '<?php
            unset($messages);
            if (isset($__messagesOriginal)) { $messages = $__messagesOriginal; }
            endif;
            unset($__errorArgs, $__bag, $__anyErrors, $__messages, $__boolAnyError); ?>';
        });
    }
}
