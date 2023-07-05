<x-app-layout>
    <div class="container mx-auto">
        @forelse ($posts as $post)
            <div class="mx-10 my-2 post flex flex-col justify-center bg-gradient-to-r from-slate-350 rounded-lg p-4">
                <span class="text-black font-bold mb-2">{{ $post->user->name }}</span>
                <img class="rounded-lg" src="{{ !empty($post->media) ? Storage::url($post->media) : '' }}"
                    alt="Post Image">

                <span class="text-gray-700 p-2">{{ $post->description }}</span>

                @forelse ($post->comment as $comment)
                    <div class="my-1 flex flex-col justify-center bg-gradient-to-r from-cyan-100 rounded-md p-2">
                        <span class="text-xs">{{ $comment->user->name }}</span>
                        <span class="mx-5 text-sm p-2">{{ $comment->comment }}</span>
                    </div>
                @empty
                @endforelse



                {{-- <button class="mt-3 self-end bg-gradient-to-r from-blue-500 hover:from-blue-600 text-white font-bold py-2 px-4 rounded" id="addComment">Add Comment</button> --}}
                <form class="flex flex-col justify-center" method="POST" action="{{ route('storeComment') }}">
                    @csrf
                    <x-textarea id="comment" class="mt-6 block mt-1 w-full" name="comment" :value="old('comment')" required
                        autofocus autocomplete="comment" />
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
