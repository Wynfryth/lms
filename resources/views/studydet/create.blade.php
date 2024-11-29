<form method="POST" action="{{ route('studydet.store') }}" class="mt-1 space-y-6" id="create_pembelajaran">
    @csrf
    {{-- @method('put') --}}

    <div>
        <x-input-label for="nama_pembelajaran" :value="__('Nama Pembelajaran')" />
        <x-text-input id="nama_pembelajaran" name="nama_pembelajaran" type="text" class="mt-1 block w-full serialize" value="{{ old('nama_pembelajaran') }}"/>
        @error('nama_pembelajaran')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    {{-- <div>
        <x-input-label for="bobot_pembelajaran" :value="__('Bobot Pembelajaran *harus angka')" />
        <x-text-input id="bobot_pembelajaran" name="bobot_pembelajaran" type="number" class="mt-1 block w-full serialize" value="{{ old('bobot_pembelajaran') }}"/>
        @error('bobot_pembelajaran')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div> --}}

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
                            Durasi
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
            url: "{{ route('studydet.attachment') }}",
            // data: "data",
            // dataType: "html",
            success: function (response) {
                $('#attachment_table tbody').append(response);
                check_attachment();
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
            if($('#attachment_table tbody').find('tr.no_data_row').length > 0){
                $('#attachment_table tbody').find('tr.no_data_row').remove();
            }
            for(i=0; i<tr_length; i++){
                $('#attachment_table tbody').find('th.index_row:eq('+i+')').html((i+1));
            }
        }else{
            $('#attachment_table tbody').append('<tr class="no_data_row"><td colspan="100%" class="text-center">Tidak ada data.</td></tr>')
        }
        $(document).find('.timepicker').timepicker({
            timeFormat: 'H:mm',
            interval: 15,
            maxTime: '5:00'
        });
    }
    $(document).off('click', '.delete_attachment').on('click', '.delete_attachment', function () {
        Swal.fire({
            icon: "question",
            title: "Hapus",
            text: "Yakin untuk menghapus?",
            showConfirmButton: true,
            confirmButtonText: "Ya",
            showDenyButton: true,
            denyButtonText: "Tidak",
            allowOutsideClick: false
        })
        .then((response)=>{
            if(response.isConfirmed){
                $(this).closest('tr').remove();
                check_attachment();
            }
        })
    });
    $(document).off('click', '.upload_file').on('click', '.upload_file',function () {
        var upload_file_html = '<input class="block lg:w-full sm:w-8 mt-1 text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="file_pembelajaran">';
        $(this).closest('td.attachment_row').html(upload_file_html);
    });
    $(document).off('click', '.upload_link').on('click', '.upload_link',function () {
        var upload_link_html = '<input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block lg:w-full sm:w-16" type="text" placeholder="Link File..." name="link_pembelajaran">';
        $(this).closest('td.attachment_row').html(upload_link_html);
    });
    $('form#create_pembelajaran').submit(function(e){
        e.preventDefault();

        var data = $(this).find('.serialize').serializeArray();
        var no_data_row = $('table#attachment_table tbody').find('tr.no_data_row').length;
        var formValidated = true;

        var nama_pembelajaran = $(this).find('input[name="nama_pembelajaran"]').val();
        if(nama_pembelajaran == ''){
           formValidated = false;
        }
        var bobot_pembelajaran = $(this).find('input[name="bobot_pembelajaran"]').val();
        if(bobot_pembelajaran == ''){
           formValidated = false;
        }else{
            bobot_pembelajaran = parseInt(bobot_pembelajaran);
        }

        data.push({
            name: "header_id",
            value: "{{ $item['id']; }}"
        })

        if(no_data_row == 0){ // berarti ada isinya
            var attachments = [];
            $('table#attachment_table tbody tr').each(function(index, element){
                var att_row = {};
                var nama_file = $(element).find('input[name="nama_file"]').val();
                att_row.nama_file = nama_file;
                var durasi = $(element).find('input[name="durasi"]').val();
                att_row.durasi = durasi;
                var attachment = $(element).find('td.attachment_row').find('input');
                if(attachment.length > 0){
                    var type = $(attachment).attr('type');
                    switch(type){
                        case "file":
                            var file = $(attachment)[0].files[0];
                            var formData = new FormData();
                            formData.append("file_pembelajaran",file);
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                async: false,
                                type: "POST",
                                url: "{{ route('file.upload_studyatt') }}",
                                processData: false,
                                contentType: false,
                                data: formData,
                                // dataType: "JSON",
                                success: function (response) {
                                    // console.log(response);
                                    var file_pembelajaran = response;
                                    att_row.file_pembelajaran = file_pembelajaran;
                                }
                            });
                        break;
                        case "text":
                            var file_pembelajaran = $(element).find('input[name="link_pembelajaran"]').val();
                            att_row.file_pembelajaran = file_pembelajaran;
                        break;
                    }
                }else if(attachment.length == 0){
                    formValidated = false;
                }
                attachments.push(att_row);
            })
            data.push({
                name: "attachments",
                value: JSON.stringify(attachments)
            });
        }
        if(!formValidated){
            e.preventDefault();
            Swal.fire({
                icon: "warning",
                title: "Perhatian!",
                html: "Mohon periksa kembali: <ul><li>Nama dan bobot pembelajaran.</li><li>Seluruh file/link yang akan di-upload.</li></ul>",
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
                        window.location = "{{ route('studies.edit', $item['id']) }}";
                    }
                },
                "JSON"
            );
        }
    });
</script>
