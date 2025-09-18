<button {{ $attributes->merge(['type' => 'button', 'class' => 'myds-button myds-button-secondary']) }}>
    {{ $slot }}
</button>
