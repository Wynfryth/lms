<style>
     #countdown {
        font-size: 1em;
        color: #333;
    }
    /* Custom CSS for alphabetic list */
    .alphabetic-list {
        list-style-type: upper-alpha !important; /* Change to lower-alpha for lowercase letters */
    }
</style>
<x-app-layout>
    <x-slot name="header">
        {{-- <div id="countdown"></div> --}}
        {{-- <h6><a href="#" class="mb-2 text-base font-bold tracking-tight text-gray-900 dark:text-white hover:underline">{{$questions[0]->test_name}}</a></h6> --}}
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h6 class="text-center font-bold">HASIL TEST</h6>
                <h6 class="text-center">{{$testResultDetail[0]->test_name}}</h6>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="resultTable1" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border shadow-md">
                            <tbody class="text-xs border">
                                <tr class="border">
                                    <th width="40%" scope="col" class="text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400 px-6 py-3 text-center uppercase border">
                                        Total Soal
                                    </th>
                                    <td class="px-6 py-2 text-center text-gray-600 font-bold border">
                                        {{ $testResult->total_questions }}
                                    </td>
                                </tr>
                                <tr class="border">
                                    <th scope="col" class="text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400 px-6 py-3 text-center uppercase border">
                                        Benar
                                    </th>
                                    <td class="px-6 py-2 text-center text-green-600 font-bold border">
                                        {{ $testResult->total_correct }}
                                    </td>
                                </tr>
                                <tr class="border">
                                    <th scope="col" class="text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400 px-6 py-3 text-center uppercase border">
                                        Salah
                                    </th>
                                    <td class="px-6 py-2 text-center text-red-600 font-bold border">
                                        {{ $testResult->total_incorrect }}
                                    </td>
                                </tr>
                                <tr class="border">
                                    <th scope="col" class="text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400 px-6 py-3 text-center uppercase border">
                                        Tidak Dijawab
                                    </th>
                                    <td class="px-6 py-2 text-center text-gray-600 font-bold border">
                                        {{ $testResult->total_not_answered }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="resultTable2" class="w-full h-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border shadow-md">
                            <tbody class="text-xs">
                                <tr class="border">
                                    <th width="50%" scope="col" class="text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400 px-6 py-3 text-center uppercase border">
                                        Poin Hasil
                                    </th>
                                    <th scope="col" class="text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400 px-6 py-3 text-center uppercase border">
                                        Batas Poin
                                    </th>
                                </tr>
                                <tr class="border">
                                    @if (intval($testResult->result_point) >= intval($testResultDetail[0]->pass_point))
                                    <td class="px-6 py-2 text-center text-green-500 text-6xl font-bold border" rowspan="3">
                                        @if (intval($testResult->result_point) == intval($testResult->max_point))
                                        <svg class="w-6 h-6 text-green-700 dark:text-white float-right" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7.171 12.906-2.153 6.411 2.672-.89 1.568 2.34 1.825-5.183m5.73-2.678 2.154 6.411-2.673-.89-1.568 2.34-1.825-5.183M9.165 4.3c.58.068 1.153-.17 1.515-.628a1.681 1.681 0 0 1 2.64 0 1.68 1.68 0 0 0 1.515.628 1.681 1.681 0 0 1 1.866 1.866c-.068.58.17 1.154.628 1.516a1.681 1.681 0 0 1 0 2.639 1.682 1.682 0 0 0-.628 1.515 1.681 1.681 0 0 1-1.866 1.866 1.681 1.681 0 0 0-1.516.628 1.681 1.681 0 0 1-2.639 0 1.681 1.681 0 0 0-1.515-.628 1.681 1.681 0 0 1-1.867-1.866 1.681 1.681 0 0 0-.627-1.515 1.681 1.681 0 0 1 0-2.64c.458-.361.696-.935.627-1.515A1.681 1.681 0 0 1 9.165 4.3ZM14 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                                        </svg>
                                        @endif
                                    @else
                                    <td class="px-6 py-2 text-center text-red-500 text-6xl font-bold border" rowspan="3">
                                    @endif
                                        {{ $testResult->result_point }}
                                    </td>
                                    <td class="px-6 py-2 text-center border">
                                        {{ $testResultDetail[0]->pass_point }}
                                    </td>
                                </tr>
                                <tr class="border">
                                    <th scope="col" class="text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400 px-6 py-3 text-center uppercase border">
                                        Poin Maksimal
                                    </th>
                                </tr>
                                <tr class="border">
                                    <td class="px-6 py-2 text-center border">
                                        {{ $testResult->max_point }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex justify-center">
                    <a href="{{route('classrooms', $testResultDetail[0]->class_id)}}" class="border text-center rounded w-full bg-blue-500 hover:bg-blue-400 text-white py-1 mt-2">Kembali ke kelas</a>
                </div>
                <h6 class="text-center font-bold mt-4 mb-2 hidden">DETAIL</h6>
                <div class="grid grid-cols-2 gap-4 hidden">
                    @php
                        $questionId = 0;
                        $sequence = 1;
                    @endphp
                    @forelse ($testResultDetail as $detail)
                        @if ($detail->questionId != $questionId)
                            @if ($questionId != 0)
                                    </ol>
                                </div>
                            </div>
                            @endif
                            <div class="question">
                                <span class="font-semibold">{{$sequence}}. {{$detail->question}}</span>&emsp;<span>{{'('.$detail->points.' Poin)'}}</span>
                                <div class="m-2">
                                    <ol class="alphabetic-list list-decimal pl-10">
                                    @php
                                        $questionId = $detail->questionId;
                                        $sequence++;
                                    @endphp
                        @endif
                        @if ($detail->correct_status == 1)
                            @if ($detail->studentAnswerId != null)
                            <li class="my-3 border rounded bg-green-300">
                                {{$detail->answer}}
                                <svg class="w-6 h-6 text-green-600 dark:text-white float-right" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
                                </svg>
                            </li>
                            @else
                            <li class="my-3 border rounded bg-green-300">{{$detail->answer}}</li>
                            @endif
                        @else
                            @if ($detail->studentAnswerId != null)
                            <li class="my-3 border rounded bg-red-300">
                                {{$detail->answer}}
                                <svg class="w-6 h-6 text-red-600 dark:text-white float-right" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                                </svg>
                            </li>
                            @else
                            <li class="my-3 border rounded bg-white">{{$detail->answer}}</li>
                            @endif
                        @endif
                    @empty

                    @endforelse
                </div>
                {{-- {{var_dump($testResultDetail)}} --}}
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function () {
        window.history.pushState(null, "", window.location.href);
        window.addEventListener("popstate", function () {
            window.history.pushState(null, "", window.location.href);
        });
    });
</script>
