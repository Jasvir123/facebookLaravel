<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $adminMenus = [
            'Dashboard' => 'admin.dashboard',
            'Users' => 'admin.showUsers',
            'Posts' => 'posts',
            'Settings' => 'admin.settings'
        ];

        $userMenus = [
            'News Feed' => 'posts',
            'Create Post' => 'createPost'
        ];

        View::composer('layouts.app', function ($view) use ($adminMenus, $userMenus) {
            $view->with(['adminMenus' => $adminMenus, 'userMenus' => $userMenus]);
        });
    }
}
