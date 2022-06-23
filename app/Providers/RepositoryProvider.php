<?php

namespace App\Providers;

use App\Repository\User\UserContract;
use App\Repository\Cart\CartContract;
use Illuminate\Support\ServiceProvider;
use App\Repository\User\UserRepository;
use App\Repository\Cart\CartRepository;
use App\Repository\Product\ProductContract;
use App\Repository\Product\ProductRepository;
use App\Repository\Category\CategoryContract;
use App\Repository\Category\CategoryRepository;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(CategoryContract::class, CategoryRepository::class);
        $this->app->bind(CartContract::class, CartRepository::class);
        $this->app->bind(ProductContract::class, ProductRepository::class);
        $this->app->bind(UserContract::class, UserRepository::class);
    }
}
