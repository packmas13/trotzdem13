@props(['banner', 'property' => 'name'])

<span {{ $attributes->merge(['class' => 'px-2 py-1 rounded-full inline-block bg-' . $banner->color . '-light' . ' text-' . $banner->color . '-dark']) }}>
    {{$banner->$property}}
</span>
