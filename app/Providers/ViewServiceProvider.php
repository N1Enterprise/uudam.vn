<?php

namespace App\Providers;

use App\Classes\AdminAuth;
use App\Services\MenuService;
use App\View\Components\Backoffice\PhoneInput;
use App\View\Components\Backoffice\SearchUsernameInput;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(MenuService::class, function() {
            return new MenuService;
        });

        $this->registerViewComposer();
        $this->registerBladeComponent();
        $this->registerDirectives();
    }

    private function getMenuConfig()
    {
        return app(MenuService::class)->getMenus();
    }

    private function registerBladeComponent()
    {
        Blade::component('search-username-input', SearchUsernameInput::class);
        Blade::component('phone-input', PhoneInput::class);
    }

    private function registerViewComposer()
    {
        View::composer('backoffice.*', function ($view) {
            $view->with('APP_NAME', config('name'));
            $view->with('AUTHENTICATED_USER',  AdminAuth::user());
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
