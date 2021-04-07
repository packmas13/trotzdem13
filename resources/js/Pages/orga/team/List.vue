<template>
    <app-layout current-route="app.orga.team.list">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{teams.length}} Gruppen
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div>
                        <div
                            v-if="!teams.length"
                            class="italic text-gray-600"
                        >
                            Keine Gruppen verfügbar!
                        </div>
                        <ul v-else>
                            <li
                                v-for="team in teams"
                                :key="team.id"
                                class="py-4 px-6 sm:px-20 even:bg-sepiaGray-100"
                            >
                                <TeamDetail :team="team">
                                    <template v-slot:actions>
                                      <div >
                                        <h2>Aktuelles Projekt:</h2>
                                        <ChallengeDetail
                                            v-for="challenge in team.current_challenges"
                                            :key="challenge.id"
                                            :challenge="challenge"
                                        >
                                          <template v-slot:actions v-if="challenge.team_id" >
                                            <div v-if="!challenge.approved_at" class="p-5 bg-blue-100 text-blue-800">
                                              Hinweis: Selbst eingereichtes Projekt. Muss noch geprüft werden!
                                            </div>
                                            <div v-else class="p-5 bg-green-100 text-green-800">
                                              Hinweis: Selbst eingereichtes Projekt. Bereits freigegeben.
                                            </div>
                                          </template>
                                        </ChallengeDetail>
                                      </div>
                                    </template>
                                </TeamDetail>
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
import ChallengeDetail from "../../challenge/_Show";

export default {
    components: {
        AppLayout,
      TeamDetail,
      ChallengeDetail,
    },
    props: {
        teams: {
            type: Array,
        },
    },
};
</script>
