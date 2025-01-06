<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelas | Tambah Kelas') }}
        </h2> --}}
        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
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
                    <a href="{{ route('questions') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Bank Pertanyaan Tes</a>
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

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form id="question_form" method="post" action="{{ route('questions.store') }}" class="mt-6 space-y-6">
                    @csrf
                    {{-- @method('put') --}}

                    <div class="grid lg:grid-cols-4 sm:grid-cols-1 gap-4">
                        <div class="my-1 mt-3 col-span-3">
                            <x-input-label for="test_ids" :value="__('Tes')"></x-input-label>
                            <x-select-option id="test_ids" name="test_ids[]" multiple="multiple" class="h-10">
                                <x-slot name="options">
                                    {{-- <option class="disabled" value="null" selected disabled>
                                        Pilih Tes ...
                                    </option> --}}
                                    @forelse ($tests as $index => $item)
                                        <option value="{{ $item->id }}" {{ old('test_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->test_name }}
                                        </option>
                                    @empty
                                        {{-- do nothing --}}
                                    @endforelse
                                </x-slot>
                            </x-select-option>
                            @error('test_ids')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-1">
                            <x-input-label for="points" :value="__('Poin')"></x-input-label>
                            <x-select-option id="points" name="points">
                                <x-slot name="options">
                                    <option class="disabled" value="null" selected disabled>
                                        Pilih Jumlah Poin ...
                                    </option>
                                    @for ($i = 1; $i <= 20; $i++)
                                        <option value="{{ $i }}" {{ old('points') == $item->id ? 'selected' : '' }}>
                                            {{ $i }} Poin
                                        </option>
                                    @endfor
                                </x-slot>
                            </x-select-option>
                            @error('points')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="my-1">
                        <x-input-label for="question" :value="__('Pertanyaan')" />
                        <x-textarea-input id="question" name="question" type="text" class="mt-1 block w-full">
                            {{ old('question') }}
                        </x-textarea-input>
                        @error('question')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="my-1">
                        <div class="my-4 ">
                            @can('create pertanyaan')
                            <button type="button" class="bg-blue-500 hover:bg-blue-500 text-sm text-white hover:text-white font-semibold mx-1 py-1 px-3 border border-blue-500 hover:border-transparent rounded add_dynaTable" id="add_answers">
                                + Jawaban
                            </button>
                            @endcan
                        </div>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table id="answers_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            #
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Jawaban
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">
                                            Status
                                        </th>
                                        @canany(['edit pertanyaan','delete pertanyaan'])
                                        <th scope="col" class="px-6 py-3 text-center">
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
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function () {
        $('[name="points"]').val(10);
        $('select[name="test_ids[]"]').select2({
            placeholder: 'Pilih Tes',
            allowClear: true,
            width: 'resolve'
        })
    });
    $(document).off('submit', '#question_form').on('submit', '#question_form', function(){
        event.preventDefault();
        var answers_row = $('#answers_table').find('tbody tr').find('input[name="answer_status"]');
        // console.log(answers_row)
        if(answers_row.length > 0){
            var checkedExist = false;
            answers_row.each(function(index, element){
                if($(element).is(':checked')){
                    checkedExist = true;
                }
            })
            if(!checkedExist){
                Swal.fire({
                    icon: "warning",
                    title: "Perhatian!",
                    text: "Pilih salahsatu jawaban sebagai jawaban yang benar.",
                    confirmButtontext: "OK",
                    allowOutsideClick: false
                })
            }else if(checkedExist){
                this.submit();
            }
        }else{
            Swal.fire({
                icon: "warning",
                title: "Perhatian!",
                text: "Harap isi jawaban terlebih dahulu.",
                confirmButtontext: "OK",
                allowOutsideClick: false
            })
        }
    })
</script>
