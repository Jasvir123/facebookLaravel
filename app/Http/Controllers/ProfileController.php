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
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileController extends Controller
{
    protected $userRepository;
    
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(User $user): View {
        
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
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore(auth()->user()->id)],
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
