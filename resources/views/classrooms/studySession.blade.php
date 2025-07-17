<x-app-layout>
    <x-slot name="header">
        {{-- {{dd($study)}} --}}
        <h6><a href="{{route('studySessions', ['studyId' => $studyId, 'scheduleId' => $scheduleId])}}" class="mb-2 text-base font-bold tracking-tight text-gray-900 dark:text-white hover:underline">{{$study[0]->study_material_title  }}</a></h6>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h6 class="text-center font-semibold mb-3">Materi: {{$study[0]->study_material_title}}</h6>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table id="detail_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Nama Pembelajaran
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Nama File
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Tipe
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($study as $index => $attachment)
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="text-center" width="10%">{{$index+1}}</td>
                                    <td class="text-center">{{$attachment->name}}</td>
                                    <td class="text-center font-semibold text-blue-500 hover:underline">
                                        @php
                                            if(substr($attachment->attachment, 0, 5) == 'ytube'){
                                                $href = route('studySessions.studyMaterialPlayback', ['scheduleId' => $scheduleId, 'attachmentId' => $attachment->attachment, 'attachmentIndex' => $index, 'attachmentOri' => $attachment->attachmentId]);
                                            }else{
                                                $href = route('studySessions.studyMaterialFile', ['scheduleId' => $scheduleId, 'attachmentId' => $attachment->attachmentId, 'attachmentIndex' => $index]);
                                            }
                                        @endphp
                                        <a href="{{ $href }}" target="_blank" style="display: inline-flex; align-items: center; gap: 4px;">
                                            {{$attachment->filename}}
                                            <svg class="w-5 h-5 text-blue-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 14v4.833A1.166 1.166 0 0 1 16.833 20H5.167A1.167 1.167 0 0 1 4 18.833V7.167A1.166 1.166 0 0 1 5.167 6h4.618m4.447-2H20v5.768m-7.889 2.121 7.778-7.778"/>
                                            </svg>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if (substr($attachment->attachment, 0, 5) == 'ytube')
                                            Video
                                        @else
                                            File
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="text-center text-red-500 font-bold">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @php
                    // $questionIds = explode(',', $study->questionId);
                @endphp
                {{-- <a class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" type="button" href="{{route('testSessions.question', ['testId' => $test->testId, 'questionId' => $questionIds[0], 'questionOrder' => 1])}}">LANJUT</a> --}}
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://h5p.org/sites/all/modules/h5p/library/js/h5p-resizer.js" charset="UTF-8"></script>

<script>
    $(document).ready(function () {
        const iframe = document.querySelector("iframe"); // Selects the first (and only) iframe

        // Option 1: Directly set width and height attributes
        iframe.width = "1000";
        iframe.height = "1000";

        // Option 2 (alternative): Use style to set CSS width and height
        // iframe.style.width = "1000px";
        // iframe.style.height = "1000px";
    });
</script>
