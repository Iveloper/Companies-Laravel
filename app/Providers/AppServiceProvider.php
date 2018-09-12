<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        view()->share('languageAll', User::getLanguage());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
