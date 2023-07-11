<x-app-layout>
    @push('css')
        <link href="{{ asset('css/posts.css') }}" rel="stylesheet">
    @endpush
    <div class="container mx-auto max-w-2xl">

        {{ $posts->links() }}

        @if (session('success'))
            <p>
                {{ session('success') }}
            </p>
        @endif

        @forelse ($posts as $post)
            <div class="mx-10 my-2 post flex flex-col justify-center bg-gradient-to-r from-teal-100 rounded-lg p-4">

                <div class="post-header flex items-center justify-between mb-2">
                    <span class="text-black font-bold">{{ $post->user->name }}</span>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-primary-button onclick="return confirm('Are you sure?')">
                            {{ __('Delete Post') }}
                        </x-primary-button>
                    </form>
                </div>


                <img class="rounded-lg" src="{{ !empty($post->media) ? Storage::url($post->media) : '' }}"
                    alt="Post Image">

                <span class="text-gray-700 p-2">{{ $post->description }}</span>

                <div class="flex items-center justify-between">
                    <button class="like-button flex items-center w-fit" data-post-id="{{ $post->id }}">
                        @if (count($post->postLike) > 0)
                            <i class="fas fa-heart"></i>
                        @else
                            <i class="far fa-heart"></i>
                        @endif
                        <span class="loader"></span>
                    </button>
                    @if (count($post->comment) > 0)
                        @livewire('modal-component', ['post_id' => $post->id])
                    @endif
                </div>

            </div>
        @empty
            <p>
                No posts found.
            </p>
        @endforelse
        {{ $posts->links() }}
    </div>

    @push('scripts')
        <script src="{{ asset('js/posts.js') }}"></script>
    @endpush

</x-app-layout>
