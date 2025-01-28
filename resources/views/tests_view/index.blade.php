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
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 18.5A2.493 2.493 0 0 1 7.51 20H7.5a2.468 2.468 0 0 1-2.4-3.154 2.98 2.98 0 0 1-.85-5.274 2.468 2.468 0 0 1 .92-3.182 2.477 2.477 0 0 1 1.876-3.344 2.5 2.5 0 0 1 3.41-1.856A2.5 2.5 0 0 1 12 5.5m0 13v-13m0 13a2.493 2.493 0 0 0 4.49 1.5h.01a2.468 2.468 0 0 0 2.403-3.154 2.98 2.98 0 0 0 .847-5.274 2.468 2.468 0 0 0-.921-3.182 2.477 2.477 0 0 0-1.875-3.344A2.5 2.5 0 0 0 14.5 3 2.5 2.5 0 0 0 12 5.5m-8 5a2.5 2.5 0 0 1 3.48-2.3m-.28 8.551a3 3 0 0 1-2.953-5.185M20 10.5a2.5 2.5 0 0 0-3.481-2.3m.28 8.551a3 3 0 0 0 2.954-5.185" />
                    </svg>
                    &nbsp;&nbsp;Tes
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                    <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('tests') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Daftar Tes</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-3">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto text-gray-900 dark:text-gray-100">
                    <h6 class="text-lg font-semibold leading-tight text-center">Daftar Tes</h6>
                    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between mb-4">
                        @can('create bank materi')
                        <x-add-button href="{{route('tests.create')}}">
                            + Tambah
                        </x-add-button>
                        @endcan
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" name="tests_kywd" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari data" value="{{ $tests_kywd }}">
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
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Kode
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Kategori
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Untuk Materi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Jumlah Soal
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Total Poin
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Poin Batas Kelulusan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Durasi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Keaktifan
                                    </th>
                                    @canany(['edit bank materi', 'delete bank materi'])
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Aksi
                                    </th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tests as $index => $value)
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $index + $tests->firstItem() }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $value->test_name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $value->test_code }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $value->test_category }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $value->study_material_title }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $value->jumlah_soal }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $value->total_poin }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $value->pass_point }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                if($value->estimated_time != null){
                                                    $total_waktu = explode(':', $value->estimated_time);
                                                    $durasi = '';
                                                    if(intval($total_waktu[0]) > 0 || intval($total_waktu[1]) > 0 || intval($total_waktu[2]) != 0){
                                                        if(intval($total_waktu[0]) != 0){
                                                            $durasi .= intval($total_waktu[0]).' jam ';
                                                        }
                                                        if(intval($total_waktu[1]) != 0){
                                                            $durasi .= intval($total_waktu[1]).' menit ';
                                                        }
                                                        if(intval($total_waktu[2]) != 0){
                                                            $durasi .= intval($total_waktu[2]).' detik ';
                                                        }
                                                    }else{
                                                        $durasi = '-';
                                                    }
                                                }else{
                                                    $durasi = '-';
                                                }
                                            @endphp
                                            {{ $durasi }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($value->is_active == 1)
                                                @if ($value->is_released == 1)
                                                <span class="text-emerald-600">{{ 'Released' }}</span>
                                                @else
                                                <span class="text-emerald-600">{{ 'Aktif' }}</span>
                                                @endif
                                            @else
                                                <span class="text-rose-600">{{ 'Non-Aktif' }}</span>
                                            @endif
                                        </td>
                                        @canany(['edit bank materi', 'delete bank materi'])
                                        <td class="px-6 py-4" width="15%">
                                            @if ($value->is_released == 0)
                                                @if ($value->is_active == 1)
                                                    <div class="flex flex-column sm:flex-row flex-wrap space-y-2 sm:space-y-0 items-center justify-between">
                                                        @can('edit bank materi')
                                                        <button type="button" class="font-medium text-blue-400 dark:text-blue-300 hover:underline release" data-id="{{ $value->id }}">Rilis</button>
                                                        @endcan
                                                        @can('edit bank materi')
                                                        <a type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="{{ route('tests.edit', $value->id) }}">Edit</a>
                                                        @endcan
                                                        @can('delete bank materi')
                                                        <button type="button" class="font-medium text-red-600 dark:text-red-500 hover:underline delete" data-id="{{ $value->id }}">Hapus</button>
                                                        @endcan
                                                        @can('edit bank materi')
                                                        <button type="button" class="font-medium text-emerald-600 dark:text-emerald-500 hover:underline importExcel" data-test="{{$value->id}}" data-modal-target="uploadQuestions-modal" data-modal-toggle="uploadQuestions-modal">Import</button>
                                                        @endcan
                                                    </div>
                                                @else
                                                    <div class="flex flex-column sm:flex-row flex-wrap space-y-2 sm:space-y-0 items-center justify-between">
                                                        @can('delete bank materi')
                                                        <button type="button" class="font-medium text-green-400 dark:text-green-200 hover:underline recover" data-id="{{ $value->id }}">Pulihkan</button>
                                                        @endcan
                                                    </div>
                                                @endif
                                            @else
                                                @can('edit bank materi')
                                                <a type="button" class="font-medium text-emerald-600 dark:text-emerald-500 hover:underline" href="{{ route('export.tests', ['classId' => $value->id]) }}">Export</a>
                                                @endcan
                                            @endif
                                        </td>
                                        @endcanany
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
                        {{ $tests->links(); }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<div id="uploadQuestions-modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="modal_title">
                    Upload Tes
                </h3>
                <button type="button" id="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="uploadQuestions-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div id="modal_body" class="p-4 md:p-5 space-y-4">
                {{-- <form action="{{ route('fileUpload.uploadEnrollments') }}" method="POST" enctype="multipart/form-data"> --}}
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" name="import_test_id" id="file" class="form-control" value="">
                        <label for="file" class="form-label">Choose Excel File</label>
                        <input type="file" name="file" id="file" class="form-control" required>
                    </div>
                    <button type="button" id="importExcel" class="btn btn-primary">Upload</button>
                {{-- </form> --}}
            </div>
            <!-- Modal footer -->
            {{-- <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="studydet-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
                <button data-modal-hide="studydet-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
            </div> --}}
        </div>
    </div>
</div>
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
        var tests_id = $(this).data('id');
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
                    type: "POST",
                    url: "{{route('tests.delete')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": tests_id
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
                                    window.location = "{{ route('tests') }}";
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
        var tests_id = $(this).data('id');
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
                    url: "{{ route('tests.recover') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": tests_id
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
                                    window.location = "{{ route('tests') }}";
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
    $(document).off('click', '.release').on('click', '.release', function(){
        var testId = $(this).data('id');
        var max_point = 0;
        Swal.fire({
            title: 'Rilis Tes',
            html: `
                <span class="font-semibold text-red-500">Perhatian! Tes yang sudah dirilis tidak dapat diedit dan dihapus. Mohon diperiksa dengan seksama. Terima kasih. :)</span>
                <div id="div_release" class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Pertanyaan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Jawaban
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nilai
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-4" colspan="100%"></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="font-bold text-center p-2 text-lg" colspan="3">TOTAL</td>
                                <td id="total_points" class="font-bold text-green-500 text-center text-lg"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <form id="userForm" class="w-full">
                    <div>
                        <label for="pass_point" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nilai Batas Kelulusan:</label>
                        <input type="text" id="pass_point" name="pass_point" class="swal2-input border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-0" placeholder="Nilai batas kelulusan..." required>
                    </div>
                </form>
            `,
            showDenyButton: true,
            denyButtonText: 'Batal',
            confirmButtonText: 'Rilis',
            allowOutsideClick: false,
            width: '80%',
            preConfirm: () => {
                const pass_point = document.getElementById('pass_point').value;
                if (!pass_point) {
                    Swal.showValidationMessage('Mohon isi nilai minimum dari Tes');
                    return false;
                }else{
                    if(parseInt(pass_point) > parseInt(max_point)){
                        Swal.showValidationMessage('Nilai minimum tidak boleh lebih dari nilai maksimum.');
                        return false;
                    }else{
                        return { pass_point };
                    }
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                var pass_point = result.value.pass_point;
                $.ajax({
                    type: "POST",
                    url: "{{route('tests.release')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        pass_point: result.value.pass_point,
                        testId: testId
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if(response == 1){
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Berhasil rilis tes.',
                                allowOutsideClick: false,
                            })
                            .then((result2)=>{
                                if(result2.isConfirmed){
                                    window.location.reload();
                                }
                            })
                        }
                    }
                });
            }
        });
        smallSkeleton($('#div_release table tbody tr td'));
        var url = "{{route('tests.getTestDetail', ':testId')}}";
        url = url.replace(':testId', testId);
        $.ajax({
            type: "GET",
            url: url,
            // data: "data",
            dataType: "JSON",
            success: function (response) {
                var questions = response[0].questions.split('|');
                var points = response[0].points.split('|');
                var correct_answers = response[0].correct_answers.split('|');
                var tbody = '';
                for(var keys in questions){
                    tbody += `
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td class="text-center font-semibold">`+(parseInt(keys)+1)+`</td>
                            <td>`+questions[keys]+`</td>
                            <td>`+correct_answers[keys]+`</td>
                            <td class="text-center">`+points[keys]+`</td>
                        </tr>
                    `;
                }
                $('#div_release table tbody').html(tbody);
                $('#div_release td#total_points').html(response[0].max_point);
                max_point = response[0].max_point;
            }
        });
    })
    $(document).off('click', '.detail').on('click', '.detail', function() {
        var tests_id = $(this).data('id');
        Swal.fire({
            title: "Detail",
            text: "Nanti di sini ada detail dari kompilasi materi",
            showConfirmButton: true,
            confirmButtonText: "Ya",
            // showDenyButton: true,
            // denyButtonText: "Tidak",
            allowOutsideClick: false
        })
        .then((response) => {
            // if (response.isConfirmed) {
            //     $.ajax({
            //         async: false,
            //         type: "POST",
            //         url: "{{ route('tests.recover') }}",
            //         data: {
            //             "_token": "{{ csrf_token() }}",
            //             "id": tests_id
            //         },
            //         dataType: "JSON",
            //         success: function(response) {
            //             // console.log(response);
            //             if(response > 0){
            //                 Swal.fire({
            //                     icon: "success",
            //                     title: "Berhasil!",
            //                     text: "Berhasil memulihkan data.",
            //                     showConfirmButton: true,
            //                     confirmButtonText: "OK",
            //                     allowOutsideClick: false
            //                 })
            //                 .then((feedback)=>{
            //                     if(feedback.isConfirmed){
            //                         window.location = "{{ route('tests') }}";
            //                     }
            //                 })
            //             }else{
            //                 Swal.fire({
            //                     icon: "error",
            //                     title: "Gagal!",
            //                     text: "Gagal memulihkan data. Silahkan coba beberapa saat lagi.",
            //                     showConfirmButton: true,
            //                     confirmButtonText: "OK",
            //                     allowOutsideClick: false
            //                 })
            //             }
            //         }
            //     });
            // }
        })
    });
    $('body').off('keypress', '[name="tests_kywd"]').on('keypress', '[name="tests_kywd"]', function(e){
        if(e.which == 13) {
            var tests_kywd = $(this).val();
            var url = "{{ route('tests', ['tests_kywd' => ':tests_kywd']) }}";
            url = url.replace(':tests_kywd', tests_kywd);
            window.location.href = url;
        }
    });
    $(document).off('click', '.importExcel').on('click', '.importExcel', function(){
        $('[name="import_test_id"]').val($(this).data('test'));
    });
    $(document).off('click', '#importExcel').on('click', '#importExcel', function(){
        let formData = new FormData();
        formData.append('testId', $('[name="import_test_id"]').val());
        formData.append('file', $('[name="file"]')[0].files[0]);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // Add the CSRF token

        $.ajax({
            type: "POST",
            url: "{{route('fileUpload.uploadQuestions')}}",
            data: formData,
            contentType: false,
            processData: false,
            // dataType: "dataType",
            success: function (response) {
                if(response.importedQuestions > 0){
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: "Berhasil memasukkan " + response.importedQuestions + " soal. Silahkan cek pada menu Tes -> Bank Pertanyaan Tes.",
                        allowOutsideClick: false
                    })
                    .then((feedback) => {
                        if(feedback.isConfirmed){
                            window.location.reload();
                        }
                    })
                }
            },
            error: function(xhr){
                // console.log(JSON.parse(xhr.responseText).errors[0]);
                Swal.fire({
                    icon: "error",
                    title: "Perhatian",
                    text: JSON.parse(xhr.responseText).errors[0],
                    allowOutsideClick: false
                })
            }
        });
    })
</script>
