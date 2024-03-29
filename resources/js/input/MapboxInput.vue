<template>
    <div id="map-input" class="h-96" />
</template>

<script>
import mapboxgl from "mapbox-gl";
import "mapbox-gl/dist/mapbox-gl.css";

import MapboxGeocoder from "@mapbox/mapbox-gl-geocoder";
import "@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css";

mapboxgl.accessToken =
    "pk.eyJ1Ijoib2xpdmVycG9vbCIsImEiOiJja2xiOXhtNGIwNHhhMnZtamRycTB6N2F2In0.oDChPNXx61iD1AheKeT-vg";

export default {
    props: {
        modelValue: {
            type: Object,
            default: null,
        },
    },
    emits: ["update:modelValue"],
    data() {
        return {
            marker: null,
        };
    },
    methods: {
        updateMarker() {
            const location = this.map.getCenter();
            this.marker.setLngLat(location);
            this.$emit("update:modelValue", {
                lat: location.lat.toFixed(5),
                lng: location.lng.toFixed(5),
            });
        },
    },
    mounted() {
        const geocodeZoom = 16;
        var zoom = 2;
        var center = [11.7, 48.023];
        var hasInitial = false;
        if (this.modelValue && this.modelValue.lat && this.modelValue.lng) {
            center = [this.modelValue.lng, this.modelValue.lat];
            zoom = geocodeZoom;
            hasInitial = true;
        }
        var map = new mapboxgl.Map({
            container: "map-input", // container ID
            style: "mapbox://styles/oliverpool/cklbak4fg2p3o17rzfkmeiytq", // style URL
            center, // starting position [lng, lat]
            zoom, // starting zoom
            locale: "de",
            maxBounds: [
                [10.66794, 47.38488], // Southwest coordinates
                [13.38981, 48.56617], // Northeast coordinates
            ],

            // prevent rotation
            pitchWithRotate: false,
            dragRotate: false,
            touchZoomRotate: true, // rotation disabled below
        });
        map.touchZoomRotate.disableRotation();
        map.touchPitch.disable();

        const geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            placeholder: "Adresse suchen...",
            mapboxgl: mapboxgl,
            bbox: [10.66794, 47.38488, 13.38981, 48.56617],

            countries: "DE",
            language: "de",
            marker: false,
            zoom: geocodeZoom,
        });
        map.addControl(geocoder);

        map.addControl(
            new mapboxgl.NavigationControl({
                showCompass: false,
            })
        );
        this.map = map;
        this.marker = new mapboxgl.Marker()
            .setLngLat(map.getCenter())
            .addTo(map);
        map.on("move", this.updateMarker);
        if (!hasInitial) {
            this.updateMarker();
        }
    },
};
</script>
<style>
#map-input .mapboxgl-ctrl-top-right {
    left: 20px;
}
#map-input .mapboxgl-ctrl-geocoder {
    width: 100%;
    max-width: none;
}
</style>
