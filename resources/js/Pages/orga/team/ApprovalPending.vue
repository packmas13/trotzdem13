<template>
    <app-layout current-route="app.orga.team.pending">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Neue Gruppen
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div
                        v-if="Object.keys(errors).length"
                        class="bg-red-100 p-5 text-red-800 border-l-4 border-r-4 border-red-800"
                    >
                        <ul>
                            <li v-for="(error, field) in errors" :key="field">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                    <div class="p-6 sm:px-20">
                        <div v-if="!teams.length" class="italic text-gray-600">
                            Alle Gruppe wurden schon freigegeben (oder
                            blockiert)
                        </div>
                        <ul v-else>
                            <li
                                v-for="team in teams"
                                :key="team.id"
                                class="border-b py-4"
                            >
                                <TeamDetail :team="team" />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import TeamDetail from "./_Show";

export default {
    components: {
        AppLayout,
        TeamDetail,
    },
    props: {
        teams: {
            type: Object,
        },
        errors: Object,
    },
};
</script>
