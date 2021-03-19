<template>
  <app-layout current-route="app.challenge.create">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Challenge bearbeiten
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <jet-form-section @submitted="updateChallenge">
          <template #title v-text="challenge.title" />

          <template #description> TODOTEXT: Beschreibung </template>

          <template #form>

              <label class="col-span-6 sm:col-span-4">
                  <span>Für welche Stufen ist die Challenge geeignet?</span><br>
                  <input type="checkbox" id="woelflinge" value="1" v-model="form.banners" />
                  <label for="woelflinge"> Wölflinge</label><br>
                  <input type="checkbox" id="jupfis" value="2" v-model="form.banners" />
                  <label for="jupfis"> Jupfis</label><br>
                  <input type="checkbox" id="pfadis" value="3" v-model="form.banners" />
                  <label for="pfadis"> Pfadis</label><br>
                  <input type="checkbox" id="rover" value="4" v-model="form.banners" />
                  <label for="rover"> Rover</label><br>
                  <input type="checkbox" id="leiter" value="5" v-model="form.banners" />
                  <label for="leiter"> Leiter</label><br>
                  <p
                      v-if="form.errors.banners"
                      v-text="form.errors.banners"
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
              <span>Zu welcher Kategorie gehört die Challenge?</span>
                <div v-for="(title, id) in categories">
                    <input type="radio" v-bind:id="'category-' + id" v-bind:value="id" v-model="form.category_id" />
                    <label v-bind:for="'category-' + id" v-text="title"/>
                </div>


              <p
                v-if="form.errors.category_id"
                v-text="form.errors.category_id"
                class="text-sm text-red-600 mt-2"
              />
            </label>
          </template>

          <template #actions>
            <inertia-link
              :href="route('app.challenge.index')"
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
              Challenge speichern
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
    challenge: {
        type: Object
    },
    categories: {
      type: Object,
    },
  },

  data() {
    return {
        form: this.$inertia.form({
            id: this.challenge.id,
            title: this.challenge.title,
            description: this.challenge.description,
            banners: this.challenge.banners.map(b => b.id),
            category_id: this.challenge.category_id
        })
    };
  },

  methods: {
    updateChallenge() {
      this.form.post(route("app.challenge.update"), {
        onSuccess: () => this.form.reset(),
        onError: () => {},
      });
    },
  },
};
</script>
