<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelas > Daftar Kelas') }}
        </h2> --}}
        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M10 2a3 3 0 0 0-3 3v1H5a3 3 0 0 0-3 3v2.382l1.447.723.005.003.027.013.12.056c.108.05.272.123.486.212.429.177 1.056.416 1.834.655C7.481 13.524 9.63 14 12 14c2.372 0 4.52-.475 6.08-.956.78-.24 1.406-.478 1.835-.655a14.028 14.028 0 0 0 .606-.268l.027-.013.005-.002L22 11.381V9a3 3 0 0 0-3-3h-2V5a3 3 0 0 0-3-3h-4Zm5 4V5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1h6Zm6.447 7.894.553-.276V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-5.382l.553.276.002.002.004.002.013.006.041.02.151.07c.13.06.318.144.557.242.478.198 1.163.46 2.01.72C7.019 15.476 9.37 16 12 16c2.628 0 4.98-.525 6.67-1.044a22.95 22.95 0 0 0 2.01-.72 15.994 15.994 0 0 0 .707-.312l.041-.02.013-.006.004-.002.001-.001-.431-.866.432.865ZM12 10a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
                            clip-rule="evenodd" />
                    </svg>
                    &nbsp;&nbsp;Kelas
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                    <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('academy_admin.classes.index') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Daftar Kelas</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-3">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-add-button href="{{ route('academy_admin.classes.create') }}">
                        + Tambah
                    </x-add-button>
                    <x-table id="table_id" class="ui celled table">
                        <x-slot name="header">
                            <x-table-column class="border-white dark:border-black text-white dark:text-black">#</x-table-column>
                            <x-table-column class="border-white dark:border-black text-white dark:text-black">Judul</x-table-column>
                            <x-table-column class="border-white dark:border-black text-white dark:text-black">Kategori</x-table-column>
                            <x-table-column class="border-white dark:border-black text-white dark:text-black">Periode</x-table-column>
                            <x-table-column class="border-white dark:border-black text-white dark:text-black">Mulai</x-table-column>
                            <x-table-column class="border-white dark:border-black text-white dark:text-black">Sampai</x-table-column>
                            <x-table-column class="border-white dark:border-black text-white dark:text-black">Aksi</x-table-column>
                        </x-slot>
                        {{-- {{ dd($classes) }} --}}
                        @forelse ($classes as $index => $item)
                            <?php // var_dump($item); ?>
                            <tr>
                                <x-table-column class="text-center">{{ $index + 1 }}</x-table-column>
                                <x-table-column>{{ $item->class_title }}</x-table-column>
                                <x-table-column>{{ $item->class_category }}</x-table-column>
                                <x-table-column>{{ $item->class_period }}</x-table-column>
                                <x-table-column>{{ $item->start_eff_date }}</x-table-column>
                                <x-table-column>{{ $item->end_eff_date }}</x-table-column>
                                <x-table-column width="20%">
                                    <div class="hidden md:flex flex-row items-center gap-x-3">
                                        {{-- {{var_dump($item)}}S --}}
                                        <x-edit-button href="{{ route('academy_admin.classes.edit', $item->id) }}">
                                            Ubah
                                        </x-edit-button>
                                        <x-delete-button class="delete" data-id="{{ $item->id }}">
                                            Hapus
                                        </x-delete-button>
                                    </div>
                                </x-table-column>
                            </tr>
                        @empty
                            {{-- <tr>
                                <x-table-column class="text-center" colspan="100%">No data.</x-table-column>
                            </tr> --}}
                        @endforelse
                    </x-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function() {
        $('#table_id').DataTable({
            language: {
                // info: 'Showing page _PAGE_ of _PAGES_',
                // infoEmpty: 'No records available',
                // infoFiltered: '(filtered from _MAX_ total records)',
                // lengthMenu: 'Display _MENU_ records per page',
                // zeroRecords: 'Nothing found - sorry'
            }
        });
    });
    $(document).off('click', '.delete').on('click', '.delete', function() {
        // console.log($(this).data('id'))
        var classes_id = $(this).data('id');
        Swal.fire({
            icon: "question",
            title: "Hapus",
            text: "Yakin untuk menghapus?",
            showConfirmButton: true,
            confirmButtonText: "Ya",
            showDenyButton: true,
            denyButtonText: "Tidak",
            allowOutsideClick: false
        })
        .then((response) => {
            if (response.isConfirmed) {
                var url = '{{ route("academy_admin.classes.destroy", ":id") }}';
                url = url.replace(':id', classes_id);
                $.ajax({
                    async: false,
                    type: "DELETE",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "method": "POST"
                    },
                    dataType: "JSON",
                    success: function(response) {
                        // console.log(response);
                        if(response > 0){
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: "Yakin untuk menghapus?",
                                showConfirmButton: true,
                                confirmButtonText: "OK",
                            })
                            .then((feedback)=>{
                                if(feedback.isConfirmed){
                                    window.location = "{{ route('academy_admin.classes.index') }}";
                                }
                            })
                        }
                    }
                });
            }
        })
    });
</script>
