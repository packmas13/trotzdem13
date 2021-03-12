<template>
    <app-layout current-route="app.team.index">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Neue Gruppe
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-form-section @submitted="submit">
                    <template #title>Neue Gruppe erstellen</template>

                    <template #description> TODOTEXT: Beschreibung </template>

                    <template #form>
                        <InputLabel
                            label="Wie heißt eure Gruppe?"
                            :error="form.errors.name"
                        >
                            <input
                                type="text"
                                class="mt-1 w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-200"
                                v-model="form.name"
                                required
                            />
                        </InputLabel>

                        <InputLabel
                            label="Wollt ihr ein Bild hochladen?"
                            :error="form.errors.image"
                            help="Dieses Bild wird veröffentlicht"
                        >
                            <input
                                v-show="!imagePreview"
                                type="file"
                                accept="image/*"
                                class="mt-1 w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-200"
                                ref="image"
                                @change="updatePreview"
                            />
                            <div v-if="imagePreview">
                                <div
                                    class="block w-full h-48 my-1 bg-contain bg-no-repeat bg-center"
                                    :style="
                                        'background-image: url(\'' +
                                        imagePreview +
                                        '\');'
                                    "
                                />
                                <label class="text-sm">
                                    <input
                                        type="checkbox"
                                        required
                                        class="mr-1"
                                    />Eine
                                    <a
                                        class="text-link"
                                        target="_blank"
                                        href="https://dpsg.de/fileadmin/daten/dokumente/infopool/corporatedesign/Oeffentlichkeitsarbeit/DPSG_Einwilligung_Foto_Video.pdf"
                                        >schriftliche Vereinbarung</a
                                    >
                                    über die Online-Nutzung von diesem Foto für
                                    die Aktion
                                    <strong>Trotzem13</strong>
                                    liegt vor.
                                </label>
                                <div class="text-right text-sm text-red-800">
                                    <button
                                        class="hover:text-red-600 hover:underline"
                                        @click="removeImage"
                                        type="button"
                                    >
                                        Bild entfernen
                                    </button>
                                </div>
                            </div>
                        </InputLabel>

                        <InputLabel
                            label="Wie viel seid ihr in der Gruppe?"
                            :error="form.errors.size"
                        >
                            <input
                                type="number"
                                class="mt-1 w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-200"
                                v-model="form.size"
                                min="1"
                                required
                            />
                        </InputLabel>

                        <RadioInput
                            label="Wie weit würdet ihr für das Banner laufen?"
                            :error="form.errors.radius"
                            name="radius"
                            :required="true"
                            :options="distances"
                            v-model="form.radius"
                            v-slot="distance"
                        >
                            <span v-text="distance" class="mr-4" />
                        </RadioInput>

                        <InputLabel
                            label="Woher kommt ihr?"
                            :error="locationError"
                            :help="form.location"
                        >
                            <mapbox-input
                                class="mt-1"
                                v-model="form.location"
                            />
                        </InputLabel>

                        <InputLabel label="Stamm" :error="form.errors.stamm_id">
                            <select
                                class="mt-1 w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-200"
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
                        </InputLabel>

                        <RadioInput
                            label="Stufe"
                            :error="form.errors.stufe_id"
                            name="stufe_id"
                            :required="true"
                            :options="stufen"
                            v-model="form.stufe_id"
                            v-slot="option"
                        >
                            <StufenPill
                                :stufe="option"
                                :class="
                                    form.stufe_id && form.stufe_id != option.id
                                        ? 'bg-opacity-25'
                                        : ''
                                "
                            />
                        </RadioInput>
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
import MapboxInput from "../../input/MapboxInput.vue";
import RadioInput from "../../input/RadioInput.vue";
import StufenPill from "../../components/StufenPill.vue";

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        AppLayout,
        MapboxInput,
        RadioInput,
        StufenPill,
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
                location: null,
                radius: "",
                image: null,
            }),
            imagePreview: null,
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
        submit() {
            this.form.image = null;
            if (this.imagePreview) {
                this.form.image = this.$refs.image.files[0];
            }
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
        updatePreview() {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imagePreview = e.target.result;
            };
            reader.readAsDataURL(this.$refs.image.files[0]);
        },
        removeImage() {
            this.$refs.image.value = null;
            this.imagePreview = null;
        },
    },
};
</script>
