<?php

namespace App\Providers;

use App\Models\Permission;
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


    public function register() {
        //
    }

}
