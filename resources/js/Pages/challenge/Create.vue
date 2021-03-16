<template>
  <app-layout current-route="app.challenge.create">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Neue Challenge
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <jet-form-section @submitted="createChallenge">
          <template #title>Neue Challenge erstellen</template>

          <template #description> TODOTEXT: Beschreibung </template>

          <template #form>

            <label class="col-span-6 sm:col-span-4">
              <span>Stufe</span>
              <select
                class="mt-1 w-full rounded-md border-gray-300"
                v-model="form.stufe_id"
                required
              >
                <option
                  v-for="(stufe, id) in stufen"
                  :key="id"
                  :value="id"
                  v-text="stufe"
                />
              </select>
              <p
                v-if="form.errors.stufe_id"
                v-text="form.errors.stufe_id"
                class="text-sm text-red-600 mt-2"
              />
            </label>

            <label class="col-span-6 sm:col-span-4">
              <span>Wie soll die Challenge heißen?</span>
              <input
                type="text"
                class="mt-1 w-full rounded-md border-gray-300"
                v-model="form.title"
                required
              />
              <p
                v-if="form.errors.title"
                v-text="form.errors.title"
                class="text-sm text-red-600 mt-2"
              />
            </label>

              <label class="col-span-6 sm:col-span-4">
                  <span>Beschreibe die Challenge?</span>
                  <textarea
                      class="mt-1 w-full rounded-md border-gray-300"
                      v-model="form.description"
                      required
                  />
                  <p
                      v-if="form.errors.description"
                      v-text="form.errors.description"
                      class="text-sm text-red-600 mt-2"
                  />
              </label>

            <label class="col-span-6 sm:col-span-4">
              <span>Zu welchen Kategorien gehört die Challenge?</span>
                <div class="form-group">
                    <div class="form-check"
                         v-for="(title, id) in categories"
                         :key="id"
                         :value="id"
                         v-text="title"
                    >
                        <label :for="id" class="form-check-label">
                            <input type="checkbox"
                                   :id="id"
                                   class="form-check-input"
                                   :value="id"
                                   v-model="challenge.categories" />
                            Joe
                        </label>
                    </div>
                </div>
              <select
                class="mt-1 w-full rounded-md border-gray-300"
                v-model="form.category_id"
                required
              >
                <option
                  v-for="(title, id) in categories"
                  :key="id"
                  :value="id"
                  v-text="title"
                />
              </select>
              <p
                v-if="form.errors.category_id"
                v-text="form.errors.category_id"
                class="text-sm text-red-600 mt-2"
              />
            </label>
          </template>

          <template #actions>
            <inertia-link
              :href="route('app.challenge.list')"
              class="secondary-button mr-3"
              >Abbrechen</inertia-link
            >
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
              Challenge erstellt.
            </jet-action-message>

            <jet-button
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Challenge erstellen
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
  props: {
    stufen: {
      type: Object,
    },
    categories: {
      type: Object,
    },
  },

  data() {
    return {
      form: this.$inertia.form({
        title: "",
        description: "",
        category_id: "",
        stufe_id: ""
      }),
    };
  },

  methods: {
    createChallenge() {
      this.form.post(route("app.challenge.store"), {
        onSuccess: () => this.form.reset(),
        onError: () => {},
      });
    },
  },
};
</script>
