<a {{!! $attributes->merge(['type' => 'button', 'class' => 'bg-transparent hover:bg-cyan-700 text-sm text-cyan-700 font-semibold hover:text-white mx-2 py-1 px-3 border border-cyan-700 hover:border-transparent rounded-full']) !!}}>
    {{$slot}}
</a>
