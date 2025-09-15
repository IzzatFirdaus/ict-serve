@props([
    'type' => 'info',
    'dismissible' => false,
])

<x-myds.alert 
    :variant="$type" 
    :dismissible="$dismissible"
    {{ $attributes }}
>
    {{ $slot }}
</x-myds.alert>