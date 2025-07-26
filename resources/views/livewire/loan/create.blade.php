<form class="w-full max-w-2xl mx-auto">
    <div class="mb-4">
        <label for="id_member" class="block text-sm font-semibold text-gray-700">Member</label>
        <select id="id_member" wire:model.defer="id_member"
            class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500">
            <option value="">Select Member</option>
            @foreach($members as $member)
                <option value="{{ $member->id_member }}">{{ $member->name_member }}</option>
            @endforeach
        </select>
        @error('id_member') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="id_book" class="block text-sm font-semibold text-gray-700">Book</label>
        <select id="id_book" wire:model.defer="id_book"
            class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500">
            <option value="">Select Book</option>
            @foreach($books as $book)
                <option value="{{ $book->id_book }}">{{ $book->name_book }}</option>
            @endforeach
        </select>
        @error('id_book') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="loan_date" class="block text-sm font-semibold text-gray-700">Loan Date</label>
        <input id="loan_date" type="date" wire:model.defer="loan_date"
            class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" 
            placeholder="Input your phone number here!"/>
        @error('loan_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    
</form>