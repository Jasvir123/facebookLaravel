<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>


    @if (session('error'))
        <p>
            {{ session('error') }}
        </p>
    @endif

    @if (session('status') === 'profile-updated')
        <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-gray-600 mt-4"
        >{{ __('Saved.') }}</p>
    @endif
    
    <form method="post" action="{{ route($route ?? 'profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <input type="hidden" name="userId" value="{{ $user->id }}">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-input-label for="lastName" :value="__('Last Name')" />
            <x-text-input id="lastName" class="block mt-1 w-full" type="text" name="lastName" :value="old('lastName', $user->lastName)"
                autofocus autocomplete="last name" />
            <x-input-error :messages="$errors->get('lastName')" class="mt-2" />
        </div>

        <!-- Gender -->
        <div class="mt-4">
            <x-input-label for="gender" :value="__('Gender')" />
            <x-select-input class="w-full" id="gender" name="gender">
                <option value="">Select gender</option>

                @foreach (StaticArray::$gender as $genderOption)
                    <option value="{{ $genderOption }}" @selected($genderOption == $user->gender)>{{ ucwords($genderOption) }}</option>
                @endforeach
            </x-select-input>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Date of Birth -->
        <div class="mt-4">
            <x-input-label for="dob" :value="__('Date of Birth')" />
            <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob', date('Y-m-d', strtotime($user->dob)))"
                autofocus autocomplete="last name" />
            <x-input-error :messages="$errors->get('dob')" class="mt-2" />
        </div>

        <!-- Profile Image -->
        <div class="mt-4">
            <x-input-label for="profileImage" :value="__('Profile Image')" />
            <x-text-input id="profileImage" class="block mt-1 w-full" type="file" name="profileImage"
                :value="old('profileImage', $user->profileImage)" autofocus autocomplete="profile image" />
            <x-input-error :messages="$errors->get('profileImage')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')" />
            <x-textarea id="address" class="block mt-1 w-full" name="address" autofocus
                autocomplete="address">
                {{ old('address', $user->address) }}
            </x-textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Contact Number -->
        <div class="mt-4">
            <x-input-label for="contactNo" :value="__('Contact Number')" />
            <x-text-input id="contactNo" class="block mt-1 w-full" type="number" name="contactNo" :value="old('contactNo', $user->contactNo)" autofocus
                autocomplete="contact number" />
            <x-input-error :messages="$errors->get('contactNo')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
