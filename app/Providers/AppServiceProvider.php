<?php

namespace App\Providers;

use Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services
     * 
     * @return {void}
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
				//
				$this->app->bind(\Illuminate\Contracts\Routing\ResponseFactory::class, function () {
						return new \Laravel\Lumen\Http\ResponseFactory();
				});
    }
}
