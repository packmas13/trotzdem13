<template>
    <app-layout current-route="app.team.index">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Meine Gruppe
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20">
                        <div v-if="!teams.length" class="italic text-gray-600">
                            Du gehörst noch zu keiner Gruppe.
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

                    <div class="bg-gray-50 py-6 px-6 sm:px-20 text-right">
                        <inertia-link
                            :href="route('app.team.join')"
                            class="secondary-button"
                            >
                            <svg class="w-10 h-8 m-auto" fill="currentColor" viewBox="0 0 30 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 6a3 3 0 11-6 0a3 3 0 016 0zM18 8a2 2 0 11-4 0a2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0a2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906M30.22 12.8a1.12 1.12 90 100-2.24H23.9637l1.4482-1.4482a1.12 1.12 90 10-1.5837-1.5837l-3.36 3.36a1.12 1.12 90 000 1.5837l3.36 3.36a1.12 1.12 90 001.5837-1.5837L23.9637 12.8H30.22z"></path>
                            </svg>
                            Gruppe beitreten
                        </inertia-link
                        >
                        <inertia-link
                            :href="route('app.team.create')"
                            class="ml-2"
                            :class="
                                teams.length
                                    ? 'secondary-button'
                                    : 'primary-button'
                            "
                            >
                            <svg class="w-9 h-8 m-auto" fill="currentColor" viewBox="0 0 25 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 6a3 3 0 11-6 0a3 3 0 016 0zM18 8a2 2 0 11-4 0a2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0a2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906zM22 4a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V4z"></path>
                            </svg>
                            Neue Gruppe einrichten
                        </inertia-link
                        >
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
    },
};
</script>
