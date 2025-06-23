<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelas | Tambah Kelas') }}
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
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Tambah</span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="p-2 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">

                {{-- <ol class="flex items-center w-full p-0 space-x-2 text-sm font-medium text-center text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 sm:text-base dark:bg-gray-800 dark:border-gray-700 sm:p-4 sm:space-x-4 rtl:space-x-reverse">
                    <li class="flex items-center text-blue-600 dark:text-blue-500">
                        <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
                            1
                        </span>
                        Buat <span class="hidden sm:inline-flex sm:ms-2">Kelas</span>
                        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                            2
                        </span>
                        Buat <span class="hidden sm:inline-flex sm:ms-2">Sesi</span>
                    </li>
                </ol> --}}

                <form method="POST" action="{{ route('classes.store') }}" class="mt-1 space-y-1">
                    @csrf
                    {{-- @method('put') --}}
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" role="tablist">
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="detail-styled-tab" data-tabs-target="#styled-detail" type="button" role="tab" aria-controls="detail" aria-selected="false">Detail</button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="aktifitas-styled-tab" data-tabs-target="#styled-aktifitas" type="button" role="tab" aria-controls="aktifitas" aria-selected="false">Aktifitas</button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="peserta-styled-tab" data-tabs-target="#styled-peserta" type="button" role="tab" aria-controls="peserta" aria-selected="false">Peserta</button>
                            </li>
                        </ul>
                    </div>
                    <div id="default-styled-tab-content">
                        <div class="hidden p-4 rounded-lg dark:bg-gray-800" id="styled-detail" role="tabpanel" aria-labelledby="detail-tab">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="my-1">
                                    <x-input-label for="nama_kelas" :value="__('Nama')" />
                                    <x-text-input id="nama_kelas" name="nama_kelas" type="text" class="mt-1 block w-full" value="{{ old('nama_kelas') }}"/>
                                    @error('nama_kelas')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="my-1">
                                    <x-input-label for="jenis_kelas" :value="__('Jenis')"></x-input-label>
                                    <x-select-option id="jenis_kelas" name="jenis_kelas">
                                        <x-slot name="options">
                                            <option class="disabled" value="null" selected disabled>
                                                Pilih Jenis Kelas ...
                                            </option>
                                            @forelse ($jenis as $index => $item)
                                                <option value="{{ $item->id }}" {{ old('jenis_kelas') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->class_type }}
                                                </option>
                                            @empty
                                                {{-- do nothing --}}
                                            @endforelse
                                        </x-slot>
                                    </x-select-option>
                                    @error('jenis_kelas')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="my-1">
                                <x-input-label for="kategori_kelas" :value="__('Kategori')"></x-input-label>
                                <x-select-option id="kategori_kelas" name="kategori_kelas">
                                    <x-slot name="options">
                                        <option class="disabled" value="null" selected disabled>
                                            Pilih Kategori ...
                                        </option>
                                        @forelse ($kategori as $index => $item)
                                            <option value="{{ $item->id }}" {{ old('kategori_kelas') == $item->id ? 'selected' : '' }}>
                                                {{ $item->class_category }}
                                            </option>
                                        @empty
                                            {{-- do nothing --}}
                                        @endforelse
                                    </x-slot>
                                </x-select-option>
                                @error('kategori_kelas')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <x-input-label for="deskripsi_kelas" :value="__('Deskripsi')" />
                                <x-textarea-input id="deskripsi_kelas" name="deskripsi_kelas" class="mt-1 block w-full">{{ old('deskripsi_kelas') }}</x-textarea-input>
                            </div>
                        </div>
                        <div class="hidden p-4 rounded-lg dark:bg-gray-800" id="styled-aktifitas" role="tabpanel" aria-labelledby="aktifitas-tab">
                            <div id="div_class_session_table" class="my-1">
                                <div class="my-4">
                                    <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4">
                                        <div>
                                            <div>
                                                <x-input-label for="class_start" :value="__('Rencana tanggal mulai kelas')"></x-input-label>
                                                <x-text-input id="class_start" datepicker datepicker-autohide datepicker-orientation="bottom right" datepicker-format="dd-mm-yyyy" name="class_start" type="text" class="mt-1 block w-full datepicker" value="{{ old('class_start') }}" />
                                                @error('class_start')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div>
                                            <x-input-label for="time_class_start" :value="__('Rencana jam mulai kelas')" />
                                            <x-text-input id="time_class_start" name="time_class_start" type="text" class="mt-1 block w-full timepicker" value="{{ old('time_class_start') }}"/>
                                            @error('time_class_start')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div id="activity_section">
                                        <div class="my-4">
                                        @can('create aktifitas kelas')
                                        <button type="button" class="bg-blue-500 hover:bg-blue-500 text-sm text-white hover:text-white font-semibold mx-1 py-1 px-3 border border-blue-500 hover:border-transparent rounded add_dynaTable" id="add_class_activity">
                                            + Aktifitas
                                        </button>
                                        @endcan
                                    </div>
                                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                        <table id="class_activity_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-center" width="10%">
                                                        #
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-center" width="20%">
                                                        Jenis
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-center">
                                                        Aktifitas
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-center">
                                                        Instruktur
                                                    </th>
                                                    @canany(['edit master kelas','delete master kelas'])
                                                    <th scope="col" class="px-6 py-3 text-center" width="10%">
                                                        Aksi
                                                    </th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="row_no_data">
                                                    <td class="text-center py-1" colspan="100%"><span class="text-red-500">Tidak ada data.</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden p-4 rounded-lg dark:bg-gray-800" id="styled-peserta" role="tabpanel" aria-labelledby="peserta-tab">
                            <div class="my-1">
                                <div class="my-4 ">
                                    @can('register peserta kelas')
                                    <button type="button" class="bg-blue-500 hover:bg-blue-500 text-sm text-white hover:text-white font-semibold mx-1 py-1 px-3 border border-blue-500 hover:border-transparent rounded add_dynaTable" id="add_participant">
                                        + Peserta
                                    </button>
                                    <button type="button" class="bg-green-500 hover:bg-green-500 text-sm text-white hover:text-white font-semibold mx-1 py-1 px-3 border border-green-500 hover:border-transparent rounded float-right" id="import_participants" data-modal-target="uploadParticipants-modal" data-modal-toggle="uploadParticipants-modal">
                                        + Import Peserta
                                    </button>
                                    @endcan
                                </div>
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table id="participant_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-center" width="10%">
                                                    #
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center">
                                                    Nama Peserta
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center">
                                                    NIP
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center">
                                                    Divisi
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center">
                                                    Status
                                                </th>
                                                @canany(['edit sesi kelas','delete sesi kelas'])
                                                <th scope="col" class="px-6 py-3 text-center" width="10%">
                                                    Aksi
                                                </th>
                                                @endcanany
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="row_no_data">
                                                <td class="text-center py-1" colspan="100%"><span class="text-red-500">Tidak ada data.</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div>
                        <h6 class="font-semibold">Periode Kelas:</h6>
                        <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4">
                            <div>
                                <div>
                                    <x-input-label for="class_start" :value="__('Dari')"></x-input-label>
                                    <x-text-input id="class_start" datepicker datepicker-autohide datepicker-orientation="top right" datepicker-format="dd-mm-yyyy" name="class_start" type="text" class="mt-1 block w-full class_period datepicker" value="{{ old('class_start') }}" />
                                    @error('class_start')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div>
                                    <x-input-label for="class_end" :value="__('Sampai')"></x-input-label>
                                    <x-text-input id="class_end" datepicker datepicker-autohide datepicker-orientation="top right" datepicker-format="dd-mm-yyyy" name="class_end" type="text" class="mt-1 block w-full class_period datepicker" value="{{ old('class_end') }}" />
                                    @error('class_end')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div> --}}





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
<div id="uploadParticipants-modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="modal_title">
                    Upload Peserta
                </h3>
                <button type="button" id="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="uploadParticipants-modal">
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
<script>
    $(document).ready(function () {
        // console.log($('.class_period'));
        var importedParticipants = @json(session('importedParticipants'));
        if(importedParticipants != undefined){
            for(var keys in importedParticipants){
                $('#add_participant').trigger('click');
            }
        }

        $(document).find('.timepicker').timepicker({
            timeFormat: 'H:mm',
            interval: 30,
        });
    });
    $(document).off('change', 'select[name="peserta[]"]').on('change', 'select[name="peserta[]"]', function(){
        var nip = $(this).val();
        var data = $(this).select2('data')[0]; // get the selected data (all compilation)
        var divisi = data.division;

        $(this).closest('tr').find('td:eq(2)').html(nip);
        $(this).closest('tr').find('td:eq(3)').html(divisi);
        $(this).closest('tr').find('td:eq(4)').html('REGISTERED');
    });
    $(document).off('change', 'select[name="materials[]"]').on('change', 'select[name="materials[]"]', function(){
        var obj = $(this);
        var category_type = $('[name="kategori_kelas"]').find('option:selected').data('category-type');
        switch(category_type){
            case "Pre-test Class":
                id_test = $(this).val();
                var data = $(this).select2('data')[0]; // get the selected data (all compilation)
                var jumlah_soal = data.jumlah_soal;
                var tipe = data.tipe;
                $(this).closest('tr').find('td:eq(2)').html(jumlah_soal);
                $(this).closest('tr').find('td:eq(2)').append('<input type="hidden" name="material_types[]" value="Tes">');
            break;
            case "Training Class":
                var id_studies = $(this).val();
                var data = $(this).select2('data')[0]; // get the selected data (all compilation)
                // var tipe = data.tipe;
                // var pretest_postest = data.pretest_postest;
                console.log(data);
                $.ajax({
                    type: "POST",
                    url: "{{route('classes.check_studies')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        id_studies: id_studies,
                    },
                    dataType: "JSON",
                    success: function (response) {
                        // console.log(response);
                        if(response.length == 2){
                            obj.closest('tr').find('td:eq(2)').remove('input[name="material_types[]"]');
                            obj.closest('tr').find('td:eq(2)').append('<input type="hidden" name="material_types[]" value="Materi">');
                        }
                        // else{
                        //     Swal.fire({
                        //         icon: "warning",
                        //         title: "Perhatian!",
                        //         text: "Materi yang dipilih belum ada Pre-test dan/atau Post-test nya. Silakan pilih materi lainnya.",
                        //         allowOutsideClick: false
                        //     });
                        //     obj.val(null).trigger('change');
                        // }
                    }
                });
                // if(pretest_postest.split(',').length < 2){
                //     Swal.fire({
                //         icon: "warning",
                //         title: "Perhatian!",
                //         text: "Materi yang dipilih belum ada Pre-test dan/atau Post-test nya. Silakan pilih materi lainnya.",
                //         allowOutsideClick: false
                //     });
                //     $(this).empty();
                //     // console.log(pretest_postest);
                // }else{
                    // $(this).closest('tr').find('td:eq(2)').append('<input type="hidden" name="material_types[]" value="'+tipe+'">');
                // }
            break;
        }
    });
    $(document).off('click', '#importExcel').on('click', '#importExcel', function(){
        // console.log($('[name="file"]')[0].files[0]);
        let formData = new FormData();
        formData.append('file', $('[name="file"]')[0].files[0]);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // Add the CSRF token

        $.ajax({
            type: "POST",
            url: "{{route('fileUpload.uploadEnrollments')}}",
            data: formData,
            contentType: false,
            processData: false,
            // dataType: "dataType",
            success: function (response) {
                // console.log(response.importedParticipants);
                if(response.importedParticipants != undefined){
                    var modal = $('#closeModal').trigger('click');
                    for(var keys in response.importedParticipants){
                        $('#add_participant').trigger('click');
                        $('#participant_table tbody tr:last').find('td:not(.row_index):not(:last-child)').html('<span></span>');
                        tinySkeleton($('#participant_table tbody tr:last').find('td:not(.row_index):not(:last-child)').find('span'));
                        var url = "{{route('classes.getStudentByNip', ['nip'=> ':nip', 'index'=> ':index'])}}";
                        url = url.replace(':nip', response.importedParticipants[keys].nip);
                        url = url.replace(':index', keys);
                        $.ajax({
                            type: "GET",
                            url: url,
                            data: {
                                _token: "{{csrf_token()}}"
                            },
                            dataType: "JSON",
                            success: function (response) {
                                // console.log(response);
                                $('#participant_table tbody tr:eq('+parseInt(response.index)+')').find('td:eq(1)').html(response.studentData.Employee_name);
                                $('#participant_table tbody tr:eq('+parseInt(response.index)+')').find('td:eq(1)').append('<input type="text" class="hidden" name="peserta[]" value="'+response.studentData.nip+'">');
                                $('#participant_table tbody tr:eq('+parseInt(response.index)+')').find('td:eq(2)').html(response.studentData.nip);
                                $('#participant_table tbody tr:eq('+parseInt(response.index)+')').find('td:eq(3)').html(response.studentData.Organization);
                                $('#participant_table tbody tr:eq('+parseInt(response.index)+')').find('td:eq(4)').html('REGISTERED');
                            }
                        });
                    }
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
