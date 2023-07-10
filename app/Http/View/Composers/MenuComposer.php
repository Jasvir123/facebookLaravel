<?php

namespace App\Http\View\Composers;
use Illuminate\View\View;

class MenuComposer
{
    public function compose(View $view)
    {

        $menus = [
            'News Feed' => 'posts',
            'Create Post' => 'createPost'
        ];

        if (auth()->user()->hasRole('admin')) {

            $menus = [
                'Dashboard' => 'admin.dashboard',
                'Users' => 'admin.showUsers',
                'Posts' => 'posts',
                'Settings' => 'admin.settings'
            ];
        }

        $view->with('menus', $menus);
    }
}
