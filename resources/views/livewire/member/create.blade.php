{{-- resources/views/livewire/member/create.blade.php --}}
<form wire:submit.prevent="storeMember" enctype="multipart/form-data"class="w-full max-w-2xl mx-auto">
    <div class="mb-4">
        <label for="name_member" class="block text-sm font-semibold text-gray-700">Fullname</label>
        <input id="name_member" type="text" wire:model.defer="name_member"
            placeholder="Input Fullname Here!"
            class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" />
        @error('name_member') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
        <div>
            <label for="place_of_birth" class="block text-sm font-semibold text-gray-700">Place Of Birth</label>
            <input id="place_of_birth" type="text" wire:model.defer="place_of_birth"
                placeholder="Place of Birth"
                class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" />
            @error('place_of_birth') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="date_of_birth" class="block text-sm font-semibold text-gray-700">Date Of Birth</label>
            <input id="date_of_birth" type="date" wire:model.defer="date_of_birth"
                class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" />
            @error('date_of_birth') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mb-4">
        <label for="phone_number" class="block text-sm font-semibold text-gray-700">Phone Number</label>
        <input id="phone_number" type="text" wire:model.defer="phone_number"
            class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" 
            placeholder="Input your phone number here!"/>
        @error('phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="address" class="block text-sm font-semibold text-gray-700">Address</label>
        <input id="address" type="text" wire:model.defer="address"
            class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" 
            placeholder="Input your address here!"/>
        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="job" class="block text-sm font-semibold text-gray-700">Job</label>
        <input id="job" type="text" wire:model.defer="job"
            class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" 
            placeholder="Input your job here!"/>
        @error('job') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="photo_member" class="block text-sm font-semibold text-gray-700">Photo Member</label>
        <input id="photo_member" type="file" wire:model="photo_member"
            class="mt-1 w-full bg-gray-200 text-gray-700 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-500" />
        @error('photo_member') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    
    <div class="flex justify-end mt-6">
        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white text-base font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
            wire:loading.attr="disabled"
            wire:target="storeMember">
            <span wire:loading wire:target="storeMember" class="mr-2">
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
            Save
        </button>
    </div>
</form>