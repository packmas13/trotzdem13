@push('styles')
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css"
    integrity="sha384-uGgNReQDM4xUjyppNF69a8TECFK/SdZzFxfsfE5e09EDjV/A2ht7nAkKoWUj2dwC" crossorigin="anonymous">
@endpush

@push('scripts')
<script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js"
    integrity="sha384-0uJ3jJUASu7ZFHSwTzVO6YbgmXvr90z5LzVqYl7iVd4XJYXn94Sdm4JjVjYat8zm" crossorigin="anonymous">
</script>

<div class="hidden">
@foreach($banners as $banner)
<svg id="marker-banner-{{$banner->id}}" class="w-6 h-6 text-{{$banner->color}}-dark" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd" opacity="0.7"></path></svg>
@endforeach
</div>

<script>
    mapboxgl.accessToken = 'pk.eyJ1Ijoib2xpdmVycG9vbCIsImEiOiJja2xiOXhtNGIwNHhhMnZtamRycTB6N2F2In0.oDChPNXx61iD1AheKeT-vg';
    var map = new mapboxgl.Map({
        container: 'main', // container ID
        style: 'mapbox://styles/oliverpool/cklbak4fg2p3o17rzfkmeiytq', // style URL
        center: [{{$center[1]}}, {{$center[0]}}], // starting position [lng, lat]
        zoom: 7, // starting zoom
        locale: "de",
        maxBounds: [
            [{{$boundSouthWest[1]}}, {{$boundSouthWest[0]}}], // Southwest coordinates
            [{{$boundNorthEast[1]}}, {{$boundNorthEast[0]}}] // Northeast coordinates
        ],

        // prevent rotation
        pitchWithRotate: false,
        dragRotate: false,
        touchZoomRotate: true, // rotation disabled below

        // prevent zoom on scroll
        scrollZoom: false,
    });
    map.touchZoomRotate.disableRotation();
    map.touchPitch.disable();

    // only drag on touch device with two fingers
    const isTouchEvent = e => e.originalEvent && "touches" in e.originalEvent;
    const isTwoFingerTouch = e => e.originalEvent.touches.length >= 2;
    map.on("dragstart", event => {
        if (isTouchEvent(event) && !isTwoFingerTouch(event)) {
        map.dragPan.disable();
        }
    });
    map.on("touchstart", event => {
        if (isTouchEvent(event) && isTwoFingerTouch(event)) {
        map.dragPan.enable();
        }
    });

    map.addControl(new mapboxgl.FullscreenControl());
    map.addControl(new mapboxgl.NavigationControl({
        showCompass: false
    }));


@foreach($banners as $banner)
    var markerBanner{{$banner->id}} = document.getElementById('marker-banner-{{$banner->id}}');
    markerBanner{{$banner->id}}.removeAttribute("id");
@endforeach

@foreach($teams as $team)
    new mapboxgl.Marker({ element: markerBanner{{$team->banner_id}}.cloneNode( true ), anchor: 'bottom-left' })
    .setLngLat([{{$team->location['lng']}}, {{$team->location['lat']}}])
    .addTo(map);
@endforeach


</script>
@endpush

<x-layout nav-main="/karte"></x-layout>
