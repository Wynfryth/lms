<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')
    <title>LMS by PPA</title>
</head>
<body class="font-Outfit">
    {{-- Header --}}
    <header>
        <nav class="container flex items-center py-1 mt-4 sm:mt-12">
            <div class="py-1">
                <img src="{{url('/gacoan-academy-logo.png')}}" class="w-1/3 h-1/3" alt="">
            </div>
            <ul class="hidden sm:flex flex-1 justify-end items-center gap-12 text-bookmark-blue uppercase text-xs">
                <li class="cursor-pointer text-bookmark-red">Beranda</li>
                <li class="cursor-pointer">Kursus</li>
                <li class="cursor-pointer">Kelas</li>
                <li class="cursor-pointer">Kuis</li>
                <li class="cursor-pointer">Instruktur</li>
                <li class="cursor-pointer">Kontak</li>
                <a href="{{url('/login')}}"><button type="button" class="btn btn-red hover:bg-bookmark-white hover:text-black rounded-md px-7 py-3 uppercase">Masuk</button></a>
            </ul>
            <div class="flex sm:hidden flex-1 justify-end">
                <i class="text-xl fas fa-bars"></i>
            </div>
        </nav>
    </header>

    {{-- Hero --}}
    <section class="relative">
        <div class="container flex flex-col-reverse lg:flex-row items-center gap-12 mt-14 lg:mt-14">
            {{-- Content --}}
            <div class="flex flex-1 flex-col items-center lg:items-start">
                <h2 class="text-bookmark-blue text-3xl md:text-4 lg:text-5xl text-center lg:text-left mb-6">
                    Learning Management System
                </h2>
                <p class="text-bookmark-red text-lg text-center lg:text-left mb-6">
                    Bangun kemampuan dengan kursus, sertifikasi, dan gelar dari pelatihan terbaik oleh PPA.
                </p>
                <div class="flex flex-wrap gap-6">
                    <button type="button" class="btn btn-purple hover:bg-bookmark-white hover:text-black">Daftar</button>
                    <button type="button" class="btn btn-white hover:bg-bookmark-purple hover:text-white">Kontak kami</button>
                </div>
            </div>
            {{-- Image --}}
            <div class="flex justify-center flex-1 mb-10 md:mb-16 lg:mb-0 z-10">
                <img class="w-5/6 h-5/6 sm:w-3/4 sm:h-3/4 md:w-full md:h-3/4" src="{{url('/example-img/hero-bg.png')}}" alt="">
            </div>
        </div>
        {{-- Rounded Rectangle --}}
        <div class="hidden md:block overflow-hidden bg-bookmark-purple rounded-l-full absolute h-80 w-2/4 top-32 right-0 lg:-bottom-28 lg:top-36"></div>
    </section>

    {{-- Features --}}
    <section class="bg-bookmark-white py-20 mt-20 lg:mt-60">
        {{-- Heading --}}
        <div class="sm:w-3/4 lg:w-5/12 mx-auto px-2">
            <h1 class="text-3xl text-center text-bookmark-blue">Fitur</h1>
            <p class="text-center text-bookmark-grey mt-4">
                Temukan video kursus pada hampir semua topik untuk membangun karir. Nikmati fitur penuh dari situs ini.
            </p>
        </div>
        {{-- Feature #1 --}}
        <div class="relative mt-20 lg:mt-24">
            <div class="container flex flex-col lg:flex-row items-center justify-center gap-x-24">
                {{-- Image--}}
                <div class="flex flex-1 justify-center z-10 mb-10 lg:mb-0">
                    <img class="w-5/6 h-5/6 sm:w-3/4 sm:h-3/4 md:w-full md:h-3/4" src="{{url('/example-img/illustration-features-tab-1.png')}}" alt="">
                </div>
                {{-- Content --}}
                <div class="flex flex-1 flex-col items-center lg:items-start">
                    <h1 class="text-3xl text-bookmark-blue">Tingkatkan Kemampuan</h1>
                    <p class="text-bookmark-grey my-4 text-center lg:text-left sm:w-3/4 lg:w-full">
                        Kegiatan belajar-mengajar dengan kemungkinan tak terbatas. Pilih dari lebih dari 1000 materi pelatihan.
                    </p>
                    <button type="button" class="btn btn-purple hover:bg-bookmark-white hover:text-black">Info</button>
                </div>
            </div>
            {{-- Rounded Rectangle --}}
            <div class="hidden lg:block overflow-hidden bg-bookmark-purple rounded-r-full absolute h-80 w-2/4 -bottom-24 -left-36"></div>
        </div>
    </section>
</body>
</html>