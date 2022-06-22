<?php

namespace App\Providers;

use App\Repository\User\UserContract;
use Illuminate\Support\ServiceProvider;
use App\Repository\User\UserRepository;
use App\Repository\Product\ProductContract;
use App\Repository\Product\ProductRepository;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ProductContract::class, ProductRepository::class);
        $this->app->bind(UserContract::class, UserRepository::class);
    }
}
