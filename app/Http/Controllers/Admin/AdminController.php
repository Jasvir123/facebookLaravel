<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Sanitizer;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\User;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\SettingRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;

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

    public function showUsers(Request $request): View
    {
        $request->merge([
            'searchName' => Sanitizer::sanitizeInput($request->searchName),
            'searchEmail' => Sanitizer::sanitizeInput($request->searchEmail)
        ]);

        $users = $this->userRepository->getAll($request);

        return view('admin.showUsers', compact('users', 'request'));
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

    public function editUser(User $user): View
    {
        $gender = Config::get('gender');
        $route = "admin.user.update";
        return view('profile.edit', compact('user', 'gender','route'));
    }

    public function updateUser(Request $request): RedirectResponse
    {
        // if hidden input is removed. return error.
        if(empty($request->userId)) {
            return Redirect::route('admin.user.edit')->with('error', 'Could not update profile. Please try again later.');
        }
        
        $userId = $request->userId;

        // get user info to show
        $user = $this->userRepository->find($userId);

        $data = $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($userId)],
            'lastName' => ['string', 'max:255'],
            'dob' => ['date', 'before:' . now()->subYears(13)->format('Y-m-d')],
            'profileImage' => [
                'file' => 'min:1', 'max:4096', 'mimes:jpg,jpeg,png',
            ],
            'gender' => ['string', 'max:20'],
            'address' => 'string|max:500',
            'contactNo' => 'digits:10'
        ],[
            'profileImage.max' => 'The profile image size must not exceed 4 MB.',
            'profileImage.min' => 'The profile image must have a minimum size of 1 KB.',
        ]);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        
        $this->userRepository->update($userId, $data);
        return Redirect::route('admin.user.edit', $user)->with('status', 'profile-updated');
    }
}
