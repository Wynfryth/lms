<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kategori Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="px-12">
            <x-table>
                <x-slot name="header">
                    <x-table-column>Name</x-table-column>
                    <x-table-column>SKU</x-table-column>
                    <x-table-column>Category</x-table-column>
                    <x-table-column>Status</x-table-column>
                </x-slot>
                @php
                    $products = [
                        1,
                        2,
                        3,
                        4,
                        5,
                        6,
                        7,
                        8,
                        9
                    ];
                @endphp
                @foreach($products as $product)
                    <tr>
                        <x-table-column>{{ $product; }}</x-table-column>
                        <x-table-column>{{-- $product->sku --}}</x-table-column>
                        <x-table-column>{{-- $product->category --}}</x-table-column>
                        <x-table-column>{{-- $product->status ? 'Active' : 'Not Active' --}}</x-table-column>
                    </tr>
                @endforeach
            </x-table>
        </div>
       
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Ini adalah halaman edit konten kategori kelas yey!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>