{{--
  MYDS Error Message for ICTServe (iServe)
  - Accessible, clear, semantic token, ARIA role, citizen-centric, follows MYDS colour.
  - Props:
      field: string|null (validation field name)
      class: string|null (additional classes)
--}}
@props([
    'field' => null,
    'class' => '',
])

@if ($field)
    @error($field)
        <p {{ $attributes->merge(['class' => 'mt-1 text-xs txt-danger font-inter '.$class]) }} role="alert">
            {{ $message }}
        </p>
    @enderror
@else
    <p {{ $attributes->merge(['class' => 'mt-1 text-xs txt-danger font-inter '.$class]) }} role="alert">
        {{ $slot }}
    </p>
@endif
