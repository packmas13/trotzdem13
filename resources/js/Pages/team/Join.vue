<template>
  <app-layout current-route="app.team.joinForm">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Gruppe beitreten
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <jet-form-section @submitted="joinTeam">
          <template #title>Gruppe beitreten</template>

          <template #description> TODOTEXT: Beschreibung </template>

          <template #form>

            <label class="col-span-6 sm:col-span-4">
              <span>Code eingeben:</span>
              <input
                type="text"
                class="mt-1 w-full rounded-md border-gray-300"
                v-model="form.code"
                required
              />
              <p
                v-if="form.errors.code"
                v-text="form.errors.code"
                class="text-sm text-red-600 mt-2"
              />
            </label>
          </template>

          <template #actions>
            <inertia-link
              :href="route('app.team.index')"
              class="secondary-button mr-3"
              >Abbrechen</inertia-link
            >
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
              Du bist jetzt Mitglied der Gruppe #TODO: Gruppenname einfügen#.
            </jet-action-message>

            <jet-button
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Gruppe beitreten
            </jet-button>
          </template>
        </jet-form-section>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

import JetActionMessage from "@/Jetstream/ActionMessage";
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import MapboxInput from "../../input/MapboxInput.vue";

export default {
  components: {
    JetActionMessage,
    JetButton,
    JetFormSection,
    AppLayout,
    MapboxInput,
  },

  data() {
    return {
      form: this.$inertia.form({
        code: "",
      }),
    };
  },

  methods: {
    joinTeam() {
      this.form.post(route("app.team.join"), {
        onSuccess: () => this.form.reset(),
        onError: () => {
          if (this.form.errors.password) {
            this.form.reset("password", "password_confirmation");
            this.$refs.password.focus();
          }

          if (this.form.errors.current_password) {
            this.form.reset("current_password");
            this.$refs.current_password.focus();
          }
        },
      });
    },
  },
};
</script>
