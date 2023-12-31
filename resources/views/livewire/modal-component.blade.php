<div>
    <!-- Button to open the modal -->
    
    <button wire:click="openModal" type="submit"
    class="px-4 py-2 text-sm font-medium leading-5 text-white bg-teal-700 rounded-lg hover:bg-teal-600 focus:outline-none focus:shadow-outline-teal">
        Show Comments
    </button>

    <!-- Modal -->
    @if ($isOpen)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="modal-bg absolute inset-0 bg-gray-900 opacity-50"></div>
            <div class="modal-content bg-white shadow-lg rounded-md p-6 relative w-full mx-auto">
                <!-- Close button -->
                <button wire:click="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Modal content -->
                <h2 class="text-lg font-bold mb-4">Comments</h2>

                @forelse ($comments as $comment)
                    <div class="my-1 flex flex-col justify-center bg-gradient-to-r from-cyan-100 rounded-md p-2">
                        @include('user.partials.user-name-link', ['user' => $comment->user, "class" => "text-xs"])
                        <span class="mx-5 text-sm p-2">{{ $comment->comment }}</span>
                    </div>

                @empty
                @endforelse

            </div>
        </div>
    @endif
</div>
