<template>
    <app-layout current-route="app.orga.team.list">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Bannerlauf planen
            </h2>
            <div>
                <inertia-link
                    :href="route('app.orga.team.list')"
                    class="text-sm text-gray-700 underline"
                >
                    &lsaquo; Alle Gruppen
                </inertia-link>

                <inertia-link
                    v-for="b in banners"
                    :key="b.id"
                    :href="
                        route('app.orga.bannertrack.setup', {
                            banner_id: b.id,
                        })
                    "
                    class="px-2"
                >
                    <banner-pill
                        :banner="b"
                        class="hover:underline"
                        :class="{ 'bg-opacity-25': b.id != banner.id }"
                    />
                </inertia-link>
            </div>
        </template>

        <div class="flex h-screen">
            <div class="bg-white h-full overflow-y-auto">
                <div class="italic text-center p-2">
                    Schiebe die Gruppen nach oben und unten,<br />um die
                    Reihenfolge zu optimieren
                </div>
                <ul
                    v-draggable="{
                        value: teams,
                        placeholderClass: 'bg-sepiaGray-200',
                    }"
                    @change="changed"
                >
                    <li
                        v-for="team in teams"
                        :key="team.id"
                        class="p-2 flex justify-between border-b items-center cursor-move"
                    >
                        <div>
                            {{ team.id }} <strong v-text="team.name" />
                            <small class="block w-64 truncate text-gray-600"
                                >{{ team.troop.name }} -
                                {{ team.district.name }}</small
                            >
                        </div>
                        <div
                            class="text-right whitespace-nowrap"
                            title="Luftlinie zur nächsten Gruppe"
                        >
                            {{ distance(team, nextTeam(team)) }} Km
                            <small class="block">{{ radius(team) }}</small>
                        </div>
                    </li>
                </ul>
                <div class="p-2 text-gray-600 text-right">
                    Luftlinie ≈ {{ totalDistance }} Km
                </div>
                <div class="p-2 italic text-center">
                    Speichern ist noch nicht möglich<br />(einen Screenshot
                    kannst du aber machen)
                </div>
            </div>
            <SetupMap :teams="teams" class="flex-auto" />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import BannerPill from "@/components/BannerPill.vue";
import SetupMap from "./SetupMap.vue";

export default {
    components: {
        AppLayout,
        BannerPill,
        SetupMap,
    },
    props: {
        banners: {
            type: Array,
        },
        banner: {
            type: Object,
        },
    },
    data() {
        return { teams: this.banner.teams };
    },
    methods: {
        changed() {
            console.log("TODO recompute all");
        },
    },
    computed: {
        radius() {
            return (team) => {
                return (
                    {
                        1: "Bis zu Nachbarstämmen",
                        2: "Überall im Bezirk",
                        3: "Bis zu Nachbarbezirken",
                        4: "Überall in der Diözese",
                        5: "Wir kennen keine Grenzen",
                    }[team.radius] || team.radius
                );
            };
        },
        nextTeam() {
            return (team) => {
                const i = this.teams.findIndex((t) => t.id == team.id);
                if (i + 1 >= this.teams.length) {
                    return {
                        id: "END",
                        location: { lat: 48.13206, lng: 11.60278 },
                    };
                }
                return this.teams[i + 1];
            };
        },
        distance() {
            return (start, end) => {
                return getDistanceFromLatLonInKm(
                    start.location,
                    end.location
                ).toFixed(1);
            };
        },
        totalDistance() {
            let d = 0;
            let previous = this.teams[0].location;
            for (let i = 1; i < this.teams.length; i++) {
                const current = this.teams[i].location;
                d += getDistanceFromLatLonInKm(previous, current);
                previous = current;
            }
            return d.toFixed(1);
        },
    },
};

// taken from https://stackoverflow.com/q/18883601/3207406
function getDistanceFromLatLonInKm(start, end) {
    var R = 6371; // Radius of the earth in km
    var dLat = deg2rad(end.lat - start.lat); // deg2rad below
    var dLon = deg2rad(end.lng - start.lng);
    var a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(deg2rad(start.lat)) *
            Math.cos(deg2rad(end.lat)) *
            Math.sin(dLon / 2) *
            Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c; // Distance in km
    return d;
}

function deg2rad(deg) {
    return deg * (Math.PI / 180);
}
</script>
