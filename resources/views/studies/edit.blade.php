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
                        fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M10 2a3 3 0 0 0-3 3v1H5a3 3 0 0 0-3 3v2.382l1.447.723.005.003.027.013.12.056c.108.05.272.123.486.212.429.177 1.056.416 1.834.655C7.481 13.524 9.63 14 12 14c2.372 0 4.52-.475 6.08-.956.78-.24 1.406-.478 1.835-.655a14.028 14.028 0 0 0 .606-.268l.027-.013.005-.002L22 11.381V9a3 3 0 0 0-3-3h-2V5a3 3 0 0 0-3-3h-4Zm5 4V5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1h6Zm6.447 7.894.553-.276V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-5.382l.553.276.002.002.004.002.013.006.041.02.151.07c.13.06.318.144.557.242.478.198 1.163.46 2.01.72C7.019 15.476 9.37 16 12 16c2.628 0 4.98-.525 6.67-1.044a22.95 22.95 0 0 0 2.01-.72 15.994 15.994 0 0 0 .707-.312l.041-.02.013-.006.004-.002.001-.001-.431-.866.432.865ZM12 10a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
                            clip-rule="evenodd" />
                    </svg>
                    &nbsp;&nbsp;Materi
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                    <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('studies') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Bank Materi</a>
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
                <form method="post" action="{{ route('studies.update', $item->id) }}" id="edit_studies" class="mt-6 space-y-6">
                    @csrf
                    {{-- @method('put') --}}

                    <div>
                        <x-input-label for="judul_materi" :value="__('Judul')" />
                        <x-text-input id="judul_materi" name="judul_materi" type="text" class="mt-1 block w-full serialize" value="{{ $item->study_material_title }}"/>
                        @error('judul_materi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="deskripsi_materi" :value="__('Deskripsi')" />
                        <x-textarea-input id="deskripsi_materi" name="deskripsi_materi" class="mt-1 block w-full serialize">{{ $item->study_material_desc }}</x-textarea-input>
                        @error('deskripsi_materi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="my-1">
                        <x-input-label for="kategori_materi" :value="__('Kategori')"></x-input-label>
                        <x-select-option id="kategori_materi" name="kategori_materi" class="serialize">
                            <x-slot name="options">
                                <option class="disabled" value="null" selected disabled>
                                    Pilih Kategori ...
                                </option>
                                @forelse ($kategori as $index => $value)
                                    <option value="{{ $value->id }}" {{ $item->category_id == $value->id ? 'selected' : '' }}>
                                        {{ $value->study_material_category }}
                                    </option>
                                @empty
                                    {{-- do nothing --}}
                                @endforelse
                            </x-slot>
                        </x-select-option>
                        @error('kategori_materi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="my-1">
                        <x-add-button href="#" id="add_detail" data-modal-target="studydet-modal" data-modal-toggle="studydet-modal">
                            + Tambah
                        </x-add-button>
                        <x-delete-button href="#" class="float-right" id="deleted_detail" data-modal-target="studydet-modal" data-modal-toggle="studydet-modal">Deleted</x-delete-button>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
                            <h4 class="text-center dark:text-white">Pembelajaran & File</h4>
                            <table id="detail_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Urutan
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Nama Materi
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            File
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Bobot Nilai
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Perkiraan Waktu
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($detail as $index => $value)
                                        @php
                                            $filename = explode(', ', $value->filename);
                                            $attachment = explode(', ', $value->attachment);
                                            $estimated_time = explode(', ', $value->estimated_time);
                                        @endphp
                                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700" row_id="{{$value->id}}">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$value->order}}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{$value->name}}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if (count($filename) > 1)
                                                    <ul class="list-disc">
                                                        @foreach ($filename as $filename_index => $filename_item)
                                                        <li>
                                                            @if (substr($attachment[$filename_index], 0, 4) == 'http')
                                                                <a href="{{$attachment[$filename_index]}}" target="_blank">{{$filename_item}}</a>
                                                            @else
                                                                <a href="{{$attachment[$filename_index]}}" target="_blank">{{$filename_item}}</a>
                                                                {{-- <a type="button" href="#" class=""></a> --}}
                                                            @endif
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <a href="{{$value->attachment}}" target="_blank">{{$value->filename}}</a>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                {{$value->scoring_weight}}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if (count($estimated_time) > 1)
                                                    <ul class="list-disc">
                                                        @foreach ($estimated_time as $estimated_time_item)
                                                        <li>
                                                            {{$estimated_time_item}}
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{$value->estimated_time}}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline me-2 edit_detail" data-detail="{{$value->id}}" data-modal-target="studydet-modal" data-modal-toggle="studydet-modal">Edit</a>
                                                <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline hapus_detail" data-detail="{{$value->id}}">Hapus</a>
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

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<div id="studydet-modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="modal_title">
                    {{-- Pembelajaran & File --}}
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="studydet-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div id="modal_body" class="p-4 md:p-5 space-y-4">

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
$(document).ready(function () {
    // alert('hai')
    // console.log($(document).find('#add_detail'))
    // $(document).find('#add_detail')[0].click();
});
(function () {
    // Get the table and its rows
    var table = document.getElementById('detail_table');
    var rows = table.rows;
    // Initialize the drag source element to null
    var dragSrcEl = null;

    // Loop through each row (skipping the first row which contains the table headers)
    for (var i = 1; i < rows.length; i++) {
        var row = rows[i];
        // Make each row draggable
        row.draggable = true;

        // Add an event listener for when the drag starts
        row.addEventListener('dragstart', function (e) {
            // Set the drag source element to the current row
            dragSrcEl = this;
            // Set the drag effect to "move"
            e.dataTransfer.effectAllowed = 'move';
            // Set the drag data to the outer HTML of the current row
            e.dataTransfer.setData('text/html', this.outerHTML);
            // Add a class to the current row to indicate it is being dragged
            this.classList.add('bg-gray-100');
        });

        // Add an event listener for when the drag ends
        row.addEventListener('dragend', function (e) {
            // Remove the class indicating the row is being dragged
            this.classList.remove('bg-gray-100');
            // Remove the border classes from all table rows
            table.querySelectorAll('.border-t-2', '.border-blue-300').forEach(function (el) {
                el.classList.remove('border-t-2', 'border-blue-300');
            });
        });

        // Add an event listener for when the dragged row is over another row
        row.addEventListener('dragover', function (e) {
            // Prevent the default dragover behavior
            e.preventDefault();
            // Add border classes to the current row to indicate it is a drop target
            this.classList.add('border-t-2', 'border-blue-300');
        });

        // Add an event listener for when the dragged row enters another row
        row.addEventListener('dragenter', function (e) {
            // Prevent the default dragenter behavior
            e.preventDefault();
            // Add border classes to the current row to indicate it is a drop target
            this.classList.add('border-t-2', 'border-blue-300');
        });

        // Add an event listener for when the dragged row leaves another row
        row.addEventListener('dragleave', function (e) {
            // Remove the border classes from the current row
            this.classList.remove('border-t-2', 'border-blue-300');
        });

        // Add an event listener for when the dragged row is dropped onto another row
        row.addEventListener('drop', function (e) {
            // Prevent the default drop behavior
            e.preventDefault();
            // If the drag source element is not the current row
            if (dragSrcEl != this) {
                // Get the index of the drag source element
                var sourceIndex = dragSrcEl.rowIndex;
                // Get the index of the target row
                var targetIndex = this.rowIndex;
                // If the source index is less than the target index
                if (sourceIndex < targetIndex) {
                    // Insert the drag source element after the target row
                    table.tBodies[0].insertBefore(dragSrcEl, this.nextSibling);
                } else {
                    // Insert the drag source element before the target row
                    table.tBodies[0].insertBefore(dragSrcEl, this);
                }
            }
            // Remove the border classes from all table rows
            table.querySelectorAll('.border-t-2', '.border-blue-300').forEach(function (el) {
                el.classList.remove('border-t-2', 'border-blue-300');
            });
            refresh_index();
        });
    }
})();
function refresh_index(){
    $('#detail_table tbody tr').each(function(index){
        $(this).find('th').html(index+1);
    })
}

$(document).off('click', '.edit_detail').on('click', '.edit_detail', function () {
    var detail_id = $(this).data('detail');
    // console.log(detail_id);
    var url = "{{ route('studydet.edit', ':detail_id') }}";
    url = url.replace(':detail_id', detail_id);
    var loader_html = '<div class="loader mx-auto my-28"></div>';
    $('#studydet-modal #modal_body').html(loader_html);
    $('#studydet-modal #modal_body').animate({'opacity':'0.0'}, 600, function(){
        $.ajax({
            async: false,
            type: "GET",
            url: url,
            cache: false,
            // data: {
            //     id: "{{ $item->id }}"
            // },
            // dataType: "dataType",
            success: function (response) {
                $('#studydet-modal #modal_title').html('Pembelajaran & File');
                $('#studydet-modal #modal_body').html(response);
                $('#studydet-modal #modal_body').animate({'opacity':'1.0'}, 100);
            }
        });
    })
});
$(document).off('click', '.hapus_detail').on('click', '.hapus_detail', function(){
    var detail_id = $(this).data('detail');
    Swal.fire({
        icon: "question",
        title: "Hapus?",
        text: "Yakin untuk menghapus?",
        allowOutsideClick: false,
        confirmButtonText: "Ya",
        showDenyButton: true,
        denyButtonText: "Tidak",
        // background: "gray"
    })
    .then((response)=>{
        if(response.isConfirmed){
            // hapus
            $.ajax({
                async: false,
                type: "POST",
                url: "{{route('studydet.delete')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: detail_id,
                    id_header: "{{ $item->id }}"
                },
                dataType: "JSON",
                success: function (response) {
                    // console.log(response);
                    Swal.fire({
                        icon: "success",
                        title: "Sukses",
                        text: "Berhasil menghapus",
                        allowOutsideClick: false,
                        confirmButtonText: "OK",
                        // background: "gray"
                    })
                    .then((feedback)=>{
                        if(feedback.isConfirmed){
                            window.location.href = "{{ route('studies.edit', $item->id )}}"
                        }
                    })
                }
            });
        }else if(response.isDenied){
            // nggak jadi hapus
        }
    })
});
$(document).off('click', '#add_detail').on('click', '#add_detail', function () {
    var loader_html = '<div class="loader mx-auto my-28"></div>';
    $('#studydet-modal #modal_body').html(loader_html);
    $('#studydet-modal #modal_body').animate({'opacity':'0.0'}, 600, function(){
        $.ajax({
            async: false,
            type: "GET",
            url: "{{ route('studydet.create') }}",
            cache: false,
            data: {
                id: "{{ $item->id }}"
            },
            // dataType: "dataType",
            success: function (response) {
                $('#studydet-modal #modal_title').html('Pembelajaran & File');
                $('#studydet-modal #modal_body').html(response);
                $('#studydet-modal #modal_body').animate({'opacity':'1.0'}, 100);
            }
        });
    })
});
$(document).off('click', '#deleted_detail').on('click', '#deleted_detail', function(){
    var loader_html = '<div class="loader mx-auto my-28"></div>';
    $('#studydet-modal #modal_body').html(loader_html);
    $('#studydet-modal #modal_body').animate({'opacity':'0.0'}, 600, function(){
        $.ajax({
            async: false,
            type: "GET",
            url: "{{ route('studydet.getdeleted') }}",
            cache: false,
            data: {
                // "_token": "{{ csrf_token() }}",
                id: "{{ $item->id }}"
            },
            // dataType: "JSON",
            success: function (response) {
                $('#studydet-modal #modal_title').html('Detail yang dihapus');
                $('#studydet-modal #modal_body').html(response);
                $('#studydet-modal #modal_body').animate({'opacity':'1.0'}, 100);
            }
        });
    })
})
$(document).find('form').submit(function(e){
    var no_data_row = $('table#detail_table tbody').find('tr.row_no_data').length;

    if(no_data_row == 0){ // berarti ada isinya
        var detail_table_row = $(this).find('table#detail_table tbody tr');
        detail_table_row.each(function(index, element){
            var row_id = $(element).attr('row_id');
            $(this).append('<input type="hidden" name="detail_sequence[]" value="'+row_id+'">')
        });
    }
});
</script>
