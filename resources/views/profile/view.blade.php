<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Profile') }}
        </h2>
    </x-slot>

    {{-- <x-card> --}}

    <div class="flex justify-evenly min-h-600">


        <div class="bg-white rounded-md m-6 p-6 w-1/2 flex flex-col justify-center items-center">
            @if (!empty($user->profileImage))
                <img class="rounded-full overflow-hidden h-60 w-60 object-cover"
                    src="{{ Storage::url($user->profileImage) }}" alt="profile image">
            @else
                <p>No Image found. Edit Profile to add profile image.</p>
                <x-primary-button type="button" class="ml-3">
                    <a href="/profile#profileImage">Edit Profile</a>
                </x-primary-button>
            @endif

            <span class="text-gray-500 mt-2 text-lg">
                {{ $user->fullName }}
            </span>
        </div>


        <div class="bg-white rounded-md m-6 p-6 w-1/2 flex justify-center">
            <table class="min-w-full">
                <tbody>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-300">Gender</th>
                        <td class="py-2 px-4 border-b border-gray-300 text-gray-500">{{ $user->gender }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-300">DOB</th>
                        <td class="py-2 px-4 border-b border-gray-300 text-gray-500">
                            {{ date(Config::get('dateTimeFormat.date'), strtotime($user->dob)) }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-300">Contact No</th>
                        <td class="py-2 px-4 border-b border-gray-300 text-gray-500">{{ $user->contactNo }}</td>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-300">Address</th>
                        <td class="py-2 px-4 border-b border-gray-300 text-gray-500">{{ $user->address }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>




    {{-- </x-card> --}}

</x-app-layout>
