<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="p-4 px-0 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @role('Academy Admin')
                    <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-4 mb-4">
                        <x-card-dashboard class="hover:bg-blue-700 bg-white hover:text-blue-600 hover:delay-75 group">
                            <x-slot name="header">
                                <h5
                                    class="text-2xl font-bold tracking-tight dark:text-white text-dark group-hover:text-white group-hover:bg-blue-700 group-hover:delay-75">
                                    Peserta</h5>
                            </x-slot>
                            <x-slot name="detail">
                                <p
                                    class="font-normal dark:text-gray-400 mb-1 text-dark group-hover:text-white group-hover:bg-blue-700 group-hover:delay-75">
                                    Jumlah Peserta Terdaftar
                                </p>
                            </x-slot>
                            <x-slot name="number">
                                <h2
                                    class="text-2xl text-left font-bold tracking-tight text-blue-600 dark:text-white group-hover:text-white group-hover:bg-blue-700 group-hover:delay-75">
                                    122
                                </h2>
                            </x-slot>
                        </x-card-dashboard>
                        <x-card-dashboard class="hover:bg-emerald-700 bg-white hover:text-white group">
                            <x-slot name="header">
                                <h5
                                    class="text-2xl font-bold tracking-tight dark:text-dark text-dark group-hover:text-white group-hover:bg-emerald-700">
                                    Lulus</h5>
                            </x-slot>
                            <x-slot name="detail">
                                <p
                                    class="font-normal dark:text-gray-400 mb-1 text-dark group-hover:text-white group-hover:bg-emerald-700">
                                    Jumlah Peserta Lulus
                                </p>
                            </x-slot>
                            <x-slot name="number">
                                <div class="flex">
                                    <h2
                                        class="text-2xl font-bold tracking-tight text-emerald-600 dark:text-white group-hover:text-white group-hover:bg-emerald-700 flex-1 float-left">
                                        117
                                    </h2>
                                    <h2
                                        class="text-3xl text-center font-bold tracking-tight text-emerald-600 dark:text-white group-hover:text-white group-hover:bg-emerald-700">
                                        95,9 %
                                    </h2>
                                </div>
                            </x-slot>
                        </x-card-dashboard>
                        <x-card-dashboard class="bg-white hover:bg-rose-700 hover:text-white group">
                            <x-slot name="header">
                                <h5
                                    class="text-2xl font-bold tracking-tight dark:text-white text-dark group-hover:text-white group-hover:bg-rose-700">
                                    Gagal</h5>
                            </x-slot>
                            <x-slot name="detail">
                                <p
                                    class="font-normal dark:text-gray-400 mb-1 text-dark group-hover:text-white group-hover:bg-rose-700">
                                    Jumlah Peserta Gagal
                                </p>
                            </x-slot>
                            <x-slot name="number">
                                <div class="flex">
                                    <h2
                                        class="text-2xl font-bold tracking-tight text-rose-600 dark:text-white group-hover:text-white group-hover:bg-rose-700 flex-1 float-left">
                                        5
                                    </h2>
                                    <h2
                                        class="text-3xl text-center font-bold tracking-tight text-rose-600 dark:text-white group-hover:text-white group-hover:bg-rose-700">
                                        4,1 %
                                    </h2>
                                </div>
                            </x-slot>
                        </x-card-dashboard>
                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div id="chart"></div>
                    </div>
                    <h5 class="ml-2 font-bold tracking-tight text-gray-600">Pre-Test</h5>
                    <div
                        class="grid lg:grid-cols-3 sm:grid-cols-2 gap-4 mb-4 bg-sky-100 p-3 border-solid border-1 rounded-md border-sky-500">
                        <x-card-dashboard class="hover:bg-blue-700 bg-white hover:text-blue-600 group">
                            <x-slot name="header">
                                <h5
                                    class="text-2xl font-bold tracking-tight dark:text-white text-dark group-hover:text-white group-hover:bg-blue-700">
                                    Peserta</h5>
                            </x-slot>
                            <x-slot name="detail">
                                <p
                                    class="font-normal dark:text-gray-400 mb-1 text-dark group-hover:text-white group-hover:bg-blue-700">
                                    Jumlah Peserta Terdaftar
                                </p>
                            </x-slot>
                            <x-slot name="number">
                                <h2
                                    class="text-2xl text-left font-bold tracking-tight text-blue-600 dark:text-white group-hover:text-white group-hover:bg-blue-700">
                                    122
                                </h2>
                            </x-slot>
                        </x-card-dashboard>
                        <x-card-dashboard class="hover:bg-emerald-700 bg-white hover:text-white group">
                            <x-slot name="header">
                                <h5
                                    class="text-2xl font-bold tracking-tight dark:text-dark text-dark group-hover:text-white group-hover:bg-emerald-700">
                                    Lulus</h5>
                            </x-slot>
                            <x-slot name="detail">
                                <p
                                    class="font-normal dark:text-gray-400 mb-1 text-dark group-hover:text-white group-hover:bg-emerald-700">
                                    Jumlah Peserta Lulus
                                </p>
                            </x-slot>
                            <x-slot name="number">
                                <div class="flex">
                                    <h2
                                        class="text-2xl font-bold tracking-tight text-emerald-600 dark:text-white group-hover:text-white group-hover:bg-emerald-700 flex-1 float-left">
                                        117
                                    </h2>
                                    <h2
                                        class="text-3xl text-center font-bold tracking-tight text-emerald-600 dark:text-white group-hover:text-white group-hover:bg-emerald-700">
                                        95,9 %
                                    </h2>
                                </div>
                            </x-slot>
                        </x-card-dashboard>
                        <x-card-dashboard class="bg-white hover:bg-rose-700 hover:text-white group">
                            <x-slot name="header">
                                <h5
                                    class="text-2xl font-bold tracking-tight dark:text-white text-dark group-hover:text-white group-hover:bg-rose-700">
                                    Gagal</h5>
                            </x-slot>
                            <x-slot name="detail">
                                <p
                                    class="font-normal dark:text-gray-400 mb-1 text-dark group-hover:text-white group-hover:bg-rose-700">
                                    Jumlah Peserta Gagal
                                </p>
                            </x-slot>
                            <x-slot name="number">
                                <div class="flex">
                                    <h2
                                        class="text-2xl font-bold tracking-tight text-rose-600 dark:text-white group-hover:text-white group-hover:bg-rose-700 flex-1 float-left">
                                        5
                                    </h2>
                                    <h2
                                        class="text-3xl text-center font-bold tracking-tight text-rose-600 dark:text-white group-hover:text-white group-hover:bg-rose-700">
                                        4,1 %
                                    </h2>
                                </div>
                            </x-slot>
                        </x-card-dashboard>
                    </div>
                    <h5 class="ml-2 font-bold tracking-tight text-gray-600">Kelas Training</h5>
                    <div
                        class="grid lg:grid-cols-3 sm:grid-cols-2 gap-4 mb-4 bg-sky-100 p-3 border-solid border-1 rounded-md border-sky-500">
                        <x-card-dashboard class="hover:bg-blue-700 bg-white hover:text-blue-600 group">
                            <x-slot name="header">
                                <h5
                                    class="text-2xl font-bold tracking-tight dark:text-white text-dark group-hover:text-white group-hover:bg-blue-700">
                                    Peserta</h5>
                            </x-slot>
                            <x-slot name="detail">
                                <p
                                    class="font-normal dark:text-gray-400 mb-1 text-dark group-hover:text-white group-hover:bg-blue-700">
                                    Jumlah Peserta Terdaftar
                                </p>
                            </x-slot>
                            <x-slot name="number">
                                <h2
                                    class="text-2xl text-left font-bold tracking-tight text-blue-600 dark:text-white group-hover:text-white group-hover:bg-blue-700">
                                    122
                                </h2>
                            </x-slot>
                        </x-card-dashboard>
                        <x-card-dashboard class="hover:bg-emerald-700 bg-white hover:text-white group">
                            <x-slot name="header">
                                <h5
                                    class="text-2xl font-bold tracking-tight dark:text-dark text-dark group-hover:text-white group-hover:bg-emerald-700">
                                    Lulus</h5>
                            </x-slot>
                            <x-slot name="detail">
                                <p
                                    class="font-normal dark:text-gray-400 mb-1 text-dark group-hover:text-white group-hover:bg-emerald-700">
                                    Jumlah Peserta Lulus
                                </p>
                            </x-slot>
                            <x-slot name="number">
                                <div class="flex">
                                    <h2
                                        class="text-2xl font-bold tracking-tight text-emerald-600 dark:text-white group-hover:text-white group-hover:bg-emerald-700 flex-1 float-left">
                                        117
                                    </h2>
                                    <h2
                                        class="text-3xl text-center font-bold tracking-tight text-emerald-600 dark:text-white group-hover:text-white group-hover:bg-emerald-700">
                                        95,9 %
                                    </h2>
                                </div>
                            </x-slot>
                        </x-card-dashboard>
                        <x-card-dashboard class="bg-white hover:bg-rose-700 hover:text-white group">
                            <x-slot name="header">
                                <h5
                                    class="text-2xl font-bold tracking-tight dark:text-white text-dark group-hover:text-white group-hover:bg-rose-700">
                                    Gagal</h5>
                            </x-slot>
                            <x-slot name="detail">
                                <p
                                    class="font-normal dark:text-gray-400 mb-1 text-dark group-hover:text-white group-hover:bg-rose-700">
                                    Jumlah Peserta Gagal
                                </p>
                            </x-slot>
                            <x-slot name="number">
                                <div class="flex">
                                    <h2
                                        class="text-2xl font-bold tracking-tight text-rose-600 dark:text-white group-hover:text-white group-hover:bg-rose-700 flex-1 float-left">
                                        5
                                    </h2>
                                    <h2
                                        class="text-3xl text-center font-bold tracking-tight text-rose-600 dark:text-white group-hover:text-white group-hover:bg-rose-700">
                                        4,1 %
                                    </h2>
                                </div>
                            </x-slot>
                        </x-card-dashboard>
                        <x-card-dashboard class="bg-cyan-700 hover:bg-white hover:text-cyan-600 group">
                            <x-slot name="header">
                                <div class="flex">
                                    <h5
                                        class="text-2xl font-bold tracking-tight dark:text-white text-white group-hover:text-cyan-600 group-hover:bg-white flex-1 float-left">
                                        Surplus</h5>
                                    <svg class="w-6 h-6 text-gray-800 text-white dark:text-white float-right group-hover:text-cyan-600"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 12h14m-7 7V5" />
                                    </svg>
                                </div>
                            </x-slot>
                            <x-slot name="detail">
                                <p
                                    class="font-normal dark:text-gray-400 mb-1 text-white group-hover:text-cyan-600 group-hover:bg-white">
                                    Penambahan Peserta Bulan Ini
                                </p>
                            </x-slot>
                            <x-slot name="number">
                                <h2
                                    class="text-2xl text-right font-bold tracking-tight text-white dark:text-white group-hover:text-cyan-600 group-hover:bg-white">
                                    4
                                </h2>
                            </x-slot>
                        </x-card-dashboard>
                        <x-card-dashboard class="bg-orange-700 hover:bg-white hover:text-orange-600 group">
                            <x-slot name="header">
                                <div class="flex">
                                    <h5
                                        class="text-2xl font-bold tracking-tight dark:text-white text-white group-hover:text-orange-600 group-hover:bg-white flex-1 float-left">
                                        Defisit</h5>
                                    <svg class="w-6 h-6 text-gray-800 text-white dark:text-white float-right group-hover:text-orange-600"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 12h14" />
                                    </svg>
                                </div>
                            </x-slot>
                            <x-slot name="detail">
                                <p
                                    class="font-normal dark:text-gray-400 mb-1 text-white group-hover:text-orange-600 group-hover:bg-white">
                                    Pengurangan Peserta Bulan Ini
                                </p>
                            </x-slot>
                            <x-slot name="number">
                                <h2
                                    class="text-2xl text-right font-bold tracking-tight text-white dark:text-white group-hover:text-orange-600 group-hover:bg-white">
                                    11
                                </h2>
                            </x-slot>
                        </x-card-dashboard>
                        <x-card-dashboard class="bg-slate-700 hover:bg-white hover:text-slate-600 group">
                            <x-slot name="header">
                                <div class="flex">
                                    <h5
                                        class="text-2xl font-bold tracking-tight dark:text-white text-white group-hover:text-slate-600 group-hover:bg-white flex-1 float-left">
                                        Resign</h5>
                                    <svg class="w-6 h-6 text-gray-800 text-white dark:text-white float-right group-hover:text-slate-600"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                    </svg>

                                </div>
                            </x-slot>
                            <x-slot name="detail">
                                <p
                                    class="font-normal dark:text-gray-400 mb-1 text-white group-hover:text-slate-600 group-hover:bg-white">
                                    Jumlah Peserta Resign
                                </p>
                            </x-slot>
                            <x-slot name="number">
                                <h2
                                    class="text-2xl text-right font-bold tracking-tight text-white dark:text-white group-hover:text-slate-600 group-hover:bg-white">
                                    0
                                </h2>
                            </x-slot>
                        </x-card-dashboard>
                    </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
$(document).ready(function () {
    cleanlinessGraph();
});
function cleanlinessGraph(){
    var options = {
          series: [{
          name: 'Peserta',
          data: [122, 150, 133, 145, 111, 124, 124, 125, 167, 100, 97]
        }, {
          name: 'Lulus',
          data: [117, 141, 123, 140, 100, 120, 124, 124, 167, 95, 96]
        }, {
          name: 'Gagal',
          data: [5, 9, 10, 5, 11, 4, 0, 1, 0, 5, 1]
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        },
        yaxis: {
          title: {
            text: 'Orang'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " orang"
            }
          }
        },
        title: {
            text: 'Tingkat Kelulusan Peserta 2024 (dummy)',
            align: 'center',
            margin: 10,
            offsetX: 0,
            offsetY: 0,
            floating: false,
            style: {
            fontSize:  '14px',
            fontWeight:  'bold',
            fontFamily:  undefined,
            color:  '#263238'
            },
        }
    };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
}
</script>
