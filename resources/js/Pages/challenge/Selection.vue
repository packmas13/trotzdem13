<template>
  <app-layout current-route="app.challenge.selection">
    <template #header v-if="isLeader">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Wähle eine Challenge für Team '{{ team.name }}'!
      </h2>
    </template>
    <template #header v-if="!isLeader">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Welche Challenges gefallen dir?
      </h2>
      <small>
        Du kannst dir die Challenges hier ansehen. Eine Challenge für dein Team auswählen dürfen jedoch nur die Leiter:innen der Teams.
      </small>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg">
          <div class="p-6 sm:px-20">
            <div v-if="!challenges.length" class="italic text-gray-600">
              Keine Challenges verfügbar!
            </div>
            <ul>
              <li
                  v-for="challenge in challenges"
                  :key="challenge.id"
                  class="border-b pb-4"
              >
                <ChallengeDetail :challenge="challenge">
                  <template v-slot:info>
                    <span>Verfügbar: {{ challenge.quantity }}</span><br>
                  </template>
                  <template v-slot:actions v-if="isLeader">
                    <div>
                      <inertia-link
                          :href="route('app.challenge.select', {team_id: team.id, challenge_id: challenge.id})"
                          class="secondary-button"
                      >Auswählen
                      </inertia-link>
                    </div>
                  </template>
                </ChallengeDetail>
              </li>
            </ul>
          </div>

          <div class="bg-gray-50 py-6 px-6 sm:px-20 text-right">
            <inertia-link
                :href="route('app.challenge.create')"
                class="ml-2 primary-button"
            >Neue Challenge
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
import ChallengeDetail from "./_Show";

export default {
  components: {
    AppLayout,
    ChallengeDetail
  },
  props: {
    challenges: {
      type: Array,
      required: true
    },
    team: {
      type: Object,
      required: true
    },
    isLeader: {
      type: Boolean,
      required: false,
      default: false
    }
  },
};
</script>
