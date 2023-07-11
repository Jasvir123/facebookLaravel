<x-app-layout>
    @push('css')
        <link href="{{ asset('css/adminPosts.css') }}" rel="stylesheet">
    @endpush

    @if (session('success'))
        <p>
            {{ session('success') }}
        </p>
    @endif

    <x-card>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Posted By
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Media
                        </th>

                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($posts as $post)
                        <tr>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $post->user->name }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $post->description }}
                            </td>

                            <td class="px-6 py-4 max-h-250 whitespace-nowrap">
                                <a href="{{ !empty($post->media) ? Storage::url($post->media) : '' }}" target="_blank"
                                    rel="noopener noreferrer">
                                    <img class="rounded-lg max-h-250"
                                        src="{{ !empty($post->media) ? Storage::url($post->media) : '' }}"
                                        alt="Post Image">
                                </a>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col items-center justify-center gap-5">
                                    @if (count($post->comment) > 0)
                                        @livewire('modal-component', ['post_id' => $post->id])
                                    @endif

                                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                            class="px-4 py-2 text-sm font-medium leading-5 text-white bg-teal-700 rounded-lg hover:bg-teal-600 focus:outline-none focus:shadow-outline-teal">
                                            Delete Post
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <p>
                            No posts found.
                        </p>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $posts->links() }}
    </x-card>
</x-app-layout>
