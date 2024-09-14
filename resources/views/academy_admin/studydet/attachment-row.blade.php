<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
        1
    </th>
    <td class="px-6 py-4">
        <x-text-input id="nama_file" name="nama_file" type="text" class="mt-1 block w-full" value="{{ old('nama_file') }}"/>
    </td>
    <td class="px-6 py-4">
        <x-recover-button href="#" class="mx-auto">File</x-recover-button>
        <x-recover-button href="#" class="mx-auto">Link</x-recover-button>
    </td>
    <td class="px-6 py-4">
        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
    </td>
</tr>
