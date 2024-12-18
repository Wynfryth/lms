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
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table id="resultTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Poin Hasil
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Poin Minimum
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Poin Sempurna
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <td class="px-6 py-2 text-center">
                                    {{ $testResult->result_point }}
                                </td>
                                <td class="px-6 py-2 text-center">
                                    {{ $testResultDetail[0]->pass_point }}
                                </td>
                                <td class="px-6 py-2 text-center">
                                    {{ $testResult->max_point }}
                                </td>
                            </tr>
                            @if (intval($testResult->result_point) > intval($testResultDetail[0]->pass_point))
                            <tr>
                                <td class="px-6 py-2 text-center text-green-500 font-bold" colspan="100%">
                                    LULUS
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td class="px-6 py-2 text-center text-red-500 font-bold" colspan="100%">
                                    GAGAL
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <h6 class="text-center font-bold mt-4 mb-2">DETAIL</h6>
                <div class="grid grid-cols-2 gap-4">
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
                                <span class="font-semibold">{{$sequence}}. {{$detail->question}}</span>
                                <div class="m-2">
                                    <ol class="alphabetic-list list-decimal pl-10">
                                    @php
                                        $questionId = $detail->questionId;
                                        $sequence++;
                                    @endphp
                        @endif
                        @if ($detail->correct_status == 1)
                            <li class="my-3 border rounded bg-green-300">{{$detail->answer}}</li>
                        @else
                            @if ($detail->studentAnswerId != null)
                            <li class="my-3 border rounded bg-red-300">{{$detail->answer}}</li>
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
