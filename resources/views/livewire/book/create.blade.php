<form class="w-full max-w-2xl mx-auto">
    <div class="mb-4">
        <label for="name_book" class="block text-sm font-semibold text-gray-700">Title</label>
        <input id="name_book" type="text" wire:model.defer="name_book"
            placeholder="Input Book Title Here!"
            class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" />
        @error('name_book') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
        <div>
            <label for="author" class="block text-sm font-semibold text-gray-700">Author</label>
            <input id="author" type="text" wire:model.defer="author"
                placeholder="Author Name"
                class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" />
            @error('author') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="publisher" class="block text-sm font-semibold text-gray-700">Publisher</label>
            <input id="publisher" type="text" wire:model.defer="publisher"
                placeholder="Publisher Name"
                class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" />
            @error('publisher') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mb-4">
        <label for="publication_date" class="block text-sm font-semibold text-gray-700">Publish Date</label>
        <input id="publication_date" type="date" wire:model.defer="publication_date"
            class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" />
        @error('publication_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
        <div>
            <label for="stock" class="block text-sm font-semibold text-gray-700">Stock</label>
            <input id="stock" type="number" wire:model.defer="stock"
                class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" />
            @error('stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="isbn" class="block text-sm font-semibold text-gray-700">ISBN</label>
            <input id="isbn" type="text" wire:model.defer="isbn"
                placeholder="ISBN"
                class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" />
            @error('isbn') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mb-4">
        <label for="id_category" class="block text-sm font-semibold text-gray-700">Category</label>
        <select id="id_category" wire:model.defer="id_category"
            class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id_category }}">{{ $category->name_category }}</option>
            @endforeach
        </select>
        @error('id_category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="cover_book" class="block text-sm font-semibold text-gray-700">Cover Book</label>
        <input id="cover_book" type="file" wire:model="cover_book"
            class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" />
        @error('cover_book') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="description" class="block text-sm font-semibold text-gray-700">Description</label>
        <textarea id="description" wire:model.defer="description" rows="3"
            class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500"></textarea>
        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
</form>
