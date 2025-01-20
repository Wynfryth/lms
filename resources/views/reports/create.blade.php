<style>
    #detail_table tbody tr{
        cursor: grab;
    }
</style>
<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelas | Tambah Kelas') }}
        </h2> --}}
        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd"/>
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
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Tambah</span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('studies.store') }}" class="mt-6 space-y-6">
                    @csrf
                    {{-- @method('put') --}}

                    <div>
                        <x-input-label for="judul_materi" :value="__('Judul')" />
                        <x-text-input id="judul_materi" name="judul_materi" type="text" class="mt-1 block w-full" value="{{ old('judul_materi') }}"/>
                        @error('judul_materi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="deskripsi_materi" :value="__('Deskripsi')" />
                        <x-textarea-input id="deskripsi_materi" name="deskripsi_materi" class="mt-1 block w-full">{{ old('deskripsi_materi') }}</x-textarea-input>
                        @error('deskripsi_materi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="my-1">
                        <x-input-label for="kategori_materi" :value="__('Kategori')"></x-input-label>
                        <x-select-option id="kategori_materi" name="kategori_materi">
                            <x-slot name="options">
                                <option class="disabled" value="null" selected disabled>
                                    Pilih Kategori ...
                                </option>
                                @forelse ($kategori as $index => $item)
                                    <option value="{{ $item->id }}" {{ old('kategori_materi') == $item->id ? 'selected' : '' }}>
                                        {{ $item->study_material_category }}
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
    check_detail();
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
function check_detail(){
    var tr_length = $('#detail_table tbody tr').length;
    // console.log(tr_length);
    if(tr_length > 0){
        // console.log($('tr.no_data_row'));
        if($('#detail_table tbody').find('tr.no_data_row').length > 0){
            $('#detail_table tbody').find('tr.no_data_row').remove();
        }
        for(i=0; i<tr_length; i++){
            $('#detail_table tbody').find('th_row:eq('+i+')').html((i+1));
        }
    }else{
        $('#detail_table tbody').append('<tr class="no_data_row"><td colspan="100%" class="text-center">Tidak ada data.</td></tr>')
    }
}
$('form').submit(function(e){

    e.preventDefault();
})
</script>
