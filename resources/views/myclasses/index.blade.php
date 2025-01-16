<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelas > kelasku') }}
        </h2> --}}
        <!-- Breadcrumb -->
        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8 12.732A1.99 1.99 0 0 1 7 13H3v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2h-2a4 4 0 0 1-4-4v-2.268ZM7 11V7.054a2 2 0 0 0-1.059.644l-2.46 2.87A2 2 0 0 0 3.2 11H7Z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M14 3.054V7h-3.8c.074-.154.168-.3.282-.432l2.46-2.87A2 2 0 0 1 14 3.054ZM16 3v4a2 2 0 0 1-2 2h-4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-3Z" clip-rule="evenodd"/>
                    </svg>
                    &nbsp;&nbsp;Kelas Saya
                    </a>
                </li>
                {{-- <li>
                    <div class="flex items-center">
                    <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('myclasses') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">kelasku</a>
                    </div>
                </li> --}}
            </ol>
        </nav>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-3">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto text-gray-900 dark:text-gray-100">
                    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between mb-4">
                        @can('create kelasku')
                        <x-add-button href="{{route('myclasses.create')}}">
                            + Tambah
                        </x-add-button>
                        @endcan
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" name="myclasses_kywd" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari data" value="{{ $myclasses_kywd }}">
                        </div>
                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg grid lg:grid-cols-3 sm:grid-cols-1 gap-4 p-3">
                        @forelse ($myclasses as $index => $myclass)
                            @if ($myclass->all_test > 0)
                                @if (ceil(($myclass->test_done/$myclass->all_test)*100) == 100)
                                    @switch($myclass->enrollment_status)
                                        @case('FAILED')
                                            <div class="max-w-sm bg-red-50 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                            @break
                                        @case('PASSED')
                                            <div class="max-w-sm bg-green-50 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                            @break
                                        @default
                                        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                    @endswitch
                                @else
                                <div class="max-w-sm bg-white-50 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                @endif
                            @else
                            <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            @endif
                                <div class="flex flex-col h-full p-5">
                                    <div class="grid grid-cols-4 gap-1">
                                        <div class="col-span-3">
                                            @if ($myclass->is_released == 1)
                                            <a href="{{route('classrooms', $myclass->class_id)}}">
                                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white hover:underline">{{$myclass->class_title}}</h5>
                                            </a>
                                            @else
                                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-500 dark:text-white">{{$myclass->class_title}}</h5>
                                            <span>(Belum rilis)</span>
                                            @endif
                                        </div>
                                        <div>
                                            @if ($myclass->all_test > 0)
                                                @if (ceil(($myclass->test_done/$myclass->all_test)*100) == 100)
                                                    @switch($myclass->enrollment_status)
                                                        @case('FAILED')
                                                            <button type="button" class="bg-red-500 p-1 px-2 border rounded-lg font-bold text-white">{{$myclass->enrollment_status}}</button>
                                                            @break
                                                        @case('PASSED')
                                                            <button type="button" class="bg-green-500 p-1 px-2 border rounded-lg font-bold text-white">{{$myclass->enrollment_status}}</button>
                                                            @break
                                                        @default

                                                    @endswitch
                                                @endif
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>
                                        </svg> &nbsp;{{date('d/m/Y', strtotime($myclass->start_eff_date))}} - {{date('d/m/Y', strtotime($myclass->end_eff_date))}}
                                    </div>
                                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$myclass->class_desc}}</p>
                                    <div class="mt-auto">
                                        @if ($myclass->is_released == 1)
                                        <div class="grid grid-cols-6 gap-4">
                                            <div class="col-span-1"><span class="float-left">Progress:</span></div>
                                            <div class="col-start-6"><span class="float-right">
                                                {{ ceil(($myclass->test_done/$myclass->all_test)*100) }}%
                                            </span></div>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ceil(($myclass->test_done/$myclass->all_test)*100) }}%"></div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <h6 class="font-bold text-center text-gray-500 col-span-3 text-6xl opacity-20">😢</h6>
                            <h6 class="font-bold text-center text-gray-500 col-span-3 text-4xl opacity-20">Oops!</h6>
                            <h6 class="font-semibold text-center text-gray-500 col-span-3 text-xl opacity-20">Data kelas tidak ditemukan.</h6>
                        @endforelse
                    </div>
                    <div class="mt-2">
                        {{ $myclasses->links(); }}
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
        var myclasses_id = $(this).data('id');
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
                    url: "{{route('myclasses.delete')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": myclasses_id
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
                                    window.location = "{{ route('myclasses') }}";
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
        var myclasses_id = $(this).data('id');
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
                    url: "{{ route('myclasses.recover') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": myclasses_id
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
                                    window.location = "{{ route('myclasses') }}";
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
    $('body').off('keypress', '[name="myclasses_kywd"]').on('keypress', '[name="myclasses_kywd"]', function(e){
        if(e.which == 13) {
            var myclasses_kywd = $(this).val();
            var url = "{{ route('myclasses', ['myclasses_kywd' => ':myclasses_kywd']) }}";
            url = url.replace(':myclasses_kywd', myclasses_kywd);
            window.location.href = url;
        }
    });
</script>
