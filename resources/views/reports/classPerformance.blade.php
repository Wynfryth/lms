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
                    &nbsp;&nbsp;Laporan
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                    <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('reports.classPerformance') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Performa Kelas</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-3">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto text-gray-900 dark:text-gray-100">
                    <h6 class="text-lg font-semibold leading-tight text-center">Performa Kelas</h6>
                    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between mb-4">
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" name="report_kywd" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari data" value="{{ $report_kywd }}">
                        </div>
                        <x-add-button href="{{route('export.classPerformance')}}">
                            Export to Excel
                        </x-add-button>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <x-select-option id="kategori_kelas" name="kategori_kelas">
                                <x-slot name="options">
                                    <option class="disabled" value="null" selected disabled>
                                        Pilih Kategori ...
                                    </option>
                                    @forelse ($classCategory as $index => $item)
                                        <option value="{{ $item->id }}" data-category-type="{{ $item->class_category }}" {{ $class_category == $item->id ? 'selected' : '' }}>
                                            {{ $item->class_category }}
                                        </option>
                                    @empty
                                        {{-- do nothing --}}
                                    @endforelse
                                </x-slot>
                            </x-select-option>
                        </div>
                        <div>
                            <x-text-input id="start_period" datepicker datepicker-autohide datepicker-orientation="bottom right" datepicker-format="dd-mm-yyyy" name="start_period" type="text" class="mt-1 block w-full datepicker" placeholder="Dari..." value="{{ $startPeriod }}" />
                            <x-text-input id="end_period" datepicker datepicker-autohide datepicker-orientation="bottom right" datepicker-format="dd-mm-yyyy" name="end_period" type="text" class="mt-1 block w-full datepicker" placeholder="Sampai..." value="{{ $endPeriod }}" />
                        </div>
                        <div class="text-center">
                            <button type="button" id="report_filter" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 w-full mt-1">Filter</button>
                        </div>
                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="detail_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3" width="25%">
                                        Kelas
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Kategori
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Mulai - Selesai
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    {{-- <th scope="col" class="px-6 py-3">
                                        Sesi
                                    </th> --}}
                                    {{-- <th scope="col" class="px-6 py-3">
                                        Materi
                                    </th> --}}
                                    <th scope="col" class="px-6 py-3">
                                        Peserta
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Gagal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tingkat Kegagalan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Lulus
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tingkat Kelulusan
                                    </th>
                                    <th scope="col" class="px-6 py-3" width="1%">

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($graduationRateResult as $index => $result)
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $index + $graduationRateResult->firstItem() }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $result->class_title }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $result->class_category }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ date('d/m/Y', strtotime($result->start_eff_date)) }} -
                                            {{ date('d/m/Y', strtotime($result->end_eff_date)) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($result->is_released == 1)
                                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 my-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">Released</span>
                                                @if ($result->registered == 0 && $result->ongoing == 0)
                                                    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 my-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">Completed</span>
                                                @else
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 my-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300">Ongoing</span>
                                                @endif
                                            @else
                                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 my-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">Unreleased</span>
                                            @endif
                                        </td>
                                        {{-- <td class="px-6 py-4 text-center">
                                            {{ $result->total_session }}
                                        </td> --}}
                                        {{-- <td class="px-6 py-4 text-center">
                                            {{ $result->total_material }}
                                        </td> --}}
                                        <td class="px-6 py-4 text-center">
                                            {{ $result->total_enrollment }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $result->failed }}
                                        </td>
                                        @if ($result->total_enrollment > 0)
                                            @if (round(($result->failed/$result->total_enrollment)*100) >=50)
                                            <td class="px-6 py-4 text-center bg-red-200 text-red-500">
                                                {{ round(($result->failed/$result->total_enrollment)*100) }} %
                                            </td>
                                            @else
                                            <td class="px-6 py-4 text-center">
                                                {{ round(($result->failed/$result->total_enrollment)*100) }} %
                                            </td>
                                            @endif
                                        @else
                                            <td class="px-6 py-4 text-center">
                                                0 %
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 text-center">
                                            {{ $result->passed }}
                                        </td>
                                        @if ($result->total_enrollment > 0)
                                            @if (round(($result->passed/$result->total_enrollment)*100) >=50)
                                            <td class="px-6 py-4 text-center bg-green-200 text-green-500">
                                                {{ round(($result->passed/$result->total_enrollment)*100) }} %
                                            </td>
                                            @else
                                            <td class="px-6 py-4 text-center">
                                                {{ round(($result->passed/$result->total_enrollment)*100) }} %
                                            </td>
                                            @endif
                                        @else
                                            <td class="px-6 py-4 text-center">
                                                0 %
                                            </td>
                                        @endif
                                        <td class="p-1">
                                            <a type="button" id="export_class_report" href="{{route('export.classPerformanceDetail', ['class_id' => $result->id])}}" class="text-white bg-white hover:bg-blue-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" title="Export excel data kelas">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m4 8h6m-6-4h6m4-8v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z"/>
                                                </svg>
                                            </a>
                                            <button type="button" id="report_detail" class="text-white bg-white hover:bg-blue-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onClick="toggleDetail(this)" title="Detail kelas">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-100 class_detail hidden" id="detail_{{$result->id}}">
                                        <td class="p-3" colspan="100%">
                                            <div class="report_div">

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
                        {{ $graduationRateResult->links(); }}
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
        var studies_id = $(this).data('id');
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
                    url: "{{route('studies.delete')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": studies_id
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
                                    window.location = "{{ route('studies') }}";
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
        var studies_id = $(this).data('id');
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
                    url: "{{ route('studies.recover') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": studies_id
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
                                    window.location = "{{ route('studies') }}";
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
    $(document).off('click', '.detail').on('click', '.detail', function() {
        var studies_id = $(this).data('id');
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
            //         url: "{{ route('studies.recover') }}",
            //         data: {
            //             "_token": "{{ csrf_token() }}",
            //             "id": studies_id
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
            //                         window.location = "{{ route('studies') }}";
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
    $(document).off('click', '#report_detail').on('click', '#report_detail', function(){
        var class_id = $('.class_detail:not(.hidden)').attr('id').split('_')[1];
        largeSkeleton($('.class_detail:not(.hidden)').find('.report_div'));
        var url = "{{route('reports.class_performance_detail', ':class_id')}}".replace(':class_id', class_id);
        $.ajax({
            type: "GET",
            url: url,
            data: {
                "_token": "{{ csrf_token() }}",
            },
            dataType: "JSON",
            success: function (response) {
                // console.log(response);
                var html = `<div class="relative bg-white overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead>
                                        <tr class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <th class="px-6 py-3 text-center">#</th>
                                            <th class="px-6 py-3 text-center">Nama</th>
                                            <th class="px-6 py-3 text-center">Status</th>
                                            <th class="px-6 py-3 text-center">Nilai Kelas</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                $.each(response, function (index, value) {
                    var rowColor = '';
                    switch(value.enrollment_status){
                        case "REGISTERED":
                            rowColor = 'gray';
                        break;
                        case "FAILED":
                            rowColor = 'red';
                        break;
                        case "PASSED":
                            rowColor = 'green';
                        break;
                        case "ON GOING":
                            rowColor = 'yellow';
                        break;
                    }
                    if(value.class_score != null){
                        var classScore = value.class_score;
                    }else{
                        var classScore = 'Belum';
                    }
                    html += `
                    <tr class="bg-`+rowColor+`-50 text-`+rowColor+`-700 dark:bg-`+rowColor+`-800 border-b dark:border-`+rowColor+`-700">
                        <td class="px-6 py-4 text-center">${(parseInt(index)+1)}</td>
                        <td class="px-6 py-4">${value.Employee_name}</td>
                        <td class="px-6 py-4 text-center">${value.enrollment_status}</td>
                        <td class="px-6 py-4 text-center">${classScore}</td>
                    </tr>
                    `;
                });
                html += '</tbody></table></div>';
                $('.class_detail:not(.hidden)').find('.report_div').html(html);
            }
        });
    })

    $(document).off('click', '#report_filter').on('click', '#report_filter', function(){
        var report_kywd = $('[name="report_kywd"]').val();
        var classCategory = $('#kategori_kelas').val();
        var startPeriod = $('#start_period').val();
        var endPeriod = $('#end_period').val();

        filterReport(report_kywd, classCategory, startPeriod, endPeriod);
    })

    $('body').off('keypress', '[name="report_kywd"]').on('keypress', '[name="report_kywd"]', function(e){
        if(e.which == 13) {
            var report_kywd = $('[name="report_kywd"]').val();
            var classCategory = $('#kategori_kelas').val();
            var startPeriod = $('#start_period').val();
            var endPeriod = $('#end_period').val();

            filterReport(report_kywd, classCategory, startPeriod, endPeriod);
        }
    })

    function filterReport(report_kywd, classCategory, startPeriod, endPeriod){
        if(report_kywd == ''){
            report_kywd = 'nokeyword';
        }
        if(classCategory == null){
            classCategory = 'nocat';
        }
        if(startPeriod == ''){
            startPeriod = 'nostart';
        }
        if(endPeriod == ''){
            endPeriod = 'noend';
        }
        if((startPeriod == 'nostart' && endPeriod != 'noend') ||(startPeriod != 'nostart' && endPeriod == 'noend')){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Waktu mulai dan sampai harus lengkap.',
                allowOutsideClick: false
            });
        }else{
            var url = "{{ route('reports.classPerformance', ['report_kywd' => ':report_kywd', 'class_category' => ':class_category', 'startPeriod' => ':startPeriod', 'endPeriod' => ':endPeriod']) }}";
            url = url.replace(':report_kywd', report_kywd);
            url = url.replace(':class_category', classCategory);
            url = url.replace(':startPeriod', startPeriod);
            url = url.replace(':endPeriod', endPeriod);
            window.location.href = url;
        }
    }
</script>
