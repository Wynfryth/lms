<style>
    #detail_table tbody tr{
        cursor: grab;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelas | Edit Kelas') }}
        </h2> --}}
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
                    <a href="{{ route('tests') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Bank Materi</a>
                    </div>
                </li>
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form method="post" action="{{ route('tests.update', $item->id) }}" id="edit_tests" class="mt-6 space-y-6">
                    @csrf
                    {{-- @method('put') --}}

                    <div>
                        <x-input-label for="nama_tes" :value="__('Judul')" />
                        <x-text-input id="nama_tes" name="nama_tes" type="text" class="mt-1 block w-full serialize" value="{{ $item->test_name }}"/>
                        @error('nama_tes')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="my-1">
                        <x-input-label for="kategori_tes" :value="__('Kategori')"></x-input-label>
                        <x-select-option id="kategori_tes" name="kategori_tes">
                            <x-slot name="options">
                                <option class="disabled" value="null" selected disabled>
                                    Pilih Kategori ...
                                </option>
                                @forelse ($testcats as $key => $value)
                                    <option value="{{ $value->id }}" {{ $value->id == $item->test_cat_id ? 'selected' : '' }}>
                                        {{ $value->test_category }}
                                    </option>
                                @empty
                                    {{-- do nothing --}}
                                @endforelse
                            </x-slot>
                        </x-select-option>
                        @error('kategori_tes')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="materi_div" class="my-1 hidden">
                        <x-input-label for="materi" :value="__('Untuk Materi')"></x-input-label>
                        <x-select-option id="materi" name="materi">
                            <x-slot name="options">
                                <option class="disabled" value="null" selected disabled>
                                    Pilih Materi...
                                </option>
                                @forelse ($studies as $key => $value)
                                    <option value="{{ $value->id }}" {{ $value->id == $item->study_materials_id ? 'selected' : '' }}>
                                        {{ $value->study_material_title }}
                                    </option>
                                @empty
                                    {{-- do nothing --}}
                                @endforelse
                            </x-slot>
                        </x-select-option>
                        @error('materi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="deskripsi_tes" :value="__('Deskripsi')" />
                        <x-textarea-input id="deskripsi_tes" name="deskripsi_tes" class="mt-1 block w-full serialize">{{ $item->test_desc }}</x-textarea-input>
                        @error('deskripsi_tes')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
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
    $(document).ready(function () {
        $(document).find('[name="kategori_tes"]').trigger('change');
    });
    $(document).off('change', '[name="kategori_tes"]').on('change', '[name="kategori_tes"]', function(){
        var kategori_tes = $(this).val();
        if(kategori_tes != '1'){
            $('#materi_div').removeClass('hidden');
        }else{
            $('#materi_div').addClass('hidden');
        }
    })
</script>
