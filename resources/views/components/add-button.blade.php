<a {{!! $attributes->merge(['type' => 'button', 'class' => 'bg-white hover:bg-blue-500 text-sm text-blue-500 hover:text-white font-semibold mx-1 py-1 px-3 border border-blue-500 hover:border-transparent rounded']) !!}}>
    {{$slot}}
</a>
