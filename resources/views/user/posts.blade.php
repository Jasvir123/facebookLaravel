<x-app-layout>
    <div class="container mx-auto">
        @forelse ($posts as $post)
            <div class="mx-10 my-8 post flex flex-col justify-center bg-blue-100 rounded-lg p-4">
                <span class="text-black font-bold mb-2">{{ $post->user->name }}</span>
                <img src="{{ !empty($post->media) ? Storage::url($post->media) : '' }}" alt="Post Image">

                <span class="text-gray-700 p-2">{{ $post->description }}</span>
            </div>
        @empty
            <p>
                No posts found.
            </p>
        @endforelse
    </div>
</x-app-layout>
