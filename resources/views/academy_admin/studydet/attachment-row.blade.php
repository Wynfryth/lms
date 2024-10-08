<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white index_row">

    </th>
    <td class="px-6 py-4">
        <x-text-input id="nama_file" name="nama_file" type="text" class="mt-1 block lg:w-full sm:w-16" placeholder="Nama File..." value="{{ old('nama_file') }}"/>
    </td>
    <td class="px-6 py-4 flex flex-row items-center attachment_row">
        <x-recover-button href="#" class="upload_file">File</x-recover-button>
        <x-recover-button href="#" class="upload_link">Link</x-recover-button>
    </td>
    <td class="px-6 py-4">
        <x-text-input id="durasi" name="durasi" type="text" class="mt-1 block lg:w-full sm:w-8 timepicker" placeholder="Durasi..." value="{{ old('durasi') }}"/>
    </td>
    <td class="px-6 py-4">
        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline me-2 hidden edit_attachment">Edit</a>
        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline delete_attachment">Hapus</a>
    </td>
</tr>
