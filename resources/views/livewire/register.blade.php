<x-myds.card class="max-w-md mx-auto mt-10">
    <h2 class="myds-heading-md text-txt-black-900 mb-6 text-center">Register</h2>
    <form wire:submit.prevent="register">
        <div class="space-y-4">
            <x-myds.input
                type="text"
                label="Name"
                name="name"
                wire:model="name"
                required
                autofocus
            />
            
            <x-myds.input
                type="email"
                label="Email"
                name="email"
                wire:model="email"
                required
            />
            
            <x-myds.input
                type="password"
                label="Password"
                name="password"
                wire:model="password"
                required
            />
        </div>
        
        <div class="mt-6">
            <x-myds.button type="submit" variant="success" class="w-full">
                Register
            </x-myds.button>
        </div>
    </form>
</x-myds.card>
