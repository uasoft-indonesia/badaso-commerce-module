<?php

namespace Uasoft\Badaso\Module\Commerce\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Uasoft\Badaso\Module\Commerce\BadasoCommerceModule;
use Uasoft\Badaso\Module\Commerce\Commands\BadasoCommerceSetup;
use Uasoft\Badaso\Module\Commerce\Commands\BadasoDeleteExpiredOrder;
use Uasoft\Badaso\Module\Commerce\Facades\BadasoCommerceModule as FacadesBadasoCommerceModule;

class BadasoCommerceModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $kernel = $this->app->make(Kernel::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('BadasoCommerceModule', FacadesBadasoCommerceModule::class);

        $this->app->singleton('badaso-commerce-module', function () {
            return new BadasoCommerceModule();
        });

        $this->loadMigrationsFrom(__DIR__.'/../Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'badaso_commerce');

        $this->publishes([
            __DIR__.'/../Seeder' => database_path('seeders/Badaso/Commerce'),
            __DIR__.'/../Config/badaso-commerce.php' => config_path('badaso-commerce.php'),
        ], 'BadasoCommerce');

        $this->publishes([
            __DIR__.'/../Swagger' => app_path('Http/Swagger/swagger_models'),
        ], 'BadasoCommerceSwagger');

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule
                ->command('badaso-commerce:delete-expired-order')
                ->cron(env('CRON_EXPIRED_ORDER') ?? '*/5 * * * *')
                ->runInBackground();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConsoleCommands();
        $this->app->register(BadasoCommerceModuleEventServiceProvider::class);
    }

    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        $this->commands(BadasoCommerceSetup::class);
        $this->commands(BadasoDeleteExpiredOrder::class);
    }
}
