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

        /* Set the height of the select2 input box */
        .select2-container .select2-selection--single {
        height: 42px !important;
        display: flex;
        align-items: center;
        }

        /* Align the text inside vertically */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 42px !important;
        }

        /* Adjust the dropdown arrow to align properly */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px !important;
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
                <header class="bg-white dark:bg-gray-800 border-b border-gray-200 p-0 lg:mt-16 lg:top-16 sm:mt-20 sm:top-20 sm:ml-64 shadow sticky z-30">
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
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
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
    var notifications;
    $.ajax({
        async: false,
        type: "GET",
        url: "{{route('user.notifications')}}",
        data: {
            _token: "{{csrf_token()}}"
        },
        dataType: "JSON",
        success: function (response) {
            // console.log(response);
            if(response.length > 0){
                var unread = 0;
                var html = '';
                var bg_color = '';
                for(var keys in response){
                    if(response[keys].read_status == 0){
                        unread++;
                        bg_color = 'bg-red-50 hover:bg-red-100';
                    }else{
                        bg_color = '';
                    }
                    if(response[keys].class_id != null){
                        var url = "{{route('classrooms', ['class_id' => ':classId', 'role' => ':role'])}}";
                        url = url.replace(':classId', response[keys].class_id);
                        switch(response[keys].notification_role_id){
                            case 1:
                                url = url.replace(':role', 'Instructor');
                                html += '<li class="'+bg_color+'" data-notification="'+response[keys].id+'">'+
                                        '<a href="'+url+'" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">'+
                                            '<strong class="text-blue-500">'+response[keys].notification_title+'</strong><br/>'+
                                            '<div class=""><span>'+response[keys].notification_content+'</span></div>'+
                                        '</a>'+
                                    '</li>';
                                break;
                            case 2:
                                url = url.replace(':role', 'Student');
                                html += '<li class="'+bg_color+'" data-notification="'+response[keys].id+'">'+
                                        '<a href="'+url+'" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">'+
                                            '<strong class="text-blue-500">'+response[keys].notification_title+'</strong><br/>'+
                                            '<div class=""><span>'+response[keys].notification_content+'</span></div>'+
                                        '</a>'+
                                    '</li>';
                                break;
                        }
                    }else{
                        html += '<li class="'+bg_color+'" data-notification="'+response[keys].id+'">'+
                                    '<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">'+
                                        '<strong class="text-blue-500">'+response[keys].notification_title+'</strong><br/>'+
                                        '<div class=""><span>'+response[keys].notification_content+'</span></div>'+
                                    '</a>'+
                                '</li>';
                    }
                }
                if(unread > 0){
                    $('#notifications_length').html(unread);
                    $('#bell_icon').addClass('animate-wiggle');
                }
            }else{
                html = '<li class="text-center">'+
                            '<a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">'+
                                '<span class="text-red-500">Tidak ada notifikasi.</span>'+
                            '</a>'+
                        '</li>';
            }
            $('#usernotifications ul').html(html);
        }
    });
});
$('#bell_icon_button').off('click').on('click', function(){
    if($(this).find('#bell_icon').hasClass('animate-wiggle')){
        $(this).find('#bell_icon').removeClass('animate-wiggle');
        $.ajax({
            async: false,
            type: "GET",
            url: "{{route('user.readnotifications')}}",
            data: {
                _token: "{{csrf_token()}}"
            },
            dataType: "JSON",
            success: function (response) {
                $('#notifications_ring').remove();
            }
        });
    }
})
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
                                '<td class="p-2 text-center">'+

                                '</td>'+
                                '<td class="p-2 text-center">'+

                                '</td>'+
                                '<td class="p-2 text-center">'+

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
        case 'class_activity_table':
            var row_html =  '<tr>'+
                                '<td class="row_index text-center"></td>'+
                                '<td class="p-2">'+
                                    '<select name="activity_type[]" style="width: 150px;" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">'+
                                        '<option value="materi">Materi</option>'+
                                        '<option value="tes">Tes</option>'+
                                    '</select>'+
                                '</td>'+
                                '<td class="p-2">'+
                                    '<div class="activity_cell"></div>'+
                                '</td>'+
                                '<td class="p-2 text-center">'+
                                    '<div class="trainer_cell"></div>'+
                                '</td>'+
                                // '<td class="p-2 text-center">'+
                                //     '<div class="duration_cell"></div>'+
                                // '</td>'+
                                '<td class="text-center">'+
                                    '<button type="button" class="font-medium text-red-400 dark:text-red-200 hover:underline remove_row">Hapus</button>'+
                                '</td>'+
                            '</tr>';
        break;
        case 'pretests_table':
            var row_html =  '<tr>'+
                                '<td class="row_index text-center"></td>'+
                                '<td class="p-2">'+
                                    '<select style="width: 100%" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" name="materials[]" type="text"></select>'+
                                '</td>'+
                                '<td class="p-2 text-center">'+

                                '</td>'+
                                '<td class="text-center">'+
                                    '<button type="button" class="font-medium text-red-400 dark:text-red-200 hover:underline remove_row">Hapus</button>'+
                                '</td>'+
                            '</tr>';
        break;
    }
    table.find('tbody').append(row_html);
    update_dynaTable_index(table);
    var lastRow = table.find('tbody tr').last();
    var lastRowIndex = lastRow.index();
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
                    delay: 500,
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
                                    text: item.Employee_name,
                                    division: item.Organization
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
        case 'class_activity_table':
            tinySkeleton(table.find('tbody tr:last').find('div.activity_cell'));
            tinySkeleton(table.find('tbody tr:last').find('div.trainer_cell'));
            if (typeof window.asyncActivity !== 'undefined') {
                var async = window.asyncActivity;
            }else{
                var async = true;
            }
            var studiesRequest = $.ajax({
                async: async,
                type: "GET",
                url: "{{route('classes.all_studies')}}",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                dataType: "JSON",
                success: function (response) {
                    // console.log(response);
                    table.find('tbody tr:eq('+lastRowIndex+')').find('div.activity_cell').empty().html('<select style="width: 100%; height: 100px;" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" name="activity[]" type="text"></select>');
                    var html = '';
                    for(var keys in response){
                        html += '<option value="'+response[keys].id+'" data-tipe="1">'+response[keys].study_material_title+'</option>';
                    }
                    table.find('tbody tr:eq('+lastRowIndex+')').find('select[name="activity[]"]').append(html);
                    table.find('tbody tr:eq('+lastRowIndex+')').find('select[name="activity[]"]').select2({
                        placeholder: "Pilih materi...",
                        allowClear: true
                    });
                }
            });
            var trainersRequest = $.ajax({
                async: async,
                type: "GET",
                url: "{{route('classes.all_trainers')}}",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                dataType: "JSON",
                success: function (response) {
                    // console.log(response);
                    table.find('tbody tr:eq('+lastRowIndex+')').find('div.trainer_cell').empty().html('<select style="width: 100%" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" name="trainer[]" type="text"></select>');
                    var html = '';
                    for(var keys in response){
                        html += '<option value="'+response[keys].id+'">'+response[keys].Employee_name+'</option>';
                    }
                    table.find('tbody tr:eq('+lastRowIndex+')').find('select[name="trainer[]"]').append(html);
                    table.find('tbody tr:eq('+lastRowIndex+')').find('select[name="trainer[]"]').select2({
                    placeholder: "Pilih trainer...",
                        allowClear: true
                    });
                }
            });
        break;
        case 'pretests_table':
            table.find('tbody tr:last').find('select[name="materials[]"]').select2({
                placeholder: 'Pilih Pre-test',
                allowClear: true,
                minimumInputLength: 3, // only start searching when the user has input 3 or more characters
                ajax: {
                    async: false,
                    url: "{{ route('classes.pretests_selectpicker') }}",
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
                                    id: item.id,
                                    text: item.test_name,
                                    tipe: item.tipe,
                                    jumlah_soal: item.jumlah_soal
                                }
                            })
                        };
                    },
                    cache: true
                }
            })
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
        confirmButtonText: "Ya",
        showDenyButton: true,
        denyButtonText: "Tidak",
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
    var detailRow = object.closest('tr').nextAll('.class_detail:first'); // Get the next detail row
    // console.log(detailRow)

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

function tinySkeleton(object){
    // Show Tailwind skeleton loader
    var skeletonLoader = `
            <div class="space-y-4 animate-pulse">
                <div class="h-4 bg-gray-300 rounded w-3/4"></div>
            </div>`;
    object.html(skeletonLoader);
}

function smallSkeleton(object){
    // Show Tailwind skeleton loader
    var skeletonLoader = `
            <div class="space-y-4 animate-pulse">
                <div class="h-4 bg-gray-300 rounded w-3/4"></div>
                <div class="h-4 bg-gray-300 rounded w-full"></div>
                <div class="h-4 bg-gray-300 rounded w-5/6"></div>
            </div>`;
    object.html(skeletonLoader);
}
function mediumSkeleton(object){
    // Show Tailwind skeleton loader
    var skeletonLoader = `
            <div class="space-y-4 animate-pulse">
                <div class="h-4 bg-gray-300 rounded w-3/4"></div>
                <div class="h-4 bg-gray-300 rounded w-full"></div>
                <div class="h-4 bg-gray-300 rounded w-5/6"></div>
                <div class="h-4 bg-gray-300 rounded w-3/4"></div>
                <div class="h-4 bg-gray-300 rounded w-full"></div>
                <div class="h-4 bg-gray-300 rounded w-5/6"></div>
            </div>`;
    object.html(skeletonLoader);
}
function largeSkeleton(object){
    // Show Tailwind skeleton loader
    var skeletonLoader = `
            <div class="space-y-4 animate-pulse">
                <div class="h-4 bg-gray-300 rounded w-3/4"></div>
                <div class="h-4 bg-gray-300 rounded w-full"></div>
                <div class="h-4 bg-gray-300 rounded w-5/6"></div>
                <div class="h-4 bg-gray-300 rounded w-3/4"></div>
                <div class="h-4 bg-gray-300 rounded w-full"></div>
                <div class="h-4 bg-gray-300 rounded w-5/6"></div>
                <div class="h-4 bg-gray-300 rounded w-3/4"></div>
                <div class="h-4 bg-gray-300 rounded w-full"></div>
                <div class="h-4 bg-gray-300 rounded w-5/6"></div>
            </div>`;
    object.html(skeletonLoader);
}
</script>
