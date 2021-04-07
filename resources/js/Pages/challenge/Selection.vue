<template>
  <app-layout current-route="app.team.index">
    <template #header v-if="isLeader">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Wähle ein Projekt für die Gruppe '{{ team.name }}'!
      </h2>
    </template>
    <template #header v-else>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Welche Projekte gefallen dir?
      </h2>
      <small>
        Du kannst dir die Projekte hier ansehen. Ein Projekt für dein Team auswählen dürfen jedoch nur die Leiter:innen der Teams.
      </small>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg">
          <div class="">
            <div v-if="!challenges.length" class="italic text-gray-600">
              Keine Projekte verfügbar!
            </div>
            <ul>
              <li
                  v-for="challenge in challenges"
                  :key="challenge.id"
                  class="py-4 px-6 sm:px-20 even:bg-sepiaGray-100"
              >
                <ChallengeDetail :challenge="challenge">
                  <template v-slot:info v-if="challenge.quantity >= 0">
                    <span>Verfügbar: {{ challenge.quantity - challenge.teams_count }}&nbsp;von&nbsp;{{ challenge.quantity }}</span><br>
                  </template>
                  <template v-slot:actions v-if="canSelect(challenge)">
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
                :href="route('app.challenge.custom', {team_id: team.id})"
                class="ml-2 primary-button"
            >Eigenes Projekt
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
  methods: {
    canSelect(challenge) {
      if(!this.isLeader) return false;
      if(this.team.current_challenges_count > 0) return false;
      if(challenge.quantity < 0) return true;
      return challenge.quantity > challenge.teams_count;
    }
  }
};
</script>
