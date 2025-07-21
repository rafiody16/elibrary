<div>
    <div class="col-md-8 mb-2">
        @if(session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif
    </div>

    <div class="col-md-8">
        <div class="card bg-white shadow-md rounded-lg overflow-hidden">
            <div class="card-header">
                <h2 class="text-lg ml-8 mt-2 font-semibold text-gray-800">Data Members</h2>
                <button wire:click.prevent="addMember"
                    class="inline-flex items-center ml-8 mt-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition duration-200"
                    wire:loading.attr="disabled"
                    wire:target="addMember">   
                    <span wire:loading wire:target="addMember" class="mr-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    Create New Member
                </button>
            </div>
            <div class="card-body">
                <div class="container mx-auto px-4 py-8">
                    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="px-6 py-3 text-left">Photo</th>
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left">Place, Date Of Birth</th>
                                <th class="px-6 py-3 text-left">Address</th>
                                <th class="px-6 py-3 text-left">Phone Number</th>
                                <th class="px-6 py-3 text-left">Job</th>
                                <th class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($members as $m)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-6 py-4">
                                        <img src="{{ asset('storage/' . $m->photo_member) }}" alt="{{ $m->name_member }}" class="w-16 h-16 object-cover">
                                    </td>
                                    <td class="px-6 py-4">{{ $m->name_member }}</td>
                                    <td class="px-6 py-4">{{ $m->place_of_birth }}, {{ $m->date_of_birth }}</td>
                                    <td class="px-6 py-4">{{ $m->address }}</td>
                                    <td class="px-6 py-4">{{ $m->phone_number }}</td>
                                    <td class="px-6 py-4">{{ $m->job }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <button wire:click="editMember({{ $m->id_member }})"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 border border-blue-600 rounded hover:bg-blue-600 hover:text-white transition">
                                                Edit
                                            </button>
                                            <button wire:click="deleteMember({{ $m->id_member }})"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-600 border border-red-600 rounded hover:bg-red-600 hover:text-white transition">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                        Data tidak tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto z-50" wire:click.self="closeModal">
            <div class="flex items-start justify-center min-h-screen pt-12 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full px-4 py-6 sm:px-6" wire:transition>
                    <div class="text-center">
                        <h3 class="text-lg leading-6 font-semibold text-gray-900 mb-4">
                            {{ $id_member ? 'Edit Member' : 'Create New Member' }}
                        </h3>

                        <div class="mt-2 px-4 py-3 text-left">
                            {{-- Include the correct form --}}
                            @if ($id_member)
                                @include('livewire.book.edit')
                            @else
                                @include('livewire.member.create')
                            @endif
                        </div>

                        <div class="flex justify-end mt-6">
                            @if ($id_member)
                                <button wire:click.prevent="updateMember()"
                                    class="px-4 py-2 bg-green-600 text-white text-base font-semibold rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300">
                                    Update
                                </button>
                            @else
                                <button wire:click.prevent="storeMember()"
                                    class="px-4 py-2 bg-blue-600 text-white text-base font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
                                    wire:loading.attr="disabled"
                                    wire:target="storeMember()">
                                    <span wire:loading wire:target="storeMember()" class="mr-2">
                                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                    Save
                                </button>
                            @endif
                            <button wire:click.prevent="closeModal()"
                                class="ml-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>