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
    </style>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
        <title>LMS - Gacoan Academy</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/jqueryui@1.11.1/jquery-ui.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.min.css">
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    </head>

    {{-- <div id="loading" class="text-center bg-white z-50">
        <div role="status" class="my-20">
            <svg aria-hidden="true" class="inline w-28 h-28 text-gray-200 animate-spin dark:text-gray-600 fill-purple-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div> --}}
    <div id="loading" class="text-center bg-white">
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
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jqueryui@1.11.1/jquery-ui.min.js"></script>
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
</script>
