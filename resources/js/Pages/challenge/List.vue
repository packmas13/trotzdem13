<template>
    <app-layout current-route="app.challenge.list">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Challenges
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20">
                        <div v-if="!challenges.length" class="italic text-gray-600">
                            Keine Challenges verfügbar!
                        </div>
                        <ul v-else>
                            <li
                                v-for="challenge in challenges"
                                :key="challenge.id"
                                class="border-b pb-4"
                            >
                                <h3 v-text="challenge.title" class="text-2xl" />
                                Kategorie: <span v-text="challenge.category" /><br>
                                Status: <span v-if="challenge.published_at">Öffentlich</span>
                                <span v-else>Entwurf</span><br>
                                <inertia-link
                                    :href="route('app.challenge.edit', {id: challenge.id})"
                                    class="secondary-button"
                                >Editieren</inertia-link>
                                <inertia-link
                                    :href="route('app.challenge.delete', {id: challenge.id})"
                                    class="secondary-button"
                                >Löschen</inertia-link>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 py-6 px-6 sm:px-20 text-right">
                        <inertia-link
                            :href="route('app.challenge.create')"
                            class="ml-2 primary-button"
                            >Neue Challenge</inertia-link
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
        challenges: {
            type: Array,
        },
    },
};
</script>
