<tr {{ $attributes->merge(['class' => 'border-b otl-divider']) }}>
    <th scope="row" class="py-4 px-6 font-medium txt-black-900 whitespace-nowrap">
        {{ $label ?? '' }}
    </th>
    <td class="py-4 px-6 txt-black-700">
        {{ $value ?? '' }}
    </td>
</tr>
