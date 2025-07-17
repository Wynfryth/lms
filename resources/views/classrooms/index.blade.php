<x-app-layout>
    <x-slot name="header">
        <h6><a href="{{ route('classrooms', ['class_id' => $class[0]->classId, 'role' => $role]) }}" class="mb-2 text-base font-bold tracking-tight text-gray-900 dark:text-white hover:underline">{{$class[0]->class_title}}</a></h6>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-3">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="detail_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                @switch($role)
                                    @case('Student')
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-center">
                                            #
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">
                                            Aktifitas
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">
                                            Tipe
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">
                                            Nilai
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">
                                        </th>
                                    </tr>
                                    @break
                                    @case('Instructor')
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            #
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Aktifitas
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">
                                            Tipe
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">
                                            Nilai
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center">
                                        </th>
                                    </tr>
                                    @break
                                    @default

                                @endswitch
                            </thead>
                            <tbody>
                                @if ($class[0]->is_released == 1)
                                    @forelse ($class as $index => $classDetail)
                                        <tr>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                                {{ $index+1 }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $classDetail->study_material_title ?? $classDetail->test_name }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                {{ $classDetail->activity_type }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                {{ $classDetail->test_score ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @php
                                                    switch($classDetail->activity_type){
                                                        case "Materi":
                                                            $hrefLink = route('studySessions', ['studyId' => $classDetail->studyId, 'scheduleId' => $classDetail->activityId]);
                                                        break;
                                                        case "Tes":
                                                            $hrefLink = route('testSessions', ['testId' => $classDetail->testId, 'scheduleId' => $classDetail->activityId]);
                                                        break;
                                                    }
                                                @endphp
                                                <a type="button" class="font-medium text-blue-600 dark:text-green-500 hover:underline" href="{{$hrefLink}}">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty

                                    @endforelse
                                @else
                                <h6>Mohon maaf kelas belum dirilis</h6>
                                @endif
                            </tbody>
                        </table>
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
        var url = "{{route('classrooms.getSessionSchedule', ['sessionId' => ':sessionId', 'role' => ':role'])}}";
        url = url.replace(':sessionId', sessionId);
        url = url.replace(':role', '{{$role}}');

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
