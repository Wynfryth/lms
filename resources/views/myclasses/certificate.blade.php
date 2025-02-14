<x-app-layout>
    <x-slot name="header">
        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8 12.732A1.99 1.99 0 0 1 7 13H3v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2h-2a4 4 0 0 1-4-4v-2.268ZM7 11V7.054a2 2 0 0 0-1.059.644l-2.46 2.87A2 2 0 0 0 3.2 11H7Z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M14 3.054V7h-3.8c.074-.154.168-.3.282-.432l2.46-2.87A2 2 0 0 1 14 3.054ZM16 3v4a2 2 0 0 1-2 2h-4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-3Z" clip-rule="evenodd"/>
                    </svg>
                    &nbsp;&nbsp;Kelas Saya
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                    <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Sertifikat</a>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-3">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto text-gray-900 dark:text-gray-100">
                    <div class="w-full p-10 bg-white border-8 border-gray-300 shadow-lg text-center">
                        <h1 class="text-4xl font-bold text-gray-700">Certificate of Completion</h1>
                        <p class="mt-4 text-lg text-gray-600">This is to certify that</p>
                        <h2 class="mt-2 text-3xl font-semibold text-gray-800">{{$certificateData->Employee_name}}</h2>
                        <p class="mt-4 text-lg text-gray-600">has successfully completed the</p>
                        <h3 class="mt-2 text-2xl font-semibold text-gray-700">{{$certificateData->class_title}}</h3>
                        <p class="mt-4 text-lg text-gray-600">with the status of</p>
                        @switch($certificateData->enrollment_status)
                            @case('PASSED')
                                <h3 class="mt-2 text-green-600 text-2xl font-semibold text-gray-700">{{$certificateData->enrollment_status}}</h3>
                            @break
                            @case('FAILED')
                                <h3 class="mt-2 text-red-600 text-2xl font-semibold text-gray-700">{{$certificateData->enrollment_status}}</h3>
                            @break
                            @default

                        @endswitch


                        <div class="flex justify-between mt-8">
                            {{-- <div>
                                <hr class="w-40 border-t border-gray-400">
                                <p class="mt-2 text-gray-600">Instructor</p>
                            </div> --}}
                            <div>
                                <hr class="w-40 border-t border-gray-400">
                                <p class="mt-2 text-gray-600">Director</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
