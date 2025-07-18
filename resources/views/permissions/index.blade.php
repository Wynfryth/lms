<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto text-gray-900 dark:text-gray-100">
                    <h6 class="text-lg font-semibold leading-tight text-center">Permissions Management</h6>
                    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between mb-4">
                        @can('create permissions')
                        <x-add-button href="{{route('permissions.create')}}">
                            + Tambah
                        </x-add-button>
                        @endcan
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" id="table-search" name="permissions_kywd" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari data" value="{{ $permissions_kywd }}">
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
                                        Permission
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Roles
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Keaktifan
                                    </th>
                                    <th scope="col" class="px-6 py-3" width="15%">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permissions as $index => $value)
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                                            {{ $index + $permissions->firstItem(); }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $value->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                if($value->roles_granted != null){
                                                    $roles_granted = explode(',', $value->roles_granted);
                                                }
                                            @endphp
                                            @if ($value->roles_granted != null)
                                                @foreach ($roles_granted as $item)
                                                    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ $item }}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            {{-- @if ($value->is_active == 1) --}}
                                                <span class="text-emerald-600">Aktif</span>
                                            {{-- @else
                                                <span class="text-rose-600">Tidak Aktif</span>
                                            @endif --}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{-- @if ($value->is_active == 1) --}}
                                                @can('edit permissions')
                                                <a type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="{{ route('permissions.edit', $value->id) }}">Edit</a>
                                                @endcan
                                                {{-- <x-delete-button class="mx-auto delete" data-id="{{ $value->roles_id }}">
                                                    Hapus
                                                </x-delete-button> --}}
                                                {{-- <x-recover-button class="mx-auto detail">
                                                    Detail
                                                </x-recover-button> --}}
                                            {{-- @else --}}
                                                {{-- <x-recover-button class="mx-auto recover">
                                                    Pulihkan
                                                </x-recover-button> --}}
                                            {{-- @endif --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="row_no_data">
                                        <td class="text-center" colspan="100%">Tidak ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        {{ $permissions->links(); }}
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
    $(document).off('click', '.delete').on('click', '.delete', function(){
        var roles_id = $(this).data('id');
        Swal.fire({
            icon: "question",
            title: "Hapus!",
            text: "Hapus data roles?",
            showConfirmButton: true,
            confirmButtonText: "Ya",
            showDenyButton: true,
            denyButtonText: "Tidak",
            confirmButtonColor: "#8CD4F5",
            denyButtonColor: '#F04249',
            allowOutsideClick: false
        })
        .then((feedback)=>{
            if(feedback.isConfirmed){
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "{{route('permissions.delete')}}",
                    data: {
                        _token: '{{csrf_token()}}',
                        roles_id: roles_id
                    },
                    dataType: "JSON",
                    success: function (response) {
                        console.log(response);
                    }
                });
            }
        })
    })
    $('body').off('keypress', '[name="permissions_kywd"]').on('keypress', '[name="permissions_kywd"]', function(e){
        if(e.which == 13) {
            var permissions_kywd = $(this).val();
            var url = "{{ route('permissions', ['permissions_kywd' => ':permissions_kywd']) }}";
            url = url.replace(':permissions_kywd', permissions_kywd);
            window.location.href = url;
        }
    })
</script>
