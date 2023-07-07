<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

