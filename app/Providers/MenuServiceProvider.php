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
        $menus = [
            'Dashboard' => 'admin.dashboard',
            'Users' => 'admin.showUsers',
            'Posts' => 'posts',
            'Settings' => 'admin.settings'
        ];

        View::composer('layouts.app', function ($view) use ($menus) {
            $view->with('menus', $menus);
        });
    }
}
