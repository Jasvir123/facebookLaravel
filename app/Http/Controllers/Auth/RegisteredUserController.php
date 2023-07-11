<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\File;
use Illuminate\View\View;

use App\Repositories\UserRepositoryInterface;

class RegisteredUserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) 
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'dob' => ['required', 'date', 'before:' . now()->subYears(13)->format('Y-m-d')],
            'profileImage' => ['required', File::types(['jpg', 'png'])
                ->min(1)
                ->max(12 * 1024),],
            'gender' => ['required','string','max:20'],
            'address' => 'required|string|max:500',
            'contactNo' => 'required|string|min:7|max:20',
        ]);

        $user = $this->userRepository->create($data);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::getHome());
    }
}
