<?php

namespace Modules\Rarv\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Rarv\Events\Handlers\RegisterRarvSidebar;
use Modules\Workshop\Manager\StylistThemeManager;

class RarvServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterRarvSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });
    }

    public function boot(StylistThemeManager $theme)
    {
        $this->publishes([
            __DIR__ . '/../Resources/views' => base_path('resources/views/asgard/rarv'),
        ], 'views');

        $this->app['view']->prependNamespace(
            'rarv',
            base_path('resources/views/asgard/rarv')
        );

        $this->publishConfig('rarv', 'config');
        $this->publishConfig('rarv', 'permissions');
        $this->publishConfig('rarv', 'settings');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        
        require_once __DIR__.'/../includes/helpers.php';
        require_once __DIR__.'/../includes/macros.php';
        require_once __DIR__.'/../includes/validation_rules.php';
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
    }
}
