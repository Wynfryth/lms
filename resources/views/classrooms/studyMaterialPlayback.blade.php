<x-app-layout>
    <x-slot name="header">
        {{-- {{dd($study)}} --}}
        <div class="flex items-center space-x-2">
             @if ($prevAttachment != '')
                @php
                    if($prevType == 'link'){
                        $prevhref = route('studySessions.studyMaterialPlayback', ['scheduleId' => $scheduleId, 'attachmentId' => $prevAttachment->attachment, 'attachmentIndex' => $prevIndex, 'attachmentOri' => $prevIndex]);
                    }else if($prevType == 'file'){
                        $prevhref = route('studySessions.studyMaterialFile', ['scheduleId' => $scheduleId, 'attachmentId' => $prevAttachment->id, 'attachmentIndex' => $prevIndex]);
                    }else{
                        $prevhref = '';
                    }
                @endphp
                <a type="button" href="{{ $prevhref }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14 8-4 4 4 4"/>
                    </svg>
                </a>
            @endif
            <h6><a href="#" class="mb-2 text-base font-bold tracking-tight text-gray-900 dark:text-white hover:underline">{{$study[0]->study_material_title}}</a></h6>
            @if ($nextAttachment != '')
                @php
                    if($nextType == 'link'){
                        $nexthref = route('studySessions.studyMaterialPlayback', ['scheduleId' => $scheduleId, 'attachmentId' => $nextAttachment->attachment, 'attachmentIndex' => $nextIndex, 'attachmentOri' => $nextIndex]);
                    }else if($nextType == 'file'){
                        $nexthref = route('studySessions.studyMaterialFile', ['scheduleId' => $scheduleId, 'attachmentId' => $nextAttachment->id, 'attachmentIndex' => $nextIndex]);
                    }else{
                        $nexthref = '#';
                    }
                @endphp
                <a type="button" href="{{ $nexthref }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>
                    </svg>
                </a>
            @endif
        </div>
    </x-slot>

    <div class="p-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div style="width: 100%; max-width: 560px; margin: 0 auto;">
                <iframe
                    width="800"
                    height="400"
                    src="https://www.youtube.com/embed/{{$videoId}}"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
</x-app-layout>
