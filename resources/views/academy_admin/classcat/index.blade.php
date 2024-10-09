<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelas > Kategori Kelas') }}
        </h2> --}}
        <!-- Breadcrumb -->
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
                    <a href="{{ route('academy_admin.classcat.index') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Kategori Kelas</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-3">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto text-gray-900 dark:text-gray-100">
                    {{-- {{ Auth::user()->roles->pluck('name') }} --}}
                    <x-add-button href="{{ route('academy_admin.classcat.create') }}">
                        + Tambah
                    </x-add-button>
                    <table id="table_id" class="table-auto">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">#</th>
                                <th class="whitespace-nowrap">Nama</th>
                                <th class="whitespace-nowrap">Deskripsi</th>
                                <th class="whitespace-nowrap" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($classcat as $index => $item)
                                @php
                                    if($item->is_active == 1){
                                        $row_color = 'bg-white dark:bg-gray-800';
                                    }else{
                                        $row_color = 'bg-zinc-300 dark:bg-white';
                                    }
                                @endphp
                                <tr>
                                    <td class="whitespace-nowrap text-center {{$row_color}}">{{ $index + 1 }}</td>
                                    <td class="whitespace-nowrap {{$row_color}}">{{ $item->class_category }}</td>
                                    <td class="whitespace-nowrap {{$row_color}}">{{ $item->desc }}</td>
                                    <td class="whitespace-nowrap {{$row_color}}">
                                        <div class="md:flex flex-row items-center gap-x-3">
                                            @if ($item->is_active == 1)
                                                <x-edit-button class="mx-auto" href="{{ route('academy_admin.classcat.edit', $item->id) }}">
                                                    Ubah
                                                </x-edit-button>
                                                <x-delete-button class="mx-auto delete" data-id="{{ $item->id }}">
                                                    Hapus
                                                </x-delete-button>
                                            @else
                                                <x-recover-button class="mx-auto recover" data-id="{{ $item->id; }}">
                                                    Pulihkan
                                                </x-recover-button>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                {{-- <tr>
                                    <x-table-column class="text-center" colspan="100%">No data.</x-table-column>
                                </tr> --}}
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@if (session('status'))
<script>
    const Toast =   Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                        });
                        Toast.fire({
                        icon: "success",
                        title: "{{session('status_message')}}"
                    });
</script>
@endif
<script>
    $(document).ready(function() {
        $('#table_id').DataTable({
            scrollX: true,
            language: {
                "emptyTable": "Tidak ada data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Tampilkan _MENU_ data",
                "loadingRecords": "Memuat...",
                "processing": "",
                "search": "Cari:",
                "zeroRecords": "Tidak ada data yang cocok",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": ">",
                    "previous": "<"
                },
                "aria": {
                    "orderable": "Order by this column",
                    "orderableReverse": "Reverse order this column"
                }
            }
        });
    });
    $(document).off('click', '.delete').on('click', '.delete', function() {
        // console.log($(this).data('id'))
        var classcat_id = $(this).data('id');
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
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "{{route('academy_admin.classcat.delete')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": classcat_id
                    },
                    dataType: "JSON",
                    success: function (response) {
                        // console.log(response);
                        if(response != 'failed to delete'){
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: "Berhasil menghapus data.",
                                showConfirmButton: true,
                                confirmButtonText: "OK",
                                allowOutsideClick: false
                            })
                            .then((feedback)=>{
                                if(feedback.isConfirmed){
                                    window.location = "{{ route('academy_admin.classcat.index') }}";
                                }
                            })
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                text: "Gagal menghapus data.",
                                showConfirmButton: true,
                                confirmButtonText: "OK",
                                allowOutsideClick: false
                            })
                        }
                    }
                });
            }
        })
    });

    $(document).off('click', '.recover').on('click', '.recover', function() {
        var classcat_id = $(this).data('id');
        Swal.fire({
            icon: "question",
            title: "Pulihkan",
            text: "Yakin untuk memulihkan data?",
            showConfirmButton: true,
            confirmButtonText: "Ya",
            showDenyButton: true,
            denyButtonText: "Tidak",
            allowOutsideClick: false
        })
        .then((response) => {
            if (response.isConfirmed) {
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "{{ route('academy_admin.classcat.recover') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": classcat_id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        // console.log(response);
                        if(response > 0){
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: "Berhasil memulihkan data.",
                                showConfirmButton: true,
                                confirmButtonText: "OK",
                                allowOutsideClick: false
                            })
                            .then((feedback)=>{
                                if(feedback.isConfirmed){
                                    window.location = "{{ route('academy_admin.classcat.index') }}";
                                }
                            })
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                text: "Gagal memulihkan data. Silahkan coba beberapa saat lagi.",
                                showConfirmButton: true,
                                confirmButtonText: "OK",
                                allowOutsideClick: false
                            })
                        }
                    }
                });
            }
        })
    });
</script>
