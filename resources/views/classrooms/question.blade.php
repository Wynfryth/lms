<x-app-layout>
    <x-slot name="header">
        {{-- <h6><a href="{{ route('testSessions', $test->testId) }}" class="mb-2 text-base font-bold tracking-tight text-gray-900 dark:text-white hover:underline">{{$test->test_name}}</a></h6> --}}
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                Pertanyaan: <br/>
                {{$question[0]->question}}<br/>
                @forelse ($question as $answer)
                    <input type="radio" name="{{$answer->questionId}}" value="{{$answer->answerId}}"> {{$answer->answer}}<br/>
                @empty

                @endforelse
                {{-- Soal: {{$test->total_questions}}<br/>
                Poin maksimal: {{$test->total_points}}<br/>
                Durasi Waktu: {{$test->estimated_time}}<br/>
                @php
                    $questionIds = explode(',', $test->questionId);
                @endphp
                <x-primary-button type="button" href="{{route('question', $test->testId, $questionIds[0], 1)}}">LANJUT</x-primary-button> --}}
            </div>
        </div>
    </div>
</x-app-layout>
