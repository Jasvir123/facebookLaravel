<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\User;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\SettingRepositoryInterface;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    protected $userRepository;
    protected $postRepository;
    protected $settingRepository;

    public function __construct(UserRepositoryInterface $userRepository, PostRepositoryInterface $postRepository, SettingRepositoryInterface $settingRepository)
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->settingRepository = $settingRepository;
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

        return Redirect::to('admin/showUsers')->with('success', __('messages.userIsActiveToggled'));
    }

    public function settings(): View
    {
        $currentDaySettings = $this->settingRepository->getCurrentDaySettings();
        return view('admin.settings', compact('currentDaySettings'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'maxLikes' => ['required', 'integer', 'max:50000'],
            'maxPosts' => ['required', 'integer', 'max:50000']
        ]);

        $this->settingRepository->checkOrCreateForCurrentDay($data);
        return Redirect::to('admin/settings')->with('success', __('messages.settingsUpdated'));
    }
}
