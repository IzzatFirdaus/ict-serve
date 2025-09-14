<button {{ $attributes->merge(['type' => 'submit', 'class' => 'myds-button myds-button-primary']) }}>
    {{ $slot }}
</button>
