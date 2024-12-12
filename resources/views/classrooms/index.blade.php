<x-app-layout>
    <x-slot name="header">
        <h6><a href="{{ route('classrooms', $class[0]->classId) }}" class="mb-2 text-base font-bold tracking-tight text-gray-900 dark:text-white hover:underline">{{$class[0]->class_title}}</a></h6>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-3">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto text-gray-900 dark:text-gray-100">
                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="sessions-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" role="tablist">
                            @forelse ($class as $classDetail)
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg classSession" id="{{$classDetail->sessionId}}" data-tabs-target="#div_{{$classDetail->sessionId}}" type="button" role="tab" aria-controls="profile" aria-selected="false">{{$classDetail->session_name}}</button>
                            </li>
                            @empty

                            @endforelse
                        </ul>
                    </div>
                    <div id="sessions-tab-content">
                        @forelse ($class as $classDetail)
                        <div class="hidden p-1 rounded-lg" id="div_{{$classDetail->sessionId}}" role="tabpanel" aria-labelledby="{{$classDetail->sessionId}}-tab">
                            <div class="grid lg:grid-cols-3 sm:grid-cols-1 gap-4">
                                <div class="flex items-center gap-2 border-b-1 mb-3">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                                    </svg>
                                    {{$classDetail->trainer_name}}
                                </div>
                                <div class="flex items-center gap-2 border-b-1 mb-3">
                                    <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M5 9a7 7 0 1 1 8 6.93V21a1 1 0 1 1-2 0v-5.07A7.001 7.001 0 0 1 5 9Zm5.94-1.06A1.5 1.5 0 0 1 12 7.5a1 1 0 1 0 0-2A3.5 3.5 0 0 0 8.5 9a1 1 0 0 0 2 0c0-.398.158-.78.44-1.06Z" clip-rule="evenodd"/>
                                    </svg>
                                    {{$classDetail->location_type}}
                                </div>
                            </div>
                            <div id="sessionSchedule_{{$classDetail->sessionId}}"></div>
                            {{-- <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">{{$classDetail->session_name}} tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p> --}}
                        </div>
                        @empty

                        @endforelse
                    </div>
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
        $('.classSession:first').trigger('click');
    });
    $(document).off('click', '.classSession').on('click', '.classSession', function(){
        var sessionId = $(this).attr('id');
        var url = "{{route('classrooms.getSessionSchedule', ':sessionId')}}";
        url = url.replace(':sessionId', sessionId);

        largeSkeleton($(document).find('div#sessionSchedule_' + sessionId));

        $.ajax({
            type: "GET",
            url: url,
            data: {
                _token: '{{csrf_token()}}',
            },
            success: function (response) {
                $(document).find('div#sessionSchedule_'+sessionId).html(response);
            }
        });
    })
</script>
