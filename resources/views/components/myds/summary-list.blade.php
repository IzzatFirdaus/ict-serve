<tr {{ $attributes->merge(['class' => 'border-b border-divider']) }}>
  <th
    scope="row"
    class="py-4 px-6 font-inter font-medium text-black-900 dark:text-white whitespace-nowrap"
  >
    {{ $label ?? '' }}
  </th>
  <td class="py-4 px-6 font-inter text-black-700 dark:text-black-300">
    {{ $value ?? '' }}
  </td>
</tr>
