<template>
    <app-layout current-route="app.team.index">
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
                        <InputLabel
                            label="Code eingeben:"
                            :error="form.errors.code"
                        >
                            <input
                                type="text"
                                class="mt-1 w-full rounded-md border-gray-300"
                                v-model="form.code"
                                required
                            />
                        </InputLabel>
                    </template>

                    <template #actions>
                        <inertia-link
                            :href="route('app.team.index')"
                            class="secondary-button mr-3"
                            >Abbrechen</inertia-link
                        >
                        <jet-action-message
                            :on="form.recentlySuccessful"
                            class="mr-3"
                        >
                            Du bist jetzt Mitglied der Gruppe #TODO: Gruppenname
                            einfügen#.
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

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        AppLayout,
    },

    data() {
        const urlParams = new URLSearchParams(window.location.search);
        return {
            form: this.$inertia.form({
                code: urlParams.get("code") || "",
            }),
        };
    },

    methods: {
        joinTeam() {
            this.form.post(route("app.team.join"), {
                onSuccess: () => this.form.reset(),
                onError: () => {},
            });
        },
    },
};
</script>
