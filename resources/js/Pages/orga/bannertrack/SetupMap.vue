<template>
    <div id="setupmap">Karte wird geladen...</div>
</template>

<script>
import mapboxgl from "mapbox-gl";
import "mapbox-gl/dist/mapbox-gl.css";

mapboxgl.accessToken =
    "pk.eyJ1Ijoib2xpdmVycG9vbCIsImEiOiJja2xiOXhtNGIwNHhhMnZtamRycTB6N2F2In0.oDChPNXx61iD1AheKeT-vg";

export default {
    props: {
        teams: {
            type: Array,
        },
    },

    computed: {
        pointFeatures() {
            return this.teams.map(function (team) {
                return {
                    // feature for Mapbox DC
                    type: "Feature",
                    geometry: {
                        type: "Point",
                        coordinates: [team.location.lng, team.location.lat],
                        // coordinates: [-77.03238901390978, 38.913188059745586],
                    },
                    properties: {
                        id: team.id,
                    },
                };
            });
        },
        trackFeature() {
            if (!this.teams.length) {
                return [];
            }
            const variants = [];
            for (let i = 1; i <= this.teams[i].banner.variants; i++) {
                variants[i] = {
                    type: "Feature",
                    properties: {},
                    geometry: {
                        type: "LineString",
                        coordinates: [],
                    },
                };
            }

            for (let i = 0; i < this.teams.length; i++) {
                let variant = 1;
                if (this.teams[i].handover) {
                    variant = this.teams[i].handover.variant;
                }

                const l = this.teams[i].location;
                variants[variant].geometry.coordinates.push([l.lng, l.lat]);
            }
            return variants;
        },
    },
    watch: {
        trackFeature(feature) {
            const variants = this.teams[0].banner.variants;
            for (let i = 1; i <= variants; i++) {
                this.map.getSource("bannertrack-" + i).setData(feature[i]);
            }
        },
    },

    mounted() {
        const l0 = this.teams[0].location;
        var bounds = [
            [l0.lng, l0.lat],
            [l0.lng, l0.lat],
        ];
        this.teams.forEach((team) => {
            const l = team.location;
            if (l.lng < bounds[0][0]) {
                bounds[0][0] = l.lng;
            } else if (l.lng > bounds[1][0]) {
                bounds[1][0] = l.lng;
            }
            if (l.lat < bounds[0][1]) {
                bounds[0][1] = l.lat;
            } else if (l.lat > bounds[1][1]) {
                bounds[1][1] = l.lat;
            }
        });
        var map = new mapboxgl.Map({
            container: "setupmap", // container ID
            style: "mapbox://styles/oliverpool/cklbak4fg2p3o17rzfkmeiytq", // style URL
            interactive: false,
            bounds,
            fitBoundsOptions: { padding: 20 },
            locale: "de",
        });
        this.map = map;

        if (!this.teams.length) {
            return;
        }

        map.on("load", () => {
            const variants = this.teams[0].banner.variants;
            for (let i = 1; i <= variants; i++) {
                // draw banner track
                map.addSource("bannertrack-" + i, {
                    type: "geojson",
                    data: this.trackFeature[i],
                });
                map.addLayer({
                    id: "route-" + i,
                    type: "line",
                    source: "bannertrack-" + i,
                    layout: { "line-cap": "round" },
                    paint: {
                        "line-color": i % 2 ? "#1F8389" : "#cc7404",
                        "line-width": 2,
                    },
                });
            }

            // Draw team ids as dots
            map.addSource("teams", {
                type: "geojson",
                data: {
                    type: "FeatureCollection",
                    features: this.pointFeatures,
                },
            });
            map.addLayer({
                id: "team-circles",
                type: "circle",
                source: "teams",
                paint: {
                    "circle-radius": 13,
                    "circle-color": "#fff",
                },
            });
            map.addLayer({
                id: "team-names",
                type: "symbol",
                source: "teams",
                layout: {
                    // get the title name from the source's "title" property
                    "text-field": ["get", "id"],
                    "text-allow-overlap": true,
                    "text-font": ["Open Sans Bold", "Arial Unicode MS Bold"],
                    "text-letter-spacing": -0.05,
                },
                paint: {
                    "text-color": "#1F8389",
                },
            });
        });
    },
};
</script>
