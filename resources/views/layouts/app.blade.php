<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <style>
        #loading{
            height:100%;
            width:100%;
            /* background:url(/design/images/loader.gif) no-repeat center center; */
            position:absolute;
            z-index:50;
        }
        /* HTML: <div class="loader"></div> */
        .loader {
            width: 80px;
            aspect-ratio: 2;
            --c:linear-gradient(#ecaccb 25%,#9cd0e6 0 50%,#d8358d 0 75%,#52add0 0);
            background: var(--c), var(--c), var(--c), var(--c);
            background-size: 26% 400%;
            background-position: calc(0*100%/3) 100%,calc(1*100%/3) 100%,calc(2*100%/3) 100%,calc(3*100%/3) 100%;
            background-repeat: no-repeat;
            animation: l10 2s infinite;
        }
        @keyframes l10 {
            0%     {background-position: calc(0*100%/3) calc(3*100%/3),calc(1*100%/3) calc(3*100%/3),calc(2*100%/3) calc(3*100%/3),calc(3*100%/3) calc(3*100%/3)}
            8.33%  {background-position: calc(0*100%/3) calc(2*100%/3),calc(1*100%/3) calc(3*100%/3),calc(2*100%/3) calc(3*100%/3),calc(3*100%/3) calc(3*100%/3)}
            16.67% {background-position: calc(0*100%/3) calc(2*100%/3),calc(1*100%/3) calc(2*100%/3),calc(2*100%/3) calc(3*100%/3),calc(3*100%/3) calc(3*100%/3)}
            25%    {background-position: calc(0*100%/3) calc(2*100%/3),calc(1*100%/3) calc(2*100%/3),calc(2*100%/3) calc(2*100%/3),calc(3*100%/3) calc(3*100%/3)}
            30%,
            33.33% {background-position: calc(0*100%/3) calc(2*100%/3),calc(1*100%/3) calc(2*100%/3),calc(2*100%/3) calc(2*100%/3),calc(3*100%/3) calc(2*100%/3)}
            41.67% {background-position: calc(0*100%/3) calc(1*100%/3),calc(1*100%/3) calc(2*100%/3),calc(2*100%/3) calc(2*100%/3),calc(3*100%/3) calc(2*100%/3)}
            50%    {background-position: calc(0*100%/3) calc(1*100%/3),calc(1*100%/3) calc(1*100%/3),calc(2*100%/3) calc(2*100%/3),calc(3*100%/3) calc(2*100%/3)}
            58.33% {background-position: calc(0*100%/3) calc(1*100%/3),calc(1*100%/3) calc(1*100%/3),calc(2*100%/3) calc(1*100%/3),calc(3*100%/3) calc(2*100%/3)}
            63%,
            66.67% {background-position: calc(0*100%/3) calc(1*100%/3),calc(1*100%/3) calc(1*100%/3),calc(2*100%/3) calc(1*100%/3),calc(3*100%/3) calc(1*100%/3)}
            75%    {background-position: calc(0*100%/3) calc(0*100%/3),calc(1*100%/3) calc(1*100%/3),calc(2*100%/3) calc(1*100%/3),calc(3*100%/3) calc(1*100%/3)}
            83.33% {background-position: calc(0*100%/3) calc(0*100%/3),calc(1*100%/3) calc(0*100%/3),calc(2*100%/3) calc(1*100%/3),calc(3*100%/3) calc(1*100%/3)}
            91.67% {background-position: calc(0*100%/3) calc(0*100%/3),calc(1*100%/3) calc(0*100%/3),calc(2*100%/3) calc(0*100%/3),calc(3*100%/3) calc(1*100%/3)}
            97%,
            100%   {background-position: calc(0*100%/3) calc(0*100%/3),calc(1*100%/3) calc(0*100%/3),calc(2*100%/3) calc(0*100%/3),calc(3*100%/3) calc(0*100%/3)}
        }
        .ui-timepicker-container{
            z-index:1151 !important;
        }
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LMS Gacoan') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://cdn.jsdelivr.net/npm/jqueryui@1.11.1/jquery-ui.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.min.css">
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </head>
    <div id="loading" class="text-center bg-white dark:bg-gray-800">
        <div class="loader mx-auto my-28"></div>
    </div>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.sidebar')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 border-b border-gray-200 p-0 mt-20 sm:ml-64 shadow sticky top-20 z-30">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jqueryui@1.11.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </body>
</html>
<script>
$(window).on('load', function() {
    var $this = $('div#loading');
    $('div#loading').animate({
        opacity: 0
    }, 800, function() {
        $('div#loading').hide();
    });
});
function isNumber(value){
    return typeof value === 'number' && isFinite(value);
}
// On page load or when changing themes, best to add inline in `head` to avoid FOUC
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark')
}

var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

// Change the icons inside the button based on previous settings
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    themeToggleLightIcon.classList.remove('hidden');
} else {
    themeToggleDarkIcon.classList.remove('hidden');
}

var themeToggleBtn = document.getElementById('theme-toggle');

themeToggleBtn.addEventListener('click', function() {

    // toggle icons inside button
    themeToggleDarkIcon.classList.toggle('hidden');
    themeToggleLightIcon.classList.toggle('hidden');

    // if set via local storage previously
    if (localStorage.getItem('color-theme')) {
        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }

    // if NOT set via local storage previously
    } else {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    }

});
$(document).off('click', '.add_dynaTable').on('click', '.add_dynaTable', function(){
    var table_id = $(this).closest('div').next('div').find('table').attr('id');
    var table = $('#'+table_id);
    switch(table_id){
        case 'participant_table':
            var row_html =  '<tr>'+
                                '<td class="row_index text-center"></td>'+
                                '<td class="p-2">'+
                                    '<select style="width: 100%" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" name="peserta[]" type="text"></select>'+
                                '</td>'+
                                '<td class="text-center">'+
                                    '<button type="button" class="font-medium text-red-400 dark:text-red-200 hover:underline remove_row">Hapus</button>'+
                                '</td>'+
                            '</tr>';
        break;
        case 'answers_table':
            var row_html =  '<tr>'+
                                '<td class="row_index text-center"></td>'+
                                '<td class="p-2"><input class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" name="answers[]" type="text"></td>'+
                                '<td class="p-3 text-center">'+
                                    '<label class="inline-flex items-center cursor-pointer">'+
                                        '<input type="radio" class="sr-only peer" name="answer_status">'+
                                        '<div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>'+
                                        '<span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Benar</span>'+
                                    '</label>'+
                                '</td>'+
                                '<td class="text-center">'+
                                    '<button type="button" class="font-medium text-red-400 dark:text-red-200 hover:underline remove_row">Hapus</button>'+
                                '</td>'+
                            '</tr>';
        break;
    }
    table.find('tbody').append(row_html);
    update_dynaTable_index(table);
    switch(table_id){
        case 'participant_table':
            table.find('tbody tr:last').find('select[name="peserta[]"]').select2({
                placeholder: 'Pilih Peserta',
                allowClear: true,
                minimumInputLength: 3, // only start searching when the user has input 3 or more characters
                ajax: {
                    async: false,
                    url: "{{ route('class_sessions.participant_selectpicker') }}",
                    dataType: "JSON",
                    type: "POST",
                    quietMillis: 50,
                    delay: 250,
                    data: function (term) {
                        return {
                            term: term,
                            _token: '{{ csrf_token() }}'
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.nip,
                                    text: item.Employee_name
                                }
                            })
                        };
                    },
                    cache: true
                }
            })
        break;
        case 'answers_table':
            //
        break;
    }
});
function update_dynaTable_index(table){
    if($(table).find('tbody tr.row_no_data').length > 0){
        $(table).find('tbody tr.row_no_data').remove();
    }
    if($(table).find('tbody tr').length > 0){
        $(table).find('tbody tr').each(function(index, element){
            $(element).find('.row_index').html((index+1));
            $(element).find('input[name="answer_status"]').val(index);
        });
    }else{
        var html_row_no_data =  '<tr class="row_no_data">'+
                                    '<td class="text-center py-1" colspan="100%"><span class="text-red-500">Tidak ada data.</span></td>'+
                                '</tr>';
        $(table).find('tbody').append(html_row_no_data);
    }
}
$(document).off('click', '.remove_row').on('click', '.remove_row', function(){
    var table = $(this).closest('table');
    Swal.fire({
        icon: "question",
        title: "Yakin?",
        text: "Yakin untuk menghapus data?",
        showConfirmButton: true,
        confirmButtonText: "OK",
        allowOutsideClick: false
    })
    .then((feedback)=>{
        if(feedback.isConfirmed){
            $(this).closest('tr').remove();
        update_dynaTable_index(table);
        }
    })
})
function toggleDetail(element){
    var object = $(element);
    var detailRow = object.next('.class_detail'); // Get the next detail row

    if (detailRow.hasClass('hidden')) {
        // Close all other detail rows
        $('.class_detail').addClass('hidden').removeClass('visible');

        // Open the clicked detail row
        detailRow.removeClass('hidden').addClass('visible');
    } else {
        // Close the clicked detail row
        detailRow.addClass('hidden').removeClass('visible');
    }
}
</script>
