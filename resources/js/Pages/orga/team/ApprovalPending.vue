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
                            Alle Gruppen wurden schon freigegeben (oder
                            blockiert)
                        </div>
                        <ul v-else>
                            <li
                                v-for="team in teams"
                                :key="team.id"
                                class="border-b py-4"
                            >
                              <TeamDetail :team="team">
                                <template v-slot:actions>
                                  <div
                                      v-if="!team.approved_at && !approving"
                                      class="p-2 flex items-start"
                                  >
                                    <button
                                        type="button"
                                        class="primary-button mr-2"
                                        @click="approve(true)"
                                    >
                                      Gruppe Freigeben
                                    </button>
                                    <details>
                                      <summary class="py-2">Gruppe Blockieren</summary>
                                      <form @submit.prevent="approve(false)">
                                        <InputLabel
                                            class="flex flex-col mb-4"
                                            label="Warum soll diese Gruppe blockiert werden?"
                                            help="z.B. Spam, duplikat"
                                        >
                                          <input type="text" v-model="blockReason" required />
                                        </InputLabel>
                                        <button class="danger-button">Gruppe Blockieren</button>
                                      </form>
                                    </details>
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
