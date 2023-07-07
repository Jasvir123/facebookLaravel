<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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

    public function showUsers(): View
    {
        $users = $this->getUsers();
        return view('admin.showUsers', compact('users'));
    }

    public function userToggle(User $user)
    {
        $user->isActive = !$user->isActive;
        $user->save();

        return Redirect::to('admin/showUsers')->with('success', 'User status toggled successfully.');
    }

    public function getUsers()
    {
        return Role::where('name', 'user')->first()->users()->get();
    }

    public function getUserCount()
    {
        return $this->getUsers()->count();
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
