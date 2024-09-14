<form method="POST" action="{{ route('academy_admin.studies.store') }}" class="mt-1 space-y-6">
    @csrf
    {{-- @method('put') --}}

    <div>
        <x-input-label for="nama_pembelajaran" :value="__('Nama Pembelajaran')" />
        <x-text-input id="nama_pembelajaran" name="nama_pembelajaran" type="text" class="mt-1 block w-full" value="{{ old('nama_pembelajaran') }}"/>
        @error('nama_pembelajaran')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-input-label for="bobot_pembelajaran" :value="__('Bobot Pembelajaran')" />
        <x-text-input id="bobot_pembelajaran" name="bobot_pembelajaran" type="text" class="mt-1 block w-full" value="{{ old('bobot_pembelajaran') }}"/>
        @error('bobot_pembelajaran')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="my-1">
        <x-add-button href="#" id="add_attachment">
            + Tambah
        </x-add-button>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
            <table id="attachment_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama File
                        </th>
                        <th scope="col" class="px-6 py-3">
                            File / Link
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>
    </div>
</form>
<script>
    $(document).ready(function () {
        check_attachment();
    });
    $(document).off('click', '#add_attachment').on('click', '#add_attachment', function () {
        $.ajax({
            async: false,
            type: "GET",
            url: "{{ route('academy_admin.studydet.attachment') }}",
            // data: "data",
            // dataType: "html",
            success: function (response) {
                check_attachment();
                $('#attachment_table tbody').append(response);
            }
        })
        .fail(function(){
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: "Gagal memuat form. Periksa koneksi internet anda dan coba lagi beberapa saat.",
                allowOutsideClick: false
            })
        })
    });
    function check_attachment(){
        var tr_length = $('#attachment_table tbody tr').length;
        // console.log(tr_length);
        if(tr_length > 0){
            // console.log($('tr.no_data_row'));
            $('#attachment_table tbody').find('tr.no_data_row').remove();
        }else{
            $('#attachment_table tbody').append('<tr class="no_data_row"><td colspan="100%" class="text-center">Tidak ada data.</td></tr>')
        }
    }
</script>
