<?php

namespace App\Providers;


use App\Interfaces\Address\AddressInterface;
use App\Services\Address\AddressServices;
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
        $this->app->bind(AddressInterface::class,AddressServices::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
