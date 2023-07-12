<x-app-layout>
    <div class="container mx-auto">


        <form method="POST" action="{{ route('storePost') }}" enctype="multipart/form-data">
            @csrf

            <!-- Description -->
            <div>
                <x-input-label for="description" :value="__('Description')" />
                <x-textarea id="description" class="block mt-1 w-full" name="description" autofocus
                autocomplete="description">
                    {{ old('description') }}
                </x-textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Media -->
            <div class="mt-4">
                <x-input-label for="media" :value="__('Media')" />

                <x-text-input id="media" class="block mt-1 w-full" type="file" name="media" autocomplete="media" />

                <x-input-error :messages="$errors->get('media')" class="mt-2" />
            </div>

            <!-- Visibility -->
            <div class="mt-4">
                <x-input-label for="visibility" :value="__('Visibility')" />

                <select id="visibility" name="visibility" :value="old('visibility')" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Select Visibility</option>
                    <option value='0'>Public</option>
                    <option value='1'>Only my friends</option>
                </select>
                <x-input-error :messages="$errors->get('visibility')" class="mt-2" />
            </div>

            <div class="flex items-center justify-center mt-4">

                <x-primary-button class="ml-4">
                    {{ __('Post') }}
                </x-primary-button>
            </div>

        </form>
    </div>
</x-app-layout>