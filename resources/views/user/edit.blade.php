@php
    use Illuminate\Support\Facades\Storage;
@endphp
<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelas | Tambah Kelas') }}
        </h2> --}}
        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    {{-- <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd"/>
                    </svg>
                    &nbsp;&nbsp;Materi --}}
                    User
                    </a>
                </li>
                {{-- <li>
                    <div class="flex items-center">
                    <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('dashboard') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Kategori Materi</a>
                    </div>
                </li> --}}
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Ubah</span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form method="post" action="{{ route('users.update', $user_id) }}" class="mt-6 space-y-6">
                    @csrf
                    {{-- @method('put') --}}

                    <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4">
                        <div class="my-1">
                            <x-input-label for="nama" :value="__('Nama')"></x-input-label>
                            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full serialize" value="{{$user_data->username}}"/>
                        </div>
                        <div class="my-1">
                            <x-input-label for="email" :value="__('E-mail')"></x-input-label>
                            <x-text-input id="email" name="email" type="text" class="mt-1 block w-full serialize" value="{{$user_data->email}}"/>
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4">
                        {{-- <div class="my-1">
                            <x-input-label for="role" :value="__('Role')"></x-input-label>
                            <x-select-option id="role" name="role" class="serialize">
                                <x-slot name="options">
                                    <option class="disabled" value="null" selected disabled>
                                        Pilih Peran ...
                                    </option>
                                    @forelse ($roles as $index => $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $user_data->roleid ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @empty

                                    @endforelse
                                </x-slot>
                            </x-select-option>
                            @error('role')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div> --}}
                        <div class="my-5 ml-3">
                            <x-input-label for="active_status" :value="__('Status Keaktifan')"></x-input-label>
                            <label class="inline-flex items-center cursor-pointer">
                                @php
                                    if($user_data->is_active == 1){
                                        $check_status = 'checked';
                                    }else{
                                        $check_status = '';
                                    }
                                @endphp
                                <input type="checkbox" class="sr-only peer serialize" name="active_status" {{$check_status}}>
                                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300" id="ket_status_keaktifan">Aktif</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <h6 class="text-dark dark:text-white">Roles: </h6>
                        <div class="grid lg:grid-cols-5 sm:grid-cols-1 gap-4 px-3">
                            @php
                                $roles_granted = explode(',', $user_data->roles_granted);
                            @endphp
                            @foreach ($roles as $role)
                                @php
                                    if(in_array($role->id, $roles_granted)){
                                        $check_status = 'checked';
                                    }else{
                                        $check_status = '';
                                    }
                                @endphp
                                <div class="my-1">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer serialize" name="role_{{ $role->id }}" {{ $check_status }}>
                                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300" id="ket_status_keaktifan">{{ $role->name }}</span>
                                    </label>

                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                        {{-- @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                        @endif --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function () {
        //
    });
    $('form').submit(function(e){
        e.preventDefault();

        var data = $(this).find('.serialize').serializeArray();
        var formValidated = true;
        var not_passed = [];

        $('.serialize').each(function(index, element){
            var element_value = $(this).val();
            if(element_value == '' || element_value ==  null){
                var name = $(this).attr('name');
                not_passed.push($('label[for="'+name+'"]').text());
                formValidated = false;
            }
        });

        if(!formValidated){
            // e.preventDefault();
            var unpassed = '<ul>';
            for(var keys in not_passed){
                unpassed += '<li>'+not_passed[keys]+'</li>';
            }
            unpassed += '</ul>';
            Swal.fire({
                icon: "warning",
                title: "Perhatian!",
                html: "Inputan masih ada yang kosong. Mohon di cek kembali.<br/>"+unpassed,
                confirmButtonColor: "#8CD4F5",
                allowOutsideClick: false
            })
        }else{
            var action = $(this).attr('action');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post(action, data,
                function (data, textStatus, jqXHR) {
                    // console.log(data);
                    if(data != 0){
                        window.location = "{{ route('users') }}";
                    }
                },
                "JSON"
            );
        }
    });
</script>
