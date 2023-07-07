<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $userCount = $this->getUserCount();
        $postsCount = $this->getPostCount();
        $activeUserCount = $this->getActiveUserCount();

        return view('admin.dashboard', compact('userCount', 'postsCount', 'activeUserCount'));
    }

    public function getUserCount()
    {
        $userCount = Role::where('name', 'user')->first()->users()->count();

        return $userCount;
    }

    public function getActiveUserCount()
    {
        $userCount = Role::where('name', 'user')->first()
            ->users()->where('isActive', '1')->count();

        return $userCount;
    }

    public function getPostCount()
    {
        return Post::count();
    }
}
