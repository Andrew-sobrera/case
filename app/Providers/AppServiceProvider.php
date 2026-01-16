<?php

namespace App\Providers;

use App\Contracts\AddressRepositoryInterface;
use App\Contracts\PermissionRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Repositories\AddressRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
