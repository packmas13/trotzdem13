<template>
    <app-layout current-route="app.challenge.create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Projekt bearbeiten
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-form-section @submitted="updateChallenge">
                    <template #title v-text="challenge.title" />

                    <template #description> TODOTEXT: Beschreibung</template>

                    <template #form>
                        <label class="col-span-6 sm:col-span-4">
                            <span
                                >Für welche Stufen ist das Projekt
                                geeignet?</span
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

                        <label class="col-span-6 sm:col-span-4">
                            <span>Wie soll das Projekt heißen?</span>
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
                            <span>Beschreibe das Projekt?</span>
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
                                label="Zu welcher Kategorie gehört das Projekt?"
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
                            <p
                                v-if="form.errors.category_id"
                                v-text="form.errors.category_id"
                                class="text-sm text-red-600 mt-2"
                            />
                        </label>

                        <label class="col-span-6 sm:col-span-4">
                            <span
                                >Wie oft kann das Projekt gemacht
                                werden?</span
                            >
                            <input
                                type="number"
                                class="mt-1 w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-200"
                                v-model="form.quantity"
                                min="0"
                                required
                            />
                            <p
                                v-if="form.errors.quantity"
                                v-text="form.errors.quantity"
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
                          Projekt speichern
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
import RadioInput from "@/input/RadioInput";
import BannerPill from "@/components/BannerPill";
import CategoryIcon from "@/components/CategoryIcon";

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        AppLayout,
        RadioInput,
        BannerPill,
        CategoryIcon,
    },
    props: {
        challenge: {
            type: Object,
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
                id: this.challenge.id,
                title: this.challenge.title,
                description: this.challenge.description,
                banners: this.challenge.banners.map((b) => b.id),
                category_id: this.challenge.category_id,
                quantity: this.challenge.quantity,
            }),
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
