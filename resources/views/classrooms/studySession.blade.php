<x-app-layout>
    <x-slot name="header">
        {{-- {{dd($study)}} --}}
        <h6><a href="{{ route('studySessions', $study[0]->studyId) }}" class="mb-2 text-base font-bold tracking-tight text-gray-900 dark:text-white hover:underline">{{$study[0]->study_material_title  }}</a></h6>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                Materi: {{$study[0]->study_material_title}}<br/>
                Pembelajaran: {{$study[0]->name}}<br/>
                File pembelajaran: {{$study[0]->filename}}<br/>
                @php
                    // $questionIds = explode(',', $study->questionId);
                @endphp
                {{-- <a class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" type="button" href="{{route('testSessions.question', ['testId' => $test->testId, 'questionId' => $questionIds[0], 'questionOrder' => 1])}}">LANJUT</a> --}}
            </div>
        </div>
    </div>
</x-app-layout>
