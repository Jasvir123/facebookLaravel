<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;

use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;

use App\Repositories\PostLikeRepository;
use App\Repositories\PostLikeRepositoryInterface;

use App\Repositories\SettingRepository;
use App\Repositories\SettingRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PostLikeRepositoryInterface::class, PostLikeRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

