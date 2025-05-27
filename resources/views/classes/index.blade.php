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
                    <a href="{{ route('classes') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Daftar Kelas</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-3">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto text-gray-900 dark:text-gray-100">
                        <h6 class="text-lg font-semibold leading-tight text-center">Daftar Kelas</h6>
                    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between mb-4">
                        @can('create master kelas')
                        <x-add-button href="{{route('classes.create')}}">
                            + Tambah
                        </x-add-button>
                        @endcan
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" name="classes_kywd" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari data" value="{{ $classes_kywd }}">
                        </div>
                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="detail_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Judul
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jenis
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Mulai
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Sampai
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Jumlah Materi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Keaktifan
                                    </th>
                                    @canany(['edit master kelas', 'delete master kelas'])
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Aksi
                                    </th>
                                    @endcanany
                                    <th scope="col" class="" width="1%">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($classes as $index => $value)
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $index + $classes->firstItem() }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $value->class_title }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $value->category_type }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ date('d/m/Y', strtotime($value->start_eff_date)) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ date('d/m/Y', strtotime($value->end_eff_date)) }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{-- {{ $value->jumlah_materi }} --}}
                                            {{ $value->sum_materi }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($value->is_active == 1)
                                                <span class="text-emerald-600">{{ 'Aktif' }}</span>
                                            @else
                                                <span class="text-rose-600">{{ 'Non-Aktif' }}</span>
                                            @endif
                                        </td>
                                        @canany(['create sesi kelas', 'edit master kelas', 'delete master kelas'])
                                        <td class="px-6 py-4" width="15%">
                                            @if ($value->is_active == 1)
                                                @if ($value->is_released == 0)
                                                <div class="flex flex-column sm:flex-row flex-wrap space-y-2 gap-2 sm:space-y-0 items-center justify-between">
                                                    @can('edit master kelas')
                                                    <button type="button" class="font-medium text-blue-600 dark:text-green-500 hover:underline release" data-id="{{ $value->id }}">Rilis</button>
                                                    @endcan
                                                    @can('create sesi kelas')
                                                    <a type="button" class="font-medium text-blue-400 dark:text-blue-200 hover:underline" href="{{ route('class_sessions.create', $value->id) }}">Sesi</a>
                                                    @endcan
                                                    @can('edit master kelas')
                                                    <a type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="{{ route('classes.edit', $value->id) }}">Edit</a>
                                                    @endcan
                                                    @can('delete master kelas')
                                                    <button type="button" class="font-medium text-red-600 dark:text-red-500 hover:underline delete" data-id="{{ $value->id }}">Hapus</button>
                                                    @endcan
                                                </div>
                                                @else
                                                <div class="text-center">
                                                    <span class="font-medium text-emerald-600">- RELEASED -</span>
                                                </div>
                                                @endif
                                            @else
                                                <div class="flex flex-column sm:flex-row flex-wrap space-y-2 sm:space-y-0 items-center justify-between">
                                                    @can('delete master kelas')
                                                    <button type="button" class="font-medium text-green-400 dark:text-green-200 hover:underline recover" data-id="{{ $value->id }}">Pulihkan</button>
                                                    @endcan
                                                </div>
                                            @endif
                                        </td>
                                        @endcanany
                                        <td>
                                            <button type="button" class="text-white bg-white hover:bg-blue-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onClick="toggleDetail(this)">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="bg-blue-50 class_detail hidden" id="detail_{{$value->id}}">
                                        <td class="p-3" colspan="100%">
                                            <div class="grid grid-cols-3 gap-2">
                                                <div class="relative overflow-x-auto">
                                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        <tr>
                                                            <td>
                                                                Deskripsi
                                                            </td>
                                                            <td>:</td>
                                                            <td>
                                                                {{ $value->class_desc }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Trainer
                                                            </td>
                                                            <td>:</td>
                                                            <td>
                                                                {{ $value->trainers }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-span-2 grid grid-cols-1 gap-2">
                                                    @php
                                                        $studies = explode(',', $value->studies);
                                                        $tests = explode(',', $value->tests);
                                                    @endphp
                                                    @if ($studies[0] != '')
                                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                            <tr>
                                                                <th scope="col" class="px-6 py-3 text-center">
                                                                    Materi
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                                <td class="px-6 py-4">
                                                                    <ol class="ps-5 mt-2 space-y-1 list-decimal list-inside">
                                                                    <div class="grid lg:grid-cols-2 sm:grid-cols-3 gap-2">
                                                                        @if (substr($value->class_category, 0, 3) == 'Pre')
                                                                        @foreach($tests as $index => $test)
                                                                            <li>{{$test}}</li>
                                                                        @endforeach
                                                                        @else
                                                                        @foreach($studies as $index => $study)
                                                                            <li>{{$study}}</li>
                                                                        @endforeach
                                                                        @endif
                                                                    </div>
                                                                    </ol>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="row_no_data">
                                        <td class="text-center py-1" colspan="100%"><span class="text-red-500">Tidak ada data.</span></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        {{ $classes->links(); }}
                    </div>
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
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "{{ route('classes.delete') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": classes_id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        // console.log(response);
                        if(response > 0){
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
                                    window.location = "{{ route('classes') }}";
                                }
                            })
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                text: "Gagal menghapus data. Silahkan coba beberapa saat lagi.",
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
        var classes_id = $(this).data('id');
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
                    url: "{{ route('classes.recover') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": classes_id
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
                                    window.location = "{{ route('classes') }}";
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
    $('body').off('keypress', '[name="classes_kywd"]').on('keypress', '[name="classes_kywd"]', function(e){
        if(e.which == 13) {
            var classes_kywd = $(this).val();
            var url = "{{ route('classes', ['classes_kywd' => ':classes_kywd']) }}";
            url = url.replace(':classes_kywd', classes_kywd);
            window.location.href = url;
        }
    });
    $(document).off('click', '.release').on('click', '.release', function(){
        var classId = $(this).data('id');
        var class_type = $(this).closest('tr').find('td:eq(1)').html().trim();
        var jumlah_materi = $(this).closest('tr').find('td:eq(4)').html().trim();
        if(class_type == 'Training Class' && jumlah_materi == 0){
            Swal.fire({
                icon: "warning",
                title: "Peringatan!",
                text: "Belum dapat rilis kelas karena tidak ada materi. Isi materi terlebih dahulu di menu Sesi.",
                confirmButtonText: "OK",
                allowOutsideClick: false
            })
        }else{
            Swal.fire({
                icon: "question",
                title: "Rilis?",
                text: "Rilis kelas? Kelas yang dirilis tidak dapat diedit lagi",
                showDenyButton: true,
                denyButtonText: "Tidak",
                confirmButtonText: "Ya, Rilis",
                allowOutsideClick: false
            })
            .then((feedback)=>{
                if(feedback.isConfirmed){
                    $.ajax({
                        type: "POST",
                        url: "{{ route('classes.release') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            classId: classId
                        },
                        dataType: "JSON",
                        success: function (response) {
                            // console.log(response);
                            if(response > 0){
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil!",
                                    text: "Berhasil merilis kelas.",
                                    showConfirmButton: true,
                                    confirmButtonText: "OK",
                                    allowOutsideClick: false
                                })
                                .then((feedback)=>{
                                    if(feedback.isConfirmed){
                                        window.location = "{{ route('classes') }}";
                                    }
                                })
                            }else{
                                Swal.fire({
                                    icon: "error",
                                    title: "Gagal!",
                                    text: "Gagal merilis data. Silahkan coba beberapa saat lagi.",
                                    showConfirmButton: true,
                                    confirmButtonText: "OK",
                                    allowOutsideClick: false
                                })
                            }
                        }
                    });
                }
            })
        }
    })
</script>
