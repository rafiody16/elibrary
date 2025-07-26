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
                <h2 class="text-lg ml-8 mt-2 font-semibold text-gray-800">Data Loan</h2>
                <button wire:click.prevent="addLoan"
                    class="inline-flex items-center ml-8 mt-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition duration-200"
                    wire:loading.attr="disabled"
                    wire:target="addLoan">   
                    <span wire:loading wire:target="addLoan" class="mr-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    Create New Loan
                </button>
            </div>
            <div class="card-body">
                <div class="container mx-auto px-4 py-8">
                    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="px-6 py-3 text-left">Borrower</th>
                                <th class="px-6 py-3 text-left">Book</th>
                                <th class="px-6 py-3 text-center">Loan Date</th>
                                <th class="px-6 py-3 text-center">Return Date</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($loans as $l)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-6 py-4">{{ $l->member->name_member }}</td>
                                    <td class="px-6 py-4">{{ $l->book->name_book }}</td>
                                    <td class="px-6 py-4">{{ $l->loan_date }}</td>
                                    <td class="px-6 py-4">{{ $l->return_date }}</td>
                                    <td class="px-6 py-4">{{ $l->status }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <button wire:click="editLoan({{ $l->id_loan }})"
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 border border-blue-600 rounded hover:bg-blue-600 hover:text-white transition">
                                            Edit
                                        </button>
                                        <button wire:click="deleteLoan({{ $l->id_loan }})" wire:confirm="Are you sure you want to delete this category?"
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-600 border border-red-600 rounded hover:bg-red-600 hover:text-white transition ml-2">
                                            Delete
                                        </button>
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
        <div class="fixed inset-0 px-10 py-8 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center" wire:transition wire:click.self="closeModal">
            <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white" @click.away="Livewire.emit('closeModal')">
                <div class="text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        {{ $id_loan ? 'Edit Loan' : 'Create New Loan' }}
                    </h3>
                    <div class="mt-2 px-7 py-3">
                        {{-- Include the correct form based on $id_role --}}
                        @if ($id_loan)
                            @include('livewire.loan.edit')
                        @else
                            @include('livewire.loan.create')
                        @endif
                    </div>
                    <div class="items-center px-4 py-3">
                        @if ($id_loan)
                            <button wire:click.prevent="updateLoan()"
                                class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                                Update
                            </button>
                        @else
                            <button wire:click.prevent="storeLoan"
                                    class="px-4 py-2 bg-blue-600 text-white text-base font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
                                    wire:loading.attr="disabled"
                                    wire:target="storeLoan()">
                                <span wire:loading wire:target="storeLoan()" class="mr-2">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                                Save
                            </button>
                        @endif
                        <button wire:click.prevent="closeModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 ml-2">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>