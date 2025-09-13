<div class="max-w-md mx-auto mt-10 p-8 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
    <form wire:submit.prevent="register">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium">Name</label>
            <input type="text" id="name" wire:model="name" class="w-full border rounded px-3 py-2" required autofocus>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" id="email" wire:model="email" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium">Password</label>
            <input type="password" id="password" wire:model="password" class="w-full border rounded px-3 py-2" required>
        </div>
        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Register</button>
    </form>
</div>
