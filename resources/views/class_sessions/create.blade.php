<x-app-layout>
    <x-slot name="header">
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
                    <a href="{{ route('class_sessions') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Sesi Kelas</a>
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
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table id="participant_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Kelas
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Kategori
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Mulai
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Sampai
                                </th>
                                <th scope="col" class="px-6 py-3 text-center" width="10%">
                                    Peserta
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <td class="text-center">
                                {{$class->class_title}}
                            </td>
                            <td class="text-center">
                                {{$class->class_category}}
                            </td>
                            <td class="text-center">
                                {{date('d/m/Y', strtotime($class->start_eff_date))}}
                            </td>
                            <td class="text-center">
                                {{date('d/m/Y', strtotime($class->end_eff_date))}}
                            </td>
                            <td class="text-center">
                                {{$class->jumlah_peserta}}
                            </td>
                        </tbody>
                    </table>
                </div>

                <div class="my-1">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="schedule_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="border-b text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center" width="10%">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Detail
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Materi / Tes
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Bobot Materi / Tes
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Mulai
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Selesai
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $session_name = '';
                                    $session_sequence = 1;
                                @endphp
                                @forelse ($class_session_schedules as $index => $schedule)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    @if ($session_name != $schedule->session_name)
                                        <td class="px-6 py-3 text-center border-r" rowspan="{{$schedule->session_schedule_count}}">
                                            {{$session_sequence++}}
                                        </td>
                                        <th scope="row" class="border-r px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" rowspan="{{$schedule->session_schedule_count}}">
                                            Nama: {{$schedule->session_name}} <br/>
                                            Trainer: {{$schedule->trainer}} <br/>
                                            Tipe: {{$schedule->location_type}}
                                        </th>
                                        @php
                                            $session_name = $schedule->session_name;
                                        @endphp
                                    @endif
                                    <td class="px-6 py-3 border-r">
                                        {{$schedule->study_material_title ?? $schedule->test_name}}
                                    </td>
                                    @if ($class->class_category_type_id == 1)
                                        @if ($schedule->material_type == 1)
                                        <th scope="row" class="border-r px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="my-1">
                                                <x-input-label for="material_percentage" :value="__('Persentase Nilai Materi (%)')" />
                                                <x-text-input id="material_percentage" name="material_percentage" data-schedule="{{$schedule->schedule_id}}" maxlength="4" type="text" class="mt-1 block w-full" value="{{ $schedule->material_percentage }}"/>
                                                @error('material_percentage')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </th>
                                        @else
                                        <th scope="row" class="border-r px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @endif
                                    @else
                                    <th scope="row" class="border-r px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="my-1">
                                            <x-input-label for="material_percentage" :value="__('Persentase Nilai Materi (%)')" />
                                            <x-text-input id="material_percentage" name="material_percentage" data-schedule="{{$schedule->schedule_id}}" maxlength="4" type="text" class="mt-1 block w-full" value="{{ $schedule->material_percentage }}"/>
                                            @error('material_percentage')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </th>
                                    @endif
                                    <td class="px-6 py-3 border-r">
                                        {{date('d/m/Y H:i:s', strtotime($schedule->start_eff_date))}}
                                    </td>
                                    <td class="px-6 py-3 border-r">
                                        {{date('d/m/Y H:i:s', strtotime($schedule->end_eff_date))}}
                                    </td>
                                    <td class="text-center relative px-6 py-3 border-r">
                                        <button id="dropdownMenuButton-{{ $schedule->schedule_id }}" data-dropdown-toggle="dropdown-{{ $schedule->schedule_id }}" class="border bg-gray-100 text-gray-500 hover:text-gray-700 focus:outline-none rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v.01M12 12v.01M12 18v.01"></path>
                                            </svg>
                                        </button>
                                        <!-- Dropdown menu -->
                                        <div id="dropdown-{{ $schedule->schedule_id }}" class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow-md absolute top-8 right-0" data-dropdown>
                                            <ul class="py-1 text-sm text-gray-700">
                                                <li>
                                                    <button type="button" data-shceduleid="{{$schedule->schedule_id}}" class="block w-full px-4 py-2 hover:bg-gray-100 editSchedule" data-modal-target="scheduleDet-modal" data-modal-toggle="scheduleDet-modal" >Edit</button>
                                                </li>
                                                <li>
                                                    <button type="button" data-scheduleid="{{$schedule->schedule_id}}" class="block w-full px-4 py-2 hover:bg-gray-100 text-red-600 deleteSchedule">Delete</button>
                                                </li>
                                            </ul>
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
                </div>

                <div class="bg-white sticky bottom-5 p-2 rounded shadow-md border-2 border-gray-500">
                    <label for="materialPercentageBar" class="text-center">Total Persentase Materi</label>
                    <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700" id="materialPercentageBarDiv">
                    </div>
                    <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-1.5 text-center mt-2 mr-4 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800 hidden w-full" id="save_material_percentage">SIMPAN</button>
                </div>

                <div id="accordion-collapse" data-accordion="collapse" class="mt-3">
                    <h2 id="accordion-collapse-heading-1">
                        <button type="button" class="flex items-center justify-between w-full p-3 font-medium rtl:text-right text-gray-500 border border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-1" aria-expanded="false" aria-controls="accordion-collapse-body-1">
                        <span>+ Tambah Sesi</span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-1" class="hidden border rounded-xl p-3" aria-labelledby="accordion-collapse-heading-1">
                        <form method="POST" action="{{ route('class_sessions.store') }}" class="mt-6 space-y-6">
                            @csrf
                            <input type="hidden" name="class_id" value="{{$class_id}}">
                            <input type="hidden" name="class_category_type" value="{{$class_category_type}}">
                            <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4">
                                <div class="my-1">
                                    <x-input-label for="nama_sesi" :value="__('Nama Sesi')" />
                                    <x-text-input id="nama_sesi" name="nama_sesi" type="text" class="mt-1 block w-full" value="{{ old('nama_sesi') }}"/>
                                    @error('nama_sesi')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="my-1">
                                    {{-- <h6 class="font-semibold">Mulai Sesi:</h6> --}}
                                    <div class="grid lg:grid-cols-1 sm:grid-cols-1 gap-4">
                                        <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4">
                                            <div>
                                                <x-input-label for="session_start_date" :value="__('Tanggal')"></x-input-label>
                                                <x-text-input id="session_start_date" datepicker datepicker-autohide datepicker-orientation="top right" datepicker-format="dd-mm-yyyy" name="session_start_date" type="text" class="mt-1 block w-full datepicker" value="{{ old('session_start_date') }}" />
                                                @error('session_start_date')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div>
                                                <x-input-label for="session_start_time" :value="__('Jam')"></x-input-label>
                                                <div class="relative mt-1">
                                                    <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </div>
                                                    <input type="time" id="session_start_time" name="session_start_time" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="00:00" required />
                                                </div>
                                                @error('session_start_time')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4">
                                <div class="my-1">
                                    <x-input-label for="instruktur" :value="__('Instruktur')"></x-input-label>
                                    <x-select-option id="instruktur" name="instruktur">
                                        <x-slot name="options">
                                            <option class="disabled" value="null" selected disabled>
                                                Pilih Instruktur ...
                                            </option>
                                            @forelse ($instructor as $index => $item)
                                                <option value="{{ $item->id }}" {{ old('instruktur') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->Employee_name }}
                                                </option>
                                            @empty
                                                {{-- do nothing --}}
                                            @endforelse
                                        </x-slot>
                                    </x-select-option>
                                    @error('instruktur')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="my-1">
                                    <x-input-label for="training_center" :value="__('Training Center')"></x-input-label>
                                    <x-select-option id="training_center" name="training_center">
                                        <x-slot name="options">
                                            <option class="disabled" value="null" selected disabled>
                                                Pilih Training Center ...
                                            </option>
                                            @forelse ($training_center as $index => $item)
                                                <option value="{{ $item->id }}" {{ old('training_center') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->tc_name }}
                                                </option>
                                            @empty
                                                {{-- do nothing --}}
                                            @endforelse
                                        </x-slot>
                                    </x-select-option>
                                    @error('training_center')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="my-1">
                                    <x-input-label for="loc_type" :value="__('Tipe')"></x-input-label>
                                    <x-select-option id="loc_type" name="loc_type">
                                        <x-slot name="options">
                                            <option class="disabled" value="null" selected disabled>
                                                Pilih Tipe Pengajaran ...
                                            </option>
                                            @forelse ($loc_type as $index => $item)
                                                <option value="{{ $item->id }}" {{ old('loc_type') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->location_type }}
                                                </option>
                                            @empty
                                                {{-- do nothing --}}
                                            @endforelse
                                        </x-slot>
                                    </x-select-option>
                                    @error('loc_type')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="my-1">
                                <x-input-label for="materi" :value="__('Materi')" />
                                <x-select-option id="materi" name="materi[]" style="width:100%" multiple="multiple">
                                    <x-slot name="options">
                                        @forelse ($materials as $material)
                                            <option value="{{ $material->id }}" {{ old('materi') == $material->id ? 'selected' : '' }}>
                                                {{ $material->material_name }}
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
                                <x-input-label for="deskripsi_sesi" :value="__('Deskripsi Sesi')" />
                                <x-textarea-input id="deskripsi_sesi" name="deskripsi_sesi" class="mt-1 block w-full">{{ old('deskripsi_sesi') }}</x-textarea-input>
                                @error('deskripsi_sesi')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Tambah') }}</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-3">
                    {{-- <button type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-1.5 text-center mr-4 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800" id="save_material_percentage">SELESAI</button> --}}
                    {{-- <a href="{{route('classes')}}" type="button" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-1.5 text-center mr-4 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">SELESAI</a> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<div id="scheduleDet-modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="modal_title">
                    Edit Jadwal
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="scheduleDet-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div id="modal_body" class="p-4 md:p-5 space-y-4">
                <div>
                    <div>
                        <x-input-label for="class_start" :value="__('Dari')"></x-input-label>
                        <x-text-input id="class_start" datepicker datepicker-autohide datepicker-orientation="top right" datepicker-format="dd-mm-yyyy" name="class_start" type="text" class="mt-1 block w-full class_period datepicker" value="{{ old('class_start') }}" />
                        @error('class_start')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            {{-- <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="studydet-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
                <button data-modal-hide="studydet-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
            </div> --}}
        </div>
    </div>
</div>
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
    var materialPercentage = 0;
    $(document).ready(function () {
        $('[name="materi[]"]').select2({
            placeholder: "Pilih Materi",
            allowClear: true
        });
        $('[name="material_percentage"]').trigger('keyup');
    });
    $(document).off('change', 'select[name="peserta[]"]').on('change', 'select[name="peserta[]"]', function(){
        var nip = $(this).val();
        var data = $(this).select2('data')[0]; // get the selected data (all compilation)
        var divisi = data.division;

        $(this).closest('tr').find('td:eq(2)').html(nip);
        $(this).closest('tr').find('td:eq(3)').html(divisi);
        $(this).closest('tr').find('td:eq(4)').html('REGISTERED');
    });
    $(document).off('click', '.deleteSchedule').on('click', '.deleteSchedule', function(){
        var id = $(this).data('scheduleid');
        Swal.fire({
            icon: "question",
            title: "Hapus",
            text: "Hapus jadwal?",
            showDenyButton: true,
            denyButtonText: "Tidak",
            confirmButtontext: "Ya",
            allowOutsideClick: false
        })
        .then((feedback)=>{
            if(feedback.isConfirmed){
                $.ajax({
                    type: "POST",
                    url: "{{route('class_sessions.deleteSchedule')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        scheduleId: id
                    },
                    dataType: "JSON",
                    success: function (response) {
                        // console.log(response)
                        if(response == 1){
                            Swal.fire({
                                icon: "success",
                                title: "Sukses",
                                text: "Sukses menghapus jadwal",
                                confirmButtontext: "Ya",
                                allowOutsideClick: false
                            })
                            .then((feedback2)=>{
                                if(feedback2.isConfirmed){
                                    window.location.reload();
                                }
                            })
                        }
                    }
                });
            }
        })
    });
    $(document).off('click', '.editSchedule').on('click', '.editSchedule', function(){
        var scheduleId = $(this).data('shceduleid');
        smallSkeleton($('#scheduleDet-modal').find('#modal_body'));
        var url = "{{route('class_sessions.getScheduleDetail', ':scheduleId')}}";
        url = url.replace(':scheduleId', scheduleId);
        $.ajax({
            type: "GET",
            url: url,
            data: {
                _token: "{{csrf_token()}}"
            },
            success: function (response) {
                // console.log(response);
                $('#scheduleDet-modal').find('#modal_body').html(response);
                $('.flowbite-datepicker').datepicker({
                    dateFormat: "dd-mm-yy"
                });
            }
        });
    });
    $(document).off('keyup', '[name="material_percentage"]').on('keyup', '[name="material_percentage"]', function(){
        var sumPercentage = 0;
        $('[name="material_percentage"]').each(function(index, element){
            var materialPercentage = !!$(element).val() ? parseInt($(element).val()) : 0;
            sumPercentage += materialPercentage;
        });
        remainingPercentage = 100 - sumPercentage;
        var color, width, html;
        // console.log(sumPercentage)
        if(sumPercentage > 0){
            if(sumPercentage == 100){
                color = "green";
                width = "100";
                $('#save_material_percentage').removeClass('hidden').addClass('show');
            }else if(sumPercentage < 100){
                color = "blue";
                width = sumPercentage;
                $('#save_material_percentage').removeClass('show').addClass('hidden');
            }else if(sumPercentage > 100){
                color = "red";
                width = "100";
                $('#save_material_percentage').removeClass('show').addClass('hidden');
            }
        }else{
            color = "black";
            width = "100";
            $('#save_material_percentage').removeClass('show').addClass('hidden');
        }
        percentageBar = '<div id="materialPercentageBar" class="bg-'+color+'-600 text-xs font-medium text-'+color+'-100 text-center p-0.5 leading-none rounded-full" style="width: '+width+'%">'+sumPercentage+'%</div>';
        $('#materialPercentageBarDiv').html(percentageBar);
    })
    $(document).off('click', '#save_material_percentage').on('click', '#save_material_percentage', function(){
        var percentageCollection = [];
        $('[name="material_percentage"]').each(function(index, element){
            var materialKey = $(element).data('schedule');
            var percentage = parseInt($(element).val());
            var obj = {
                materialKey: materialKey,
                percentage: percentage
            }
            percentageCollection.push(obj);
        });
        Swal.fire({
            icon: "question",
            title: "Simpan",
            text: "Simpan persentase nilai materi?",
            showDenyButton: true,
            denyButtonText: "Tidak",
            confirmButtontext: "Ya",
            allowOutsideClick: false
        })
        .then((feedback)=>{
            if(feedback.isConfirmed){
                $.ajax({
                    type: "POST",
                    url: "{{route('classes.updateMaterialPercentage')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        percentageCollection: percentageCollection
                    },
                    dataType: "JSON",
                    success: function (response) {
                        console.log(response)
                        if(response == 1){
                            Swal.fire({
                                icon: "success",
                                title: "Sukses",
                                text: "Sukses menyimpan persentase nilai",
                                confirmButtontext: "Ya",
                                allowOutsideClick: false
                            })
                            .then((response)=>{
                                if(response.isConfirmed){
                                    window.location = "{{ route('classes') }}";
                                }
                            })
                        }
                    }
                });
            }
        })
    })
</script>
