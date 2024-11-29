<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelas > Kategori Kelas') }}
        </h2> --}}
        <!-- Breadcrumb -->
        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>
                    </svg>
                    &nbsp;&nbsp;Jadwal Kelas Diampu
                    </a>
                </li>
                {{-- <li>
                    <div class="flex items-center">
                    <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('trainerschedules') }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Jadwal Instruktur</a>
                    </div>
                </li> --}}
            </ol>
        </nav>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-3">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto text-gray-900 dark:text-gray-100">
                    <div class="flex items-center mb-2">
                        <span class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Terdaftar</span>
                        <span class="bg-purple-100 text-purple-800 dark:bg-purple-700 dark:text-purple-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Sedang Mengikuti</span>
                        <span class="bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Lulus</span>
                        <span class="bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-300 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Gagal</span>
                        <span class="bg-black text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded">Dibatalkan</span>
                    </div>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
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
        var events = {!! json_encode($events) !!};
        var colors = [];
        var textColors = [];
        var events = events.map(function(item){
            switch(item.is_active){
                case "1":
                    colors.push("#3f83f8");
                    textColors.push("#ffffff");
                break;
                case "0":
                    colors.push("#e11d48");
                    textColors.push("#ffffff");
                break;
            }
            return {
                title: item.session_name+' ('+item.jumlah_peserta+' peserta)',
                start: item.start_effective_date,
                end: item.end_effective_date,
            }
        })
        // console.log(colors);
        const calendarEl = document.getElementById('calendar')
        const calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            initialView: 'dayGridMonth',
            events: events,
            eventBackgroundColor: colors,
            eventTextColor: textColors
        })
        calendar.render()
    });
</script>
