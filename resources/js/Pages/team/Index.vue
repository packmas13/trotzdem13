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
                                class="border-b pb-4"
                            >
                                <h3 v-text="team.name" class="text-2xl" />
                                Status: created / submitted / accepted<br>
                                Code: <span v-text="team.join_code" />
                            </li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 py-6 px-6 sm:px-20 text-right">
                        <inertia-link
                            :href="route('app.team.joinForm')"
                            class="secondary-button"
                            >Gruppe beitreten</inertia-link
                        >
                        <inertia-link
                            :href="route('app.team.create')"
                            class="ml-2"
                            :class="
                                teams.length
                                    ? 'secondary-button'
                                    : 'primary-button'
                            "
                            >Neue Gruppe einrichten</inertia-link
                        >
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
    components: {
        AppLayout,
    },
    props: {
        teams: {
            type: Array,
        },
    },
};
</script>
