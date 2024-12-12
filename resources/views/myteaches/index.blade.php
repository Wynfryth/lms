<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelas > kelas diampu') }}
        </h2> --}}
        <!-- Breadcrumb -->
        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-3 8a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-2-1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H9Zm2 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-2-1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                    </svg>
                    &nbsp;&nbsp;Kelas Diampu
                    </a>
                </li>
                {{-- <li>
                    <div class="flex items-center">
                    <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('myteaches') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">kelas diampu</a>
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
                        @can('create kelas diampu')
                        <x-add-button href="{{route('myteaches.create')}}">
                            + Tambah
                        </x-add-button>
                        @endcan
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" name="myteaches_kywd" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari data" value="{{ $myteaches_kywd }}">
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
                                        Sesi Kelas
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Kelas
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Jumlah Peserta
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Mulai
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Selesai
                                    </th>
                                    @canany(['edit kelas diampu','delete kelas diampu'])
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Aksi
                                    </th>
                                    @endcanany
                                    <th scope="col" class="px-6 py-3">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($myteaches as $index => $value)
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $index + $myteaches->firstItem() }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $value->session_name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $value->class_title }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $value->jumlah_peserta }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ date('d-m-Y', strtotime($value->start_effective_date)) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ date('d-m-Y', strtotime($value->end_effective_date)) }}
                                        </td>
                                        @canany(['edit kelas diampu', 'delete kelas diampu'])
                                        <td class="px-6 py-4" width="15%">
                                            @if ($value->is_active == 1)
                                                <div class="flex flex-column sm:flex-row flex-wrap space-y-2 sm:space-y-0 items-center justify-between">
                                                    @can('edit kelas diampu')
                                                    <a type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="{{ route('myteaches.edit', $value->id) }}">Edit</a>
                                                    @endcan
                                                    @can('delete kelas diampu')
                                                    <button type="button" class="font-medium text-red-600 dark:text-red-500 hover:underline delete" data-id="{{ $value->id }}">Hapus</button>
                                                    @endcan
                                                </div>
                                            @else
                                                <div class="flex flex-column sm:flex-row flex-wrap space-y-2 sm:space-y-0 items-center justify-between">
                                                    @can('delete kelas diampu')
                                                    <button type="button" class="font-medium text-green-400 dark:text-green-200 hover:underline recover" data-id="{{ $value->id }}">Pulihkan</button>
                                                    @endcan
                                                </div>
                                            @endif
                                        </td>
                                        @endcanany
                                        <td>
                                            <button type="button" class="text-white bg-white hover:bg-blue-300 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onClick="toggleDetail(this)">
                                                <svg class="w-6 h-6 text-gray-800 hover:text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 10 4 4 4-4"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="class_detail hidden"  id="detail_{{$value->id}}">
                                        <td colspan="100%">
                                            <div class="grid lg:grid-cols-5 sm:grid-cols-3 gap-2 p-4">
                                                @php
                                                    $participants = explode(',', $value->peserta);
                                                    $statuses = explode(',', $value->status_kepesertaan);
                                                @endphp
                                                @foreach($participants as $index => $participant)
                                                    @php
                                                        switch($statuses[$index]){
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
                                                    <span class="{{$bg_color}} text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{$participant}}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-b dark:border-gray-700">
                                        <td colspan="100%" class="text-right">
                                            <div class="inline-flex rounded-md shadow-sm float-right" role="group">
                                                <button id="start_class_session" data-session-id="{{$value->id}}" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-blue-200 border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                                    <svg class="w-4 h-4 text-gray-800 dark:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd" d="M8.6 5.2A1 1 0 0 0 7 6v12a1 1 0 0 0 1.6.8l8-6a1 1 0 0 0 0-1.6l-8-6Z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Mulai
                                                </button>
                                                <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-red-200 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                                    <svg class="w-4 h-4 text-gray-800 dark:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Z"/>
                                                        <path fill-rule="evenodd" d="M11 7V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm4.707 5.707a1 1 0 0 0-1.414-1.414L11 14.586l-1.293-1.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Nilai
                                                </button>
                                                <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-green-200 border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                                    <svg class="w-4 h-4 text-gray-800 dark:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Sertifikat
                                                </button>
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
                        {{ $myteaches->links(); }}
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
    $('body').off('keypress', '[name="myteaches_kywd"]').on('keypress', '[name="myteaches_kywd"]', function(e){
        if(e.which == 13) {
            var myteaches_kywd = $(this).val();
            var url = "{{ route('myteaches', ['myteaches_kywd' => ':myteaches_kywd']) }}";
            url = url.replace(':myteaches_kywd', myteaches_kywd);
            window.location.href = url;
        }
    });
    $(document).off('click', '#start_class_session').on('click', '#start_class_session', function(){
        var class_session_id = $(this).data('session-id');
        $.ajax({
            async: false,
            type: "POST",
            url: "{{ route('myteaches.startClassSession') }}",
            data: {
                _token: "{{ csrf_token() }}",
                class_session_id: class_session_id
            },
            dataType: "JSON",
            success: function (response) {
                console.log(response);
            }
        });
    })
</script>
