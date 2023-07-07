<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\User;
use App\Models\Post;
use Spatie\Permission\Models\Role;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\PostRepositoryInterface;

class AdminController extends Controller
{
    protected $userRepository;
    protected $postRepository;

    public function __construct(UserRepositoryInterface $userRepository, PostRepositoryInterface $postRepository)
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
    }

    public function dashboard(): View
    {
        $userCount = $this->userRepository->getAllCount();
        $postsCount = $this->postRepository->getAllCount();
        $activeUserCount = $this->userRepository->getAllActiveCount();

        return view('admin.dashboard', compact('userCount', 'postsCount', 'activeUserCount'));
    }

    public function showUsers(): View
    {
        $users = $this->userRepository->getAll();
        return view('admin.showUsers', compact('users'));
    }

    public function userToggle(User $user)
    {
        $this->userRepository->userIsActiveToggle($user);

        return Redirect::to('admin/showUsers')->with('success', 'User status toggled successfully.');
    }
}
