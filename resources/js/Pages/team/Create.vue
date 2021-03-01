<template>
    <app-layout current-route="app.team.index">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Neue Gruppe
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-form-section @submitted="updatePassword">
                    <template #title>Neue Gruppe erstellen</template>

                    <template #description> TODOTEXT: Beschreibung </template>

                    <template #form>
                        <label class="col-span-6 sm:col-span-4">
                            <span>Stamm</span>
                            <select
                                class="mt-1 w-full rounded-md border-gray-300"
                                v-model="form.stamm_id"
                                required
                            >
                                <optgroup
                                    v-for="(bezirk, bid) in bezirke"
                                    :key="bid"
                                    :label="bezirk.name"
                                >
                                    <option
                                        v-for="(stamm, sid) in bezirk.staemme"
                                        :key="sid"
                                        :value="sid"
                                        v-text="stamm"
                                    />
                                </optgroup>
                            </select>
                            <p
                                v-if="form.errors.stamm_id"
                                v-text="form.errors.stamm_id"
                                class="text-sm text-red-600 mt-2"
                            />
                        </label>

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
                                    :label="stufe"
                                />
                            </select>
                            <p
                                v-if="form.errors.stufe_id"
                                v-text="form.errors.stufe_id"
                                class="text-sm text-red-600 mt-2"
                            />
                        </label>

                        <label class="col-span-6 sm:col-span-4">
                            <span>Wie solle eure Gruppe heißen?</span>
                            <input
                                type="text"
                                class="mt-1 w-full rounded-md border-gray-300"
                                v-model="form.name"
                                placeholder="Sei kreativ"
                                required
                            />
                            <p
                                v-if="form.errors.name"
                                v-text="form.errors.name"
                                class="text-sm text-red-600 mt-2"
                            />
                        </label>

                        <label class="col-span-6 sm:col-span-4">
                            <span>Wie viel seid ihr in der Gruppe?</span>
                            <input
                                type="number"
                                class="mt-1 w-full rounded-md border-gray-300"
                                v-model="form.size"
                                min="1"
                                required
                            />
                            <p
                                v-if="form.errors.size"
                                v-text="form.errors.size"
                                class="text-sm text-red-600 mt-2"
                            />
                        </label>

                        <label class="col-span-6 sm:col-span-4">
                            <span>Woher kommt ihr?</span>
                            <input
                                type="text"
                                class="mt-1 w-full rounded-md border-gray-300"
                                v-model="form.location"
                                required
                            />
                            <p
                                v-if="locationError"
                                v-text="locationError"
                                class="text-sm text-red-600 mt-2"
                            />
                        </label>

                        <label class="col-span-6 sm:col-span-4">
                            <span>Wie weit läuft ihr für das Banner?</span>
                            <select
                                class="mt-1 w-full rounded-md border-gray-300"
                                v-model="form.radius"
                                required
                            >
                                <option
                                    v-for="(name, id) in distances"
                                    :key="id"
                                    :value="id"
                                    :label="name"
                                />
                            </select>
                            <p
                                v-if="form.errors.radius"
                                v-text="form.errors.radius"
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
                        <jet-action-message
                            :on="form.recentlySuccessful"
                            class="mr-3"
                        >
                            Gruppe erstellt.
                        </jet-action-message>

                        <jet-button
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Gruppe erstellen
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
    props: {
        bezirke: {
            type: Object,
        },
        stufen: {
            type: Object,
        },
        distances: {
            type: Object,
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                name: "",
                stamm_id: "",
                stufe_id: "",
                size: "",
                location: "",
                radius: "",
            }),
        };
    },

    computed: {
        locationError() {
            return (
                this.form.errors["location"] ||
                this.form.errors["location.name"] ||
                this.form.errors["location.lat"] ||
                this.form.errors["location.lng"]
            );
        },
    },

    methods: {
        updatePassword() {
            this.form.post(route("app.team.store"), {
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
