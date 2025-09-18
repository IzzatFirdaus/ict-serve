<button {{ $attributes->merge(['type' => 'submit', 'class' => 'myds-button myds-button-danger']) }}>
    {{ $slot }}
</button>
