<a {{!! $attributes->merge(['type' => 'button', 'class' => 'bg-transparent hover:bg-red-700 text-sm text-red-700 font-semibold hover:text-white mx-2 py-1 px-3 border border-red-700 hover:border-transparent rounded-full']) !!}}>
    {{$slot}}
</a>
