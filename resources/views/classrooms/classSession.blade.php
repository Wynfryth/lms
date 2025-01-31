{{-- {{var_dump($sessionSchedule)}} --}}
{{-- {{$role}} --}}
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table id="detail_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            @switch($role)
                @case('Student')
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aktifitas
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Kategori
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Nilai Tes
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Mulai
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Selesai
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
                        Kategori
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Peserta Selesai
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Mulai
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Selesai
                    </th>
                </tr>
                @break
                @default

            @endswitch

        </thead>
        <tbody>
            @forelse ($sessionSchedules as $index => $schedule)
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $index + $sessionSchedules->firstItem(); }}
                    </th>
                    <td class="px-6 py-4">
                        @php
                            $materialId = $schedule->study_id ?? $schedule->test_id;
                            $sessionRoute = $schedule->study_id ? 'studySessions' : 'testSessions';
                            $sessionMatType = $schedule->study_id ? 'studyId' : 'testId';
                            switch($role){
                                case "Student":
                                    $hrefLink = route($sessionRoute, [$sessionMatType => $materialId, 'scheduleId' => $schedule->schedule_id]);
                                break;
                                case "Instructor":
                                    if($sessionRoute == 'studySessions'){
                                        $hrefLink = route($sessionRoute, [$sessionMatType => $materialId, 'scheduleId' => $schedule->schedule_id]);
                                    }else{
                                        $hrefLink = "#";
                                    }
                                break;
                            }
                        @endphp
                        @if ($schedule->test_is_released === 0)
                            <span>{{ $schedule->study_material_title ?? $schedule->test_name }} </span>&nbsp;<span class="text-red-500">(Belum rilis)</span>
                        @else
                            @if ($schedule->schedule_status == 'OPEN')
                                <a class="hover:underline" href="{{$hrefLink}}">{{ $schedule->study_material_title ?? $schedule->test_name }}</a>
                            @else
                                <a class="hover:underline" href="{{$hrefLink}}">{{ $schedule->study_material_title ?? $schedule->test_name }}</a>
                                {{-- {{ $schedule->study_material_title ?? $schedule->test_name }} --}}
                            @endif
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{ $schedule->type }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @switch($role)
                            @case('Student')
                                @if ($schedule->type == 'Materi')
                                    -
                                @else
                                    @if ($schedule->result_point != null)
                                        @if ($schedule->result_point >= $schedule->pass_point)
                                            <span class="font-bold text-green-500">{{$schedule->result_point}}</span>
                                        @else
                                            <span class="font-bold text-red-500">{{$schedule->result_point}}</span>
                                        @endif
                                    @else
                                        <span>Belum</span>
                                    @endif
                                @endif
                            @break
                            @case('Instructor')
                                Jumlah peserta selesai
                            @break
                            @default

                        @endswitch

                    </td>
                    <td class="px-6 py-4 text-center">
                        {{ date('d/m/Y H:i:s', strtotime($schedule->start_eff_date)) }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{ date('d/m/Y H:i:s', strtotime($schedule->end_eff_date)) }}
                    </td>
                </tr>
            @empty
                <tr class="row_no_data">
                    <td class="text-center py-1" colspan="100%"><span class="text-red-500">Tidak ada data.</span></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-2">
    {{ $sessionSchedules->links(); }}
</div>
