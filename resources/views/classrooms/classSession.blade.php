{{-- {{var_dump($sessionSchedule)}} --}}
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table id="detail_table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                    Mulai
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Selesai
                </th>
            </tr>
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
                            // echo $schedule->schedule_id;
                        @endphp
                        @if ($schedule->schedule_status == 'OPEN')
                            <a class="hover:underline" href="{{route($sessionRoute, [$sessionMatType => $materialId, 'scheduleId' => $schedule->schedule_id])}}">{{ $schedule->study_material_title ?? $schedule->test_name }}</a>
                        @else
                            <a class="hover:underline" href="{{route($sessionRoute, [$sessionMatType => $materialId, 'scheduleId' => $schedule->schedule_id])}}">{{ $schedule->study_material_title ?? $schedule->test_name }}</a>
                            {{-- {{ $schedule->study_material_title ?? $schedule->test_name }} --}}
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{ $schedule->type }}
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
