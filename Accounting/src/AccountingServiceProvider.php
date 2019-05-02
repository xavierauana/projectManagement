<?php

namespace Anacreation\Accounting;

use Anacreation\Accounting\Contracts\TransactionInterface;
use Illuminate\Support\ServiceProvider;

class AccountingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->mergeConfigFrom(
            __DIR__ . '/config/accounting.php', 'accounting'
        );

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        if (env('APP_ENV') != 'production') {
            $this->app->make('Illuminate\Database\Eloquent\Factory')
                      ->load(__DIR__ . '/../factories');
        }


        app()->bind(TransactionInterface::class,
            config('accounting.transaction'));

        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        $this->publishes([
            __DIR__ . '/config/accounting.php' => config_path('accounting.php'),
        ]);
    }
}
