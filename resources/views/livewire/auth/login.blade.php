<x-layouts.app>
    <div class="flex justify-center items-center min-h-screen">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>

            <form wire:submit.prevent="login">

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" wire:model.defer="email" id="email" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                    <input type="password" wire:model.defer="password" id="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                    @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                        Login
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">
                    Dont have account? Register
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
