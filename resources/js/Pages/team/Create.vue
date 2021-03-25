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

                    <template #description>
                      Mit diesem Formular erstellst du eine neue Gruppe für die Teilnahme am trotzdem '13. <br><br>
                      Anschließend erhältst du einen Code, mit dem du die Teilnehmenden in die Gruppe einladen kannst. <br><br>
                      Außerdem prüfen wir sicherheitshalber die eingegebenen Daten, bevor wir die Gruppe freigeben, wodurch sie dann auch im öffentlichen Bereich der Webseite angezeigt wird. <br><br>
                      Sobald die Freigabe erfolgt ist, kannst du ein Projekt für die Gruppe auswählen. In der Zwischenzeit könnt ihr euch aber gerne schon mal die verfügbaren Projekte anschauen.
                    </template>

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
                            help="Dieses Bild wird veröffentlicht. Es kann zum Beispiel ein Gruppenbild sein oder auch euer Logo. Seid Kreativ!"
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
                                        href="/datenschutz/einwilligung-foto"
                                        >schriftliche Vereinbarung</a
                                    >
                                    über die Online-Nutzung dieses Fotos für
                                    die Aktion
                                    <strong>Trotzdem13</strong>
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
                            help="Wir empfehlen eine Gruppengröße von mindestens 5 und maximal 20 Teilnehmenden."
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

                        <InputLabel label="Stamm" :error="form.errors.troop_id">
                            <select
                                class="mt-1 w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-200"
                                v-model="form.troop_id"
                                required
                            >
                                <optgroup
                                    v-for="(district, districtID) in districts"
                                    :key="districtID"
                                    :label="'[' + district.name + ']'"
                                >
                                    <option
                                        v-for="(troop, sid) in district.troops"
                                        :key="sid"
                                        :value="sid"
                                        v-text="troop"
                                    />
                                    <option
                                        :value="districtID"
                                        v-text="district.name"
                                    />
                                </optgroup>
                            </select>
                        </InputLabel>

                        <RadioInput
                            label="Stufenbanner"
                            :error="form.errors.banner_id"
                            name="banner_id"
                            :required="true"
                            :options="banners"
                            v-model="form.banner_id"
                            v-slot="option"
                        >
                            <BannerPill
                                :banner="option"
                                class="mb-1"
                                :class="
                                    form.banner_id &&
                                    form.banner_id != option.id
                                        ? 'bg-opacity-25'
                                        : ''
                                "
                            />
                        </RadioInput>


                      <span class="col-span-6 sm:col-span-4 text-sm text-gray-600">
                        <span class="text-xl font-semibold">Kontaktdaten</span><br>
                        Gib hier bitte deine Kontaktdaten ein. <br>
                        Die Adresse benötigen wir unter anderem, um dir Materialien für deine Gruppe per Post zu schicken. <br>
                        Die Email-Adresse und Handynummer geben wir weiter an die Leitenden eurer Partnergruppen.
                        Mit dem Erstellen der Gruppe willigst du in die Weitergabe ein.
                      </span>
                      <InputLabel
                          label="Name (Vor- und Nachname)"
                          :error="form.errors.contact_name"
                      >
                        <input
                            type="text"
                            class="mt-1 w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-200"
                            v-model="form.contact_name"
                            required
                        />
                      </InputLabel>
                      <InputLabel
                          label="Straße und Hausnummer"
                          :error="form.errors.contact_street"
                      >
                        <input
                            type="text"
                            class="mt-1 w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-200"
                            v-model="form.contact_street"
                            required
                        />
                      </InputLabel>
                      <InputLabel
                          label="Postleitzahl"
                          :error="form.errors.contact_zip"
                      >
                        <input
                            type="text"
                            class="mt-1 w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-200"
                            v-model="form.contact_zip"
                            required
                        />
                      </InputLabel>
                      <InputLabel
                          label="Ort"
                          :error="form.errors.contact_city"
                      >
                        <input
                            type="text"
                            class="mt-1 w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-200"
                            v-model="form.contact_city"
                            required
                        />
                      </InputLabel>
                      <InputLabel
                          label="Handynummer"
                          :error="form.errors.contact_phone"
                      >
                        <input
                            type="text"
                            class="mt-1 w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-200"
                            v-model="form.contact_phone"
                            required
                        />
                      </InputLabel>
                      <InputLabel
                          label="Email-Adresse"
                          :error="form.errors.contact_email"
                      >
                        <input
                            type="email"
                            class="mt-1 w-full rounded-md border-gray-300 focus:ring focus:ring-indigo-200"
                            v-model="form.contact_email"
                            required
                        />
                      </InputLabel>

                      <label class="col-span-6 sm:col-span-4">
                        <input
                            type="checkbox"
                            required
                            class="mr-1"
                        />
                        <span class="text-gray-600">
                          Ich bin mir meiner
                          <a
                            class="text-link"
                            target="_blank"
                            href="/datenschutz/leiter"
                          >
                            Pflichten und Aufgaben
                          </a>
                          als Gruppenverantwortliche:r bewusst.
                        </span>
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
import MapboxInput from "../../input/MapboxInput.vue";
import RadioInput from "../../input/RadioInput.vue";
import BannerPill from "../../components/BannerPill.vue";

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        AppLayout,
        MapboxInput,
        RadioInput,
        BannerPill,
    },
    props: {
        districts: {
            type: Object,
        },
        banners: {
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
                troop_id: "",
                banner_id: "",
                size: "",
                location: null,
                radius: "",
                image: null,
                contact_phone: "",
                contact_email: "",
                contact_name: "",
                contact_street: "",
                contact_zip: "",
                contact_city: ""
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
