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
                    @include('user.partials.user-name-link', ['user' => $post->user, 'class' => "text-black font-bold"])
                    <span class="text-black font-bold">{{ date("F d, Y", strtotime($post->created_at)) }}</span>
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
                </div>

                    @forelse ($post->comment as $comment)
                        <div class="my-1 flex flex-col justify-center bg-gradient-to-r from-cyan-100 rounded-md p-2">
                            
                            @include('user.partials.user-name-link', ['user' => $comment->user, 'class' => "text-xs"])
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
            {{ $posts->links() }}
        </div>

        @push('scripts')
            <script src="{{ asset('js/posts.js') }}"></script>
        @endpush

    </x-app-layout>
