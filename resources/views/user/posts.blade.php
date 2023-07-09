<x-app-layout>
    <div class="container mx-auto max-w-2xl">
        @if (session('success'))
            <p>
                {{ session('success') }}
            </p>
        @endif

        @forelse ($posts as $post)

            <div class="mx-10 my-2 post flex flex-col justify-center bg-gradient-to-r from-teal-100 rounded-lg p-4">

                <div class="post-header flex items-center justify-between mb-2">
                    <span class="text-black font-bold">{{ $post->user->name }}</span>
                    @role('admin')
                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-primary-button>
                                {{ __('Delete Post') }}
                            </x-primary-button>
                        </form>
                    @endrole
                </div>


                <img class="rounded-lg" src="{{ !empty($post->media) ? Storage::url($post->media) : '' }}"
                    alt="Post Image">

                <span class="text-gray-700 p-2">{{ $post->description }}</span>
                <span>
                    @if (count($post->postLike) > 0)
                        <i class="fas fa-heart"></i>
                    @else
                        <i class="far fa-heart"></i>
                    @endif
                </span>

                @forelse ($post->comment as $comment)
                    <div class="my-1 flex flex-col justify-center bg-gradient-to-r from-cyan-100 rounded-md p-2">
                        <span class="text-xs">{{ $comment->user->name }}</span>
                        <span class="mx-5 text-sm p-2">{{ $comment->comment }}</span>
                    </div>

                @empty
                @endforelse

                <form class="flex flex-col justify-center" method="POST" action="{{ route('storeComment') }}">
                    @csrf
                    <x-textarea id="comment" class="mt-6 block mt-1 w-full" name="comment" :value="old('comment')" required
                        autofocus autocomplete="comment" />
                    <x-input-error :messages="$errors->get('comment')" class="mt-2" />

                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <x-primary-button class="flex mt-3 ml-4 self-end">
                        {{ __('Add Comment') }}
                    </x-primary-button>
                </form>

            </div>
        @empty
            <p>
                No posts found.
            </p>
        @endforelse

    </div>

    @push('scripts')
        <script src="{{ asset('js/posts.js') }}"></script>
    @endpush

</x-app-layout>
