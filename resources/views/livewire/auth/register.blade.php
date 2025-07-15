<x-layouts.app>
    <div class="flex justify-center items-center min-h-screen">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Register</h2>

            <form wire:submit.prevent="register">
                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
                    <input type="text" wire:model.defer="name" id="name" required autofocus
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" wire:model.defer="email" id="email" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label for="id_role" class="block text-gray-700 font-medium mb-1">Role</label>
                    <select wire:model.defer="id_role" id="id_role"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                        <option value="" disabled>Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id_role }}">{{ $role->name_role }}</option>
                        @endforeach
                    </select>
                    @error('id_role') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                    <input type="password" wire:model.defer="password" id="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                    @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                    <input type="password" wire:model.defer="password_confirmation" id="password_confirmation" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                        Register
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                    Already registered? Login
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
