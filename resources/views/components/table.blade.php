<table {!! $attributes->merge(['class' => 'w-full whitespace-no-wrap table-auto border-collapse border border-black text-black dark:border-white dark:text-white']) !!}>
    <thead class="bg-black dark:bg-white text-white dark:text-dark">
        <tr class="font-bold text-center">
            {{$header}}
        </tr>
    </thead>
    <tbody>
        {{$slot}}
    </tbody>
</table>