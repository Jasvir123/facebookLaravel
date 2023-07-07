<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-card>
        {{ __('Total Users: ') }} {{ $userCount }}
    </x-card>

    <x-card>
        {{ __('Active Users: ') }} {{ $activeUserCount }}
    </x-card>

    <x-card>
        {{ __('Total Posts: ') }} {{ $postsCount }}
    </x-card>

</x-app-layout>
