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
        {{-- <title>LMS - Gacoan Academy</title> --}}

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
$(document).off('click', '#dark-toggle').on('click', '#dark-toggle', function(){
    var html = $('html');
    if(localStorage.getItem('dark') == 'false'){
        localStorage.setItem('dark', true);
        html.addClass('dark');
    }else if(localStorage.getItem('dark') == 'true'){
        localStorage.setItem('dark', false);
        html.removeClass('dark');
    }
})
if(localStorage.getItem('dark') == 'true'){
    $('html').addClass('dark');
}else{
    $('html').removeClass('dark');
}
</script>
