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

                    <div>
                        <x-input-label for="nama_kelas" :value="__('Nama')" />
                        <x-text-input id="nama_kelas" name="nama_kelas" type="text" class="mt-1 block w-full" value="{{ $item->class_title }}"/>
                        @error('nama_kelas')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="deskripsi_kelas" :value="__('Deskripsi')" />
                        <x-textarea-input id="deskripsi_kelas" name="deskripsi_kelas" class="mt-1 block w-full">{{ $item->class_desc }}</x-textarea-input>
                    </div>

                    <div class="my-1">
                        <x-input-label for="kategori_kelas" :value="__('Kategori')"></x-input-label>
                        <x-select-option id="kategori_kelas" name="kategori_kelas">
                            <x-slot name="options">
                                <option class="disabled" value="null" selected disabled>
                                    Pilih Kategori ...
                                </option>
                                @forelse ($kategori as $key => $value)
                                    <option value="{{ $value->id }}" {{ $value->id == $item->class_category_id ? 'selected' : '' }}>
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

                    <div>
                        <h6 class="font-semibold">Periode:</h6>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="bulan_periode_kelas" :value="__('Bulan')"></x-input-label>
                                <x-select-option id="bulan_periode_kelas" name="bulan_periode_kelas">
                                    <x-slot name="options">
                                        <option value="null" selected disabled>
                                            Pilih Bulan...
                                        </option>
                                        @php
                                            $bulan = [
                                                'Januari',
                                                'Februari',
                                                'Maret',
                                                'April',
                                                'Mei',
                                                'Juni',
                                                'Juli',
                                                'Agustus',
                                                'September',
                                                'Oktober',
                                                'November',
                                                'Desember',
                                            ];
                                        @endphp
                                        @forelse ($bulan as $index => $value)
                                            <option value="{{ $index + 1 }}" {{ intval(date('m', strtotime($item->class_period))) == ($index+1) ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @empty
                                            {{-- do nothing --}}
                                        @endforelse
                                    </x-slot>
                                </x-select-option>
                                @error('bulan_periode_kelas')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <x-input-label for="tahun_periode_kelas" :value="__('Tahun')"></x-input-label>
                                <x-select-option id="tahun_periode_kelas" name="tahun_periode_kelas">

                                    <x-slot name="options">
                                        <option value="null" selected disabled>
                                            Pilih Tahun...
                                        </option>
                                        @php
                                            $past_year = date('Y')-5;
                                        @endphp
                                        @for ($i = 0; $i <= 10; $i++)
                                            <option value="{{ intval($past_year)+$i }}" {{ intval(date('Y', strtotime($item->class_period))) == (intval($past_year)+$i) ? 'selected' : '' }}>
                                                {{ intval($past_year)+$i }}
                                            </option>
                                        @endfor
                                    </x-slot>
                                </x-select-option>
                                @error('tahun_periode_kelas')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <h6 class="font-semibold">Periode Efektif:</h6>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <div>
                                    <x-input-label for="periode_efektif_kelas_mulai" :value="__('Dari')"></x-input-label>
                                    <x-text-input id="periode_efektif_kelas_mulai" datepicker datepicker-autohide datepicker-orientation="top right" datepicker-format="dd-mm-yyyy" name="periode_efektif_kelas_mulai" type="text" class="mt-1 block w-full datepicker" value="{{ date('d-m-Y', strtotime($item->start_eff_date)) }}" />
                                    @error('periode_efektif_kelas_mulai')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div>
                                    <x-input-label for="periode_efektif_kelas_sampai" :value="__('Sampai')"></x-input-label>
                                    <x-text-input id="periode_efektif_kelas_sampai" datepicker datepicker-autohide datepicker-orientation="top right" datepicker-format="dd-mm-yyyy" name="periode_efektif_kelas_sampai" type="text" class="mt-1 block w-full datepicker" value="{{ date('d-m-Y', strtotime($item->end_eff_date)) }}" />
                                    @error('periode_efektif_kelas_sampai')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="my-1">
                        <x-input-label for="tc_kelas" :value="__('Pusat Pelatihan')"></x-input-label>
                        <x-select-option id="tc_kelas" name="tc_kelas">
                            <x-slot name="options">
                                <option value="null" selected disabled>
                                    Pilih Pusat Pelatihan...
                                </option>
                                @forelse ($tc as $index => $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->tc_name.' - '.$item->tc_address }}
                                    </option>
                                @empty

                                @endforelse
                            </x-slot>
                        </x-select-option>
                        @error('tc_kelas')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
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
<script>
    $(document).ready(function () {
        // $('.datepicker').datepicker({
        //     dateFormat: 'dd-mm-yy',
        //     // changeMonth: true,
        //     // changeYear: true
        // });
    });
</script>
