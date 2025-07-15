<form>
    <div class="mb-4">
        <label for="name_category" class="block text-gray-700 text-sm font-bold mb-2 text-left">Category Name:</label>
        <input type="text" id="name_category" wire:model.defer="name_category"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        @error('name_category') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="description" class="block text-gray-700 text-sm font-bold mb-2 text-left">Description:</label>
        <textarea id="description" wire:model.defer="description" rows="3"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        @error('description') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
    </div>
</form>