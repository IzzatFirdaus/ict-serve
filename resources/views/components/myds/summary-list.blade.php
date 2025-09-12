<tr {{ $attributes->merge(['class' => 'border-b border-otl-divider']) }}>
    <th scope="row" class="py-4 px-6 font-medium text-txt-black-900 whitespace-nowrap">
        {{ $label ?? '' }}
    </th>
    <td class="py-4 px-6 text-txt-black-700">
        {{ $value ?? '' }}
    </td>
</tr>
