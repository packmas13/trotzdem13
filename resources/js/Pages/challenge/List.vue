<template>
  <app-layout current-route="app.challenge.index">
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
                  <ChallengeDetail :challenge="challenge">
                      <template v-slot:info>
                          <small>Verfügbar: {{ challenge.quantity }}</small><br>
                      </template>
                      <template v-slot:actions>
                          <div>
                              <inertia-link
                                  :href="route('app.challenge.edit', {id: challenge.id})"
                                  class="m-1 secondary-button"
                              >Editieren
                              </inertia-link>
                              <inertia-link
                                  v-if="challenge.published_at"
                                  :href="route('app.challenge.unpublish', {id: challenge.id})"
                                  class="m-1 secondary-button"
                              >zu Entwurf
                              </inertia-link>
                              <inertia-link
                                  v-else
                                  :href="route('app.challenge.publish', {id: challenge.id})"
                                  class="m-1 secondary-button"
                              >Veröffentlichen
                              </inertia-link>
                              <inertia-link
                                  :href="route('app.challenge.delete', {id: challenge.id})"
                                  class="m-1 secondary-button"
                              >Löschen
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
import CategoryIcon from "@/components/CategoryIcon";
import ChallengeDetail from "./_Show";

export default {
  components: {
    AppLayout,
    CategoryIcon,
      ChallengeDetail
  },
  props: {
    challenges: {
      type: Array,
    },
  },
};
</script>
