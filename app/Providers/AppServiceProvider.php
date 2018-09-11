<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Models\UserModel;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('languageAll', UserModel::getLanguage());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
