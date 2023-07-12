<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected $userRepository;
    
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(): View {
        $userId = auth()->id();
        $user = $this->userRepository->find($userId);
        
        return view('profile.view', compact('user'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $gender = Config::get('gender');
        
        return view('profile.edit', [
            'user' => $request->user(),
            'gender' => $gender
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        
        $userId = $request->user()->id;
        $this->userRepository->update($userId, $data);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
