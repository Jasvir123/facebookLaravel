<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <p>
            {{ session('success') }}
        </p>
    @endif

    <x-card>

        <form method="POST" action="{{ route('admin.updateSettings') }}">
            @csrf
            <!-- Max Likes -->
            <div class="mt-4">
                <x-input-label for="maxLikes" :value="__('Max Likes')" />
                <x-text-input id="maxLikes" class="block mt-1 w-full" type="text" name="maxLikes" :value="old('maxLikes') ?? $currentDaySettings->maxLikesCount ?? ''"
                    required autofocus />
                <x-input-error :messages="$errors->get('maxLikes')" class="mt-2" />
            </div>

            <!-- Max Posts -->
            <div class="mt-4">
                <x-input-label for="maxPosts" :value="__('Max Posts')" />
                <x-text-input id="maxPosts" class="block mt-1 w-full" type="text" name="maxPosts" :value="old('maxPosts') ?? $currentDaySettings->maxPostsCount ?? ''"
                    required autofocus />
                <x-input-error :messages="$errors->get('maxPosts')" class="mt-2" />
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Update Settings') }}
                </x-primary-button>
            </div>
        </form>
    </x-card>

</x-app-layout>
