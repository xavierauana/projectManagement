<?php

namespace App\Providers;

use App\Client;
use App\Contracts\PayeeInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

        setlocale(LC_MONETARY, config('app.locale'));

        app()->bind(PayeeInterface::class, Client::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //
    }
}
