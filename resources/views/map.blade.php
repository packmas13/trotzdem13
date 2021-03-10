@push('styles')
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css" integrity="sha384-uGgNReQDM4xUjyppNF69a8TECFK/SdZzFxfsfE5e09EDjV/A2ht7nAkKoWUj2dwC" crossorigin="anonymous">
@endpush

@push('scripts')
<script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js" integrity="sha384-0uJ3jJUASu7ZFHSwTzVO6YbgmXvr90z5LzVqYl7iVd4XJYXn94Sdm4JjVjYat8zm" crossorigin="anonymous"></script>

<script>
    mapboxgl.accessToken = 'pk.eyJ1Ijoib2xpdmVycG9vbCIsImEiOiJyQW82a1hjIn0.yK2FfgVuRuX-PTD-HFjueA';
    var map = new mapboxgl.Map({
        container: 'main', // container ID
        style: 'mapbox://styles/oliverpool/cklbak4fg2p3o17rzfkmeiytq', // style URL
        center: [11.700, 48.023], // starting position [lng, lat]
        zoom: 9, // starting zoom
        locale: "de",
        maxBounds: [
            [10.66794, 47.38488], // Southwest coordinates
            [13.38981, 48.56617] // Northeast coordinates
        ],

        // prevent rotation
        pitchWithRotate: false,
        dragRotate: false,
        touchZoomRotate: true, // rotation disabled below
    });
    map.touchZoomRotate.disableRotation();


    map.addControl(new mapboxgl.FullscreenControl());
    map.addControl(new mapboxgl.NavigationControl({
        showCompass: false
    }));
</script>
@endpush

<x-layout nav-main="/karte"></x-layout>