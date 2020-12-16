<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\User\UserRepository::class, \App\Repositories\User\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Role\RoleRepository::class, \App\Repositories\Role\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Setting\SettingRepository::class, \App\Repositories\Setting\SettingRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Phone\PhoneRepository::class, \App\Repositories\Phone\PhoneRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Prize\PrizeRepository::class, \App\Repositories\Prize\PrizeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Draw\DrawRepository::class, \App\Repositories\Draw\DrawRepositoryEloquent::class);
        //:end-bindings:
    }
}
