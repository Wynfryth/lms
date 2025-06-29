<x-app-layout>
    <x-slot name="header">
        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z" clip-rule="evenodd"/>
                    </svg>
                    &nbsp;&nbsp;Peserta
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                    <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('participants') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Peserta Terdaftar</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-3">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto text-gray-900 dark:text-gray-100">
                    <h6 class="text-lg font-semibold leading-tight text-center">Peserta Terdaftar</h6>
                    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between mb-4">
                        @can('create peserta')
                        <x-add-button href="{{route('participants.create')}}">
                            + Tambah
                        </x-add-button>
                        @endcan
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" id="table-search" name="participants_kywd" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari pegawai" value="{{ $participants_kywd }}">
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
                                        NIP
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Organisasi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Jumlah Kelas
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Aksi
                                    </th>
                                    <th scope="col" class="" width="1%">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($participants as $index => $value)
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $index + $participants->firstItem() }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $value->emp_nip }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $value->Employee_name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $value->Organization }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $value->jumlah_kelas }}
                                        </td>
                                        <td class="px-6 py-4">

                                        </td>
                                        <td>
                                            <button type="button" class="text-white bg-white hover:bg-blue-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onClick="toggleDetail(this)">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-400 class_detail hidden" id="detail_{{$value->emp_nip}}">
                                        <td class="p-3" colspan="100%">
                                            <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-2">
                                                <div class="relative overflow-x-auto">
                                                    <table class="w-full text-sm text-left rtl:text-right text-white dark:text-gray-400">
                                                        <tr>
                                                            <td width="40%">
                                                                <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-900 dark:text-gray-300">Terdaftar</span>
                                                            </td>
                                                            <td width="5%">:</td>
                                                            <td class="text-white">
                                                                {{ $value->registered }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Sedang berlangsung</span>
                                                            </td>
                                                            <td>:</td>
                                                            <td class="text-white">
                                                                {{ $value->ongoing }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Lulus</span>
                                                            </td>
                                                            <td>:</td>
                                                            <td class="text-white">
                                                                {{ $value->passed }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Gagal</span>
                                                            </td>
                                                            <td>:</td>
                                                            <td class="text-white">
                                                                {{ $value->failed }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="bg-black text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-black dark:text-white">Batal</span>
                                                            </td>
                                                            <td>:</td>
                                                            <td class="text-white">
                                                                {{ $value->cancelled }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-span-2 grid grid-cols-1 gap-2">
                                                    <div class="flex items-center">
                                                        <span class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Terdaftar</span>
                                                        <span class="bg-purple-100 text-purple-800 dark:bg-purple-700 dark:text-purple-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Sedang Mengikuti</span>
                                                        <span class="bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Lulus</span>
                                                        <span class="bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Gagal</span>
                                                        <span class="bg-black text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded">Dibatalkan</span>
                                                    </div>
                                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                            <tr>
                                                                <th scope="col" class="px-6 py-3 text-center">
                                                                    Kelas
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                                <td class="px-6 py-4">
                                                                    <div class="grid lg:grid-cols-5 sm:grid-cols-3 gap-2">
                                                                        @php
                                                                            $classes = explode(',', $value->nama_kelas);
                                                                            $enrollment_status = explode(',', $value->status_peserta);
                                                                        @endphp
                                                                        @foreach($classes as $index => $class)
                                                                            @php
                                                                                switch($enrollment_status[$index]){
                                                                                    case "REGISTERED":
                                                                                        $bg_color = "bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300";
                                                                                    break;
                                                                                    case "ON GOING":
                                                                                        $bg_color = "bg-purple-100 text-purple-800 dark:bg-purple-700 dark:text-purple-300";
                                                                                    break;
                                                                                    case "PASSED":
                                                                                        $bg_color = "bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-300";
                                                                                    break;
                                                                                    case "FAILED":
                                                                                        $bg_color = "bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-300";
                                                                                    break;
                                                                                    case "CANCELLED":
                                                                                        $bg_color = "bg-black text-white";
                                                                                    break;
                                                                                }
                                                                            @endphp
                                                                            <span class="{{$bg_color}} text-xs font-medium me-2 px-2.5 py-0.5 rounded text-center">{{$class}}</span>
                                                                        @endforeach
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
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
                        {{ $participants->links(); }}
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

    $('body').off('keypress', '[name="participants_kywd"]').on('keypress', '[name="participants_kywd"]', function(e){
        if(e.which == 13) {
            var participants_kywd = $(this).val();
            var url = "{{ route('participants', ['participants_kywd' => ':participants_kywd']) }}";
            url = url.replace(':participants_kywd', participants_kywd);
            window.location.href = url;
        }
    })
</script>
