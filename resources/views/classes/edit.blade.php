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
                    <a href="{{ route('classes') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Master Kelas</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Edit</span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="p-2 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                {{-- {{dd(Input::all())}} --}}
                <form method="POST" action="{{ route('classes.update', $item->id) }}" class="mt-6 space-y-6">
                    @csrf
                    {{-- @method('put') --}}

                    <div class="grid grid-cols-2 gap-4">
                        <div class="my-1">
                            <x-input-label for="nama_kelas" :value="__('Nama')" />
                            <x-text-input id="nama_kelas" name="nama_kelas" type="text" class="mt-1 block w-full" value="{{ $item->class_title }}"/>
                            @error('nama_kelas')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-1">
                            <x-input-label for="kategori_kelas" :value="__('Kategori')"></x-input-label>
                            <x-select-option id="kategori_kelas" name="kategori_kelas">
                                <x-slot name="options">
                                    <option class="disabled" value="null" selected disabled>
                                        Pilih Kategori ...
                                    </option>
                                    @forelse ($kategori as $key => $value)
                                        <option value="{{ $value->id }}" data-category-type="{{ $value->category_type }}" {{ $value->id == $item->class_category_id ? 'selected' : '' }}>
                                            {{ $value->class_category }}
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
                    </div>


                    <div>
                        <x-input-label for="deskripsi_kelas" :value="__('Deskripsi')" />
                        <x-textarea-input id="deskripsi_kelas" name="deskripsi_kelas" class="mt-1 block w-full">{{ $item->class_desc }}</x-textarea-input>
                    </div>

                    <div>
                        <h6 class="font-semibold">Periode Kelas:</h6>
                        <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4">
                            <div>
                                <div>
                                    <x-input-label for="class_start" :value="__('Dari')"></x-input-label>
                                    <x-text-input id="class_start" datepicker datepicker-autohide datepicker-orientation="top right" datepicker-format="dd-mm-yyyy" name="class_start" type="text" class="mt-1 block w-full class_period datepicker" value="{{ date('d-m-Y', strtotime($item->start_eff_date)); }}" />
                                    @error('class_start')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div>
                                    <x-input-label for="class_end" :value="__('Sampai')"></x-input-label>
                                    <x-text-input id="class_end" datepicker datepicker-autohide datepicker-orientation="top right" datepicker-format="dd-mm-yyyy" name="class_end" type="text" class="mt-1 block w-full class_period datepicker" value="{{ date('d-m-Y', strtotime($item->end_eff_date)); }}" />
                                    @error('class_end')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="my-1">
                        <div class="my-4 ">
                            @can('create sesi kelas')
                            <button type="button" class="bg-blue-500 hover:bg-blue-500 text-sm text-white hover:text-white font-semibold mx-1 py-1 px-3 border border-blue-500 hover:border-transparent rounded add_dynaTable" id="add_participant">
                                + Peserta
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
        // $(document).find('[name="kategori_kelas"]').val('{{$item->class_category_id}}').trigger('change');
        // var category_type = $('[name="kategori_kelas"]').find('option:selected').data('category-type');
        // var id_materials = "{{$item->id_materials}}".split(',');
        // var studies = "{{$item->studies}}".split(',');
        // switch(category_type){
        //     case "Pre-test Class":
        //         var jumlah_soal = "{{$item->jumlah_soal}}".split(',');
        //         for(var i=0; i<id_materials.length; i++){
        //             $('button#add_pretest').trigger('click');
        //             // $('#pretests_table tbody tr:last').find('select[name="materials[]"]').append('<option value="'+id_materials[i]+'">'+studies[i]+'</option>');
        //             $('#pretests_table tbody tr:last').find('select[name="materials[]"]').val(id_materials[i]).trigger('change');
        //             $('#pretests_table tbody tr:last').find('td:eq(2)').html(jumlah_soal[i]);
        //             $('#pretests_table tbody tr:last').find('td:eq(2)').append('<input type="hidden" name="material_types[]" value="Tes">');
        //         }
        //     break;
        //     case "Training Class":
        //         for(var i=0; i<id_materials.length; i++){
        //             $('button#add_studies').trigger('click');
        //             // $('#studies_table tbody tr:last').find('select[name="materials[]"]').append('<option value="'+id_materials[i]+'">'+studies[i]+'</option>');
        //             $('#studies_table tbody tr:last').find('select[name="materials[]"]').val(id_materials[i]).trigger('change');
        //             $('#studies_table tbody tr:last').find('td:eq(2)').append('<input type="hidden" name="material_types[]" value="Materi">');
        //         }
        //     break;
        // }
        var students = @json($students);
        // console.log(students);
        for(var keys in students){
            $('button#add_participant').trigger('click');
            $(document).find('#participant_table tbody tr:last').find('[name="peserta[]"]').closest('td').empty().html('<span>'+students[keys].student_name+'</span>');
            $(document).find('#participant_table tbody tr:last').find('td:eq(2)').html(students[keys].emp_nip);
            $(document).find('#participant_table tbody tr:last').find('td:eq(3)').html('<span>'+students[keys].Organization+'</span>');
            $(document).find('#participant_table tbody tr:last').find('td:eq(4)').html('<span>'+students[keys].enrollment_status+'</span>');
            $(document).find('#participant_table tbody tr:last').find('button.remove_row').removeClass('remove_row').addClass('cancel_student');
        }
    });
    $(document).off('change', 'select[name="peserta[]"]').on('change', 'select[name="peserta[]"]', function(){
        var nip = $(this).val();
        var data = $(this).select2('data')[0]; // get the selected data (all compilation)
        var divisi = data.division;

        $(this).closest('tr').find('td:eq(2)').html(nip);
        $(this).closest('tr').find('td:eq(3)').html(divisi);
        $(this).closest('tr').find('td:eq(4)').html('REGISTERED');
    });
    $(document).off('click', '.cancel_student').on('click', '.cancel_student', function(){
        var student_nip = $(this).closest('tr').find('td:eq(2)').html();
        var class_id = '{{$item->id}}';
        Swal.fire({
            title: 'Batalkan Peserta',
            text: 'Yakin untuk membatalkan peserta ini?',
            icon: 'warning',
            confirmButtonText: 'Ya, batalkan!',
            showDenyButton: true,
            denyButtonText: 'Tidak',
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('classes.cancel_student') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        class_id: class_id,
                        student_nip: student_nip
                    },
                    success: function(data){
                        // $(this).closest('tr').remove();
                        if(data > 0){
                            Swal.fire({
                                title: 'Batalkan Peserta',
                                text: 'Peserta telah dibatalkan',
                                icon: 'success',
                                allowOutsideClick: false
                            })
                            .then((feedback)=>{
                                if(feedback.isConfirmed){
                                    window.location.reload();
                                }
                            });
                        }
                    }
                });
            }
        })
    })
    // $(document).off('change', '[name="kategori_kelas"]').on('change', '[name="kategori_kelas"]', function(){
    //     var id_kategori_kelas = $(this).val();
    //     var category_type = $(this).find('option:selected').data('category-type');
    //     switch(category_type){
    //         case "Pre-test Class":
    //             // nampilin yang pretest doang
    //             $('#div_tests_table').removeClass('hidden');
    //             $('#div_studies_table table tbody').empty();
    //             update_dynaTable_index($('#div_studies_table table'));
    //             $('#div_studies_table').addClass('hidden');
    //         break;
    //         case "Training Class":
    //             // nampilin yang materi doang
    //             $('#div_studies_table').removeClass('hidden');
    //             $('#div_tests_table table tbody').empty();
    //             update_dynaTable_index($('#div_tests_table table'));
    //             $('#div_tests_table').addClass('hidden');
    //         break;
    //     }
    // });
    // $(document).off('change', 'select[name="materials[]"]').on('change', 'select[name="materials[]"]', function(){
    //     var category_type = $('[name="kategori_kelas"]').find('option:selected').data('category-type');
    //     switch(category_type){
    //         case "Pre-test Class":
    //             var id_test = $(this).val();
    //             var data = $(this).select2('data')[0]; // get the selected data (all compilation)
    //             var jumlah_soal = data.jumlah_soal;
    //             var tipe = data.tipe;
    //             console.log(data);
    //             $(this).closest('tr').find('td:eq(2)').html(jumlah_soal);
    //             $(this).closest('tr').find('td:eq(2)').append('<input type="hidden" name="material_types[]" value="'+tipe+'">');
    //         break;
    //         case "Training Class":
    //             var id_studies = $(this).val();
    //             var data = $(this).select2('data')[0]; // get the selected data (all compilation)
    //             var pretest_postest = data.pretest_postest;
    //             var tipe = data.tipe;
    //             $(this).closest('tr').find('td:eq(2)').append('<input type="hidden" name="material_types[]" value="'+tipe+'">');
    //         break;
    //     }
    // });
</script>
