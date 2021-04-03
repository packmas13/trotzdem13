<template>
    <app-layout current-route="app.challenge.create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Eigenes Projekt einreichen
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-form-section @submitted="createChallenge">
                    <template #title>Für mehr Individualität!</template>

                    <template #description>
                      Ihr habt also eine tolle eigene Idee für ein Projekt, das ihr als Gruppe durchführen wollt?<br><br>
                      Dann beschreibt das Projekt in diesem Formular. Wir werden kurz prüfen, ob das Projekt zur Aktion trotzdem '13 passt und es dann freigeben.<br><br>
                      Wenn uns das Projekt besonders gut gefällt und es evtl. von mehreren Gruppen durchgeführt werden kann, geben wir es zusätzlich auch für andere Gruppen frei.<br>
                      Aber keine Sorge, für euch ist es dann natürlich bereits reserviert!
                    </template>

                    <template #form>
                        <label class="col-span-6 sm:col-span-4">
                            <span>Wie soll euer Projekt heißen?</span>
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
                            <span>Beschreibe euer Projekt?</span>
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
                            <RadioInput
                                label="In welche Kategorie passt euer Projekt?"
                                :error="form.errors.category_id"
                                name="category_id"
                                :required="true"
                                :options="categories"
                                v-model="form.category_id"
                                v-slot="option"
                            >
                                <CategoryIcon :category="option" />{{
                                    option.title
                                }}
                            </RadioInput>
                        </label>
                        <label class="col-span-6 sm:col-span-4">
                            <span
                                >Für welche Stufen ist euer Projekt geeignet?</span
                                ><br />
                            <label
                                :for="banner.stufe"
                                v-for="banner in banners"
                                :key="banner.id"
                            >
                                <input
                                    type="checkbox"
                                    :id="banner.stufe"
                                    :value="banner.id"
                                    v-model="form.banners"
                                />
                                <BannerPill
                                    :banner="banner"
                                    print-stufe
                                /><br />
                            </label>
                            <p
                                v-if="form.errors.banners"
                                v-text="form.errors.banners"
                                class="text-sm text-red-600 mt-2"
                            />
                        </label>
                    </template>

                    <template #actions>
                        <inertia-link
                            :href="route('app.challenge.index')"
                            class="secondary-button mr-3"
                            >Abbrechen
                        </inertia-link>
                        <jet-action-message
                            :on="form.recentlySuccessful"
                            class="mr-3"
                        >
                          Projekt erstellt.
                        </jet-action-message>

                        <jet-button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                          Projekt einreichen
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
import BannerPill from "@/components/BannerPill";
import CategoryIcon from "@/components/CategoryIcon";
import RadioInput from "@/input/RadioInput";

export default {
    components: {
        CategoryIcon,
        BannerPill,
        JetActionMessage,
        JetButton,
        JetFormSection,
        AppLayout,
        RadioInput,
    },
    props: {
        team: {
            type: Object,
            required: true
        },
        banners: {
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
                category_id: null,
                banners: [1, 2, 3, 4, 5],
            }),
        };
    },

    methods: {
        createChallenge() {
            this.form.post(route("app.challenge.custom.store", {team_id: this.team.id}), {
                onSuccess: () => this.form.reset(),
                onError: () => {},
            });
        },
    },
};
</script>
