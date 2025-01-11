<x-app-layout>
    <x-slot name="header">
        {{-- {{dd($study)}} --}}
        <h6><a href="#" class="mb-2 text-base font-bold tracking-tight text-gray-900 dark:text-white hover:underline">{{$study[0]->study_material_title.' > '.$file[0]->filename}}</a></h6>
    </x-slot>

    <div class="p-4">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4 space-y-2">
            <div style="width: 100%; max-width: 560px; margin: 0 auto;">
                {!! $file[0]->attachment !!}
            </div>
        </div>
    </div>
</x-app-layout>
