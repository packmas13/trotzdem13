<template>
    <app-layout current-route="app.orga.challenge.index">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Projekte
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div>
                        <div
                            v-if="!challenges.length"
                            class="italic text-gray-600"
                        >
                            Keine Projekte verfügbar!
                        </div>
                        <ul v-else>
                            <li
                                v-for="challenge in challenges"
                                :key="challenge.id"
                                class="py-4 px-6 sm:px-20 even:bg-sepiaGray-100"
                            >
                                <ChallengeDetail :challenge="challenge">
                                    <template v-slot:info>
                                        <small
                                            >Gewählt:
                                            {{ challenge.teams_count }}/{{ challenge.quantity }}</small
                                        ><br />
                                    </template>
                                    <template v-slot:actions>
                                        <div>
                                            <inertia-link
                                                :href="
                                                    route(
                                                        'app.orga.challenge.edit',
                                                        { id: challenge.id }
                                                    )
                                                "
                                                class="m-1 secondary-button"
                                                >Editieren
                                            </inertia-link>
                                            <inertia-link
                                                v-if="challenge.published_at"
                                                :href="
                                                    route(
                                                        'app.orga.challenge.unpublish',
                                                        { id: challenge.id }
                                                    )
                                                "
                                                class="m-1 secondary-button"
                                                preserve-scroll
                                                >zu Entwurf
                                            </inertia-link>
                                            <inertia-link
                                                v-else
                                                :href="
                                                    route(
                                                        'app.orga.challenge.publish',
                                                        { id: challenge.id }
                                                    )
                                                "
                                                class="m-1 primary-button"
                                                preserve-scroll
                                                >Veröffentlichen
                                            </inertia-link>
                                        </div>
                                    </template>
                                </ChallengeDetail>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-gray-50 py-6 px-6 sm:px-20 text-right">
                        <inertia-link
                            :href="route('app.orga.challenge.create')"
                            class="ml-2 primary-button"
                            >Neues Projekt
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ChallengeDetail from "../../challenge/_Show";

export default {
    components: {
        AppLayout,
        ChallengeDetail,
    },
    props: {
        challenges: {
            type: Array,
        },
    },
};
</script>
