<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    @if (session('success'))
        <p>
            {{ session('success') }}
        </p>
    @endif
    <x-card>
        <form action="{{ route('admin.showUsers') }}" method="get">
            <div class="flex items-center gap-10 px-6 py-3 bg-gray-100">
                <x-admin-text-input type="text" name="searchName" value="{{ $request->searchName }}"
                    placeholder="Search by Name"
                    class="border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" />
                <x-admin-text-input type="text" name="searchEmail" value="{{ $request->searchEmail }}"
                    placeholder="Search by Email"
                    class="border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" />

            </div>
            <div class="flex items-center justify-between px-6 py-3 bg-gray-100">
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white bg-teal-700 rounded-lg hover:bg-teal-600 focus:outline-none focus:shadow-outline-teal">Search</button>
            </div>
        </form>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                            
                            @php
                                $userSortClasses = 'opacity-50';
                                if($request->has('sortUser')) {
                                    $userSortClasses = 'underline';
                                }
                            @endphp

                            @if($request->sortUser == 'desc')
                                <a href="{{ route('admin.showUsers', ['sortUser' => 'asc']) }}">
                                    <i class="fas fa-sort-amount-up {{ $userSortClasses }}"></i>
                                </a>
                            @else
                                <a href="{{ route('admin.showUsers', ['sortUser' => 'desc']) }}">
                                    <i class="fas fa-sort-amount-down {{ $userSortClasses }}"></i>
                                </a>
                            @endif
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email

                            @php
                                $emailSortClasses = 'opacity-50';
                                if($request->has('sortEmail')) {
                                    $emailSortClasses = 'underline';
                                }
                            @endphp

                            @if($request->sortEmail == 'desc')
                                <a href="{{ route('admin.showUsers', ['sortEmail' => 'asc']) }}">
                                    <i class="fas fa-sort-amount-up {{ $emailSortClasses }}"></i>
                                </a>
                            @else
                                <a href="{{ route('admin.showUsers', ['sortEmail' => 'desc']) }}">
                                    <i class="fas fa-sort-amount-down {{ $emailSortClasses }}"></i>
                                </a>
                            @endif
                        </th>

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Active
                        </th>

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @include('user.partials.user-name-link', ['user' => $user])
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">

                                <form action="{{ route('user.toggle', $user) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <button type="submit">

                                        @if ($user->isActive)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Inactive
                                            </span>
                                        @endif

                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.user.edit', $user) }}"
                                        class="px-4 py-2 text-sm font-medium leading-5 text-white bg-teal-700 rounded-lg hover:bg-teal-600 focus:outline-none focus:shadow-outline-teal">
                                        Edit User
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
    </x-card>


</x-app-layout>
