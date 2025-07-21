{{-- resources/views/livewire/member/create.blade.php --}}
<form wire:submit.prevent="storeMember" class="w-full max-w-2xl mx-auto">
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
    {{-- Livewire doesn't automatically submit on a form, the button handles it --}}
    {{-- You can remove the wire:submit.prevent="storeMember" on the form tag and rely on the button if you prefer --}}
</form>