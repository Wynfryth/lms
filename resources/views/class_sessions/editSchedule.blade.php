<div>
    <span>Materi/Tes: {{$schedule->study_material_title ?? $schedule->test_name}}</span>
</div>
<div>
    <span>Deskripsi: {{$schedule->study_material_desc ?? $schedule->test_desc}}</span>
</div>
<div>
    <span>Durasi: {{$schedule->study_estimated_time ?? $schedule->test_estimated_time}}</span>
</div>
<form class="space-y-6" action="{{route('class_sessions.updateSchedule')}}" method="POST">
    @csrf
    <input type="hidden" name="schedule_id" value="{{$scheduleId}}">
    <div class="my-1 grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="start_date" :value="__('Mulai')" />
            <x-text-input id="start_date" name="start_date" type="text" class="mt-1 block w-full flowbite-datepicker" datepicker datepicker-autohide datepicker-orientation="bottom right" datepicker-format="dd-mm-yyyy" value="{{ date('d-m-Y', strtotime($schedule->start_eff_date)) }}"/>
            @error('start_date')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <x-input-label for="start_time" :value="__('Jam')"></x-input-label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <input type="time" id="start_time" name="start_time" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{date('H:i', strtotime($schedule->start_eff_date))}}" required />
            </div>
            @error('start_time')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="my-1 grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="end_date" :value="__('Sampai')" />
            <x-text-input id="end_date" name="end_date" type="text" class="mt-1 block w-full flowbite-datepicker" datepicker datepicker-autohide datepicker-orientation="bottom right" datepicker-format="dd-mm-yyyy" value="{{ date('d-m-Y', strtotime($schedule->end_eff_date)) }}"/>
            @error('end_date')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <x-input-label for="end_time" :value="__('Jam')"></x-input-label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <input type="time" id="end_time" name="end_time" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{date('H:i', strtotime($schedule->end_eff_date))}}" required />
            </div>
            @error('end_time')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>
    </div>
</form>
