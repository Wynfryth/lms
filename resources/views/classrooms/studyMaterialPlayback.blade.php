<x-app-layout>
    <x-slot name="header">
        {{-- {{dd($study)}} --}}
        <h6><a href="#" class="mb-2 text-base font-bold tracking-tight text-gray-900 dark:text-white hover:underline">{{$study[0]->study_material_title}}</a></h6>
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
