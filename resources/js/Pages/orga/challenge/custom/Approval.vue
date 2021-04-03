<template>
  <ChallengeDetail :challenge="challenge">
    <template v-slot:actions>
      <details class="mb-1">
        <summary class="py-2">Gruppe</summary>
        <TeamDetails :team="challenge.team" />
      </details>
      <template v-if="!challenge.approved_at">
        <button
            type="button"
            class="primary-button mr-2"
            @click="approve(true)"
        >
          Projekt bestätigen
        </button>
        <details>
          <summary class="py-2">Projekt ablehnen</summary>
          <form @submit.prevent="approve(false)">
            <div class="m-4">
              <span class="font-semibold text-red-900">
                Bitte vorher Kontakt mit der Gruppe aufnehmen!
              </span>
            </div>
            <button class="danger-button">Ablehnen</button>
          </form>
        </details>
      </template>
      <template v-else>
        <details>
          <summary class="py-2">Projekt übernehmen</summary>
          <form @submit.prevent="convert()">
            <div class="m-4">
              <span class="text-sm text-gray-600">
                Dieses Projekt in die Liste der offiziellen Projekte überführen.<br>
                Dadurch wird das Projekt auf der öffentlichen Projektseite angezeigt.<br>
                Die Auswahl für die Gruppe, die das Projekt eingereicht hat, bleibt dabei bestehen.<br>
                Wenn die Häufigkeit größer 1 gesetzt wird, können auch weitere Gruppen das Projekt auswählen.<br>
                Nach der Überführung ist das Projekt in der Liste der Orga-Projekte zu finden, nicht mehr in dieser Liste!
              </span>
            </div>
            <InputLabel
                class="flex flex-col mb-4"
                label="Wie oft kann das Projekt durchgeführt werden?"
                help="mindestens 1"
            >
              <input
                  type="number"
                  class="mt-1 w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-200"
                  v-model="quantity"
                  min="1"
                  required
              />
            </InputLabel>
            <button class="secondary-button">Übernehmen und Veröffentlichen</button>
          </form>
        </details>
      </template>
    </template>
  </ChallengeDetail>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ChallengeDetail from "../../../challenge/_Show";
import TeamDetails from "./_Team";

export default {
  components: {
    AppLayout,
    ChallengeDetail,
    TeamDetails,
  },
  props: {
    challenge: {
      type: Object,
    },
    errors: Object,
  },
  data() {
    return {
      rejectReason: "",
      quantity: 1,
    };
  },
  methods: {
    approve(approved) {
      const data = {
        approved,
        challenge_id: this.challenge.id,
        reason: this.rejectReason,
      };
      this.$inertia.post(this.route("app.orga.challenge.approve"), data, {
        preserveScroll: (page) => {
          return !Object.keys(page.props.errors).length;
        },
      });
    },
    convert() {
      const data = {
        challenge_id: this.challenge.id,
        quantity: this.quantity
      };
      this.$inertia.post(this.route("app.orga.challenge.convert"), data, {
        preserveScroll: (page) => {
          return !Object.keys(page.props.errors).length;
        },
      });
    },
  },
};
</script>
