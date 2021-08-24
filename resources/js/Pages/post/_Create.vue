<template>
    <form @submit.prevent="createPost">
        <div class="grid grid-cols-6 gap-6">
            <div class="w-full col-span-6 sm:col-span-4">
                <input
                    type="text"
                    class="mt-1 w-full rounded-md border-gray-300 col-span-6 sm:col-span-4"
                    v-model="form.subject"
                    placeholder="Überschrift"
                    required
                />
                <p
                    v-if="form.errors.subject"
                    v-text="form.errors.subject"
                    class="text-sm text-red-600 mt-2"
                />

                <textarea
                    class="mt-1 w-full rounded-md border-gray-300 col-span-6 sm:col-span-4"
                    v-model="form.content"
                    placeholder="Schreibe hier deinen Beitrag..."
                    required
                />
                <p
                    v-if="form.errors.content"
                    v-text="form.errors.content"
                    class="text-sm text-red-600 mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-2">
                <div>
                    <label>
                        <input
                            type="checkbox"
                            class="mr-1"
                            v-model="form.banner_related"
                        />
                        <span class="text-gray-600">
                            Beitrag zum
                            <banner-pill :banner="team.banner"/>
                        </span>
                    </label>
                </div>
                <div class="mt-1">
                    <label>
                        <input
                            type="checkbox"
                            class="mr-1"
                            v-model="form.challenge_related"
                        />
                        <span class="text-gray-600">Beitrag zu einem Projekt?</span>
                    </label>
                    <vue-select
                        v-model="form.challenge_id"
                        :options="challenges"
                        label-by="title"
                        value-by="id"
                        searchable
                        clear-on-select
                        close-on-select
                        placeholder="Projekt auswählen!"
                        search-placeholder="Suche"
                        v-show="form.challenge_related"
                    >
                    </vue-select>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4 lg:col-span-2">
                <InputLabel
                    label="Füge deinem Beitrag ein Bild hinzu?"
                    :error="form.errors.image"
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
                        <div class="text-right text-sm text-red-800">
                            <button
                                class="hover:text-red-600 hover:underline"
                                @click="removeImage"
                                type="button"
                            >
                                Bild entfernen
                            </button>
                        </div>
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
                    </div>
                </InputLabel>
            </div>

            <div class="hidden lg:block lg:col-span-2">&nbsp;</div>

            <div class="col-span-6 sm:col-span-2 lg:col-span-2">
                <InputLabel
                    label="Füge deinem Beitrag ein Youtube-Video hinzu?"
                    :error="form.errors.youtube_url"
                >
                    <input
                        type="text"
                        class="
                            mt-1
                            w-full
                            rounded-md
                            border-gray-300
                            col-span-6
                            sm:col-span-4
                        "
                        v-model="form.youtube_url"
                        placeholder="https://www.youtube.com/watch?v=..."
                    />
                </InputLabel>
            </div>
        </div>

        <div class="flex items-center mt-6">
            <jet-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Speichern
            </jet-button>
        </div>
    </form>
</template>

<script>
import JetButton from "@/Jetstream/Button";
import BannerPill from "@/components/BannerPill";

import VueSelect from "vue-next-select";
import "vue-next-select/dist/index.css";

export default {
    components: {
        BannerPill,
        JetButton,
        VueSelect,
    },
    props: {
        banners: {
            type: Object,
        },
        challenges: {
            type: Object,
        },
        team: {
            type: Object,
        },
    },
    data() {
        const currentChallengeId = this.team.current_challenges.length > 0 ? this.team.current_challenges[0].id : null
        return {
            form: this.$inertia.form({
                subject: "",
                content: "",
                team_id: this.team.id,
                banner_id: null,
                challenge_id: currentChallengeId,
                banner_related: false,
                challenge_related: false,
                image: null,
                youtube_url: null,
            }),
            imagePreview: null,
        };
    },

    mounted() {
        let teamChallengeIds = this.team.challenges.map(challenge => challenge.id);
        this.challenges.sort((a, b) => {
            return teamChallengeIds.includes(b.id) - teamChallengeIds.includes(a.id)
        })
    },

    methods: {
        createPost() {
            this.form.image = null;
            if (this.imagePreview) {
                this.form.image = this.$refs.image.files[0];
            }
            this.form.banner_id = this.form.banner_related ? this.team.banner.id : null;
            this.form.challenge_id = this.form.challenge_related ? this.form.challenge_id : null;
            this.form.post(route("app.post.store"), {
                onSuccess: () => {
                    this.form.reset()
                    this.imagePreview = null
                    this.$refs.image.value = null
                },
                onError: () => {},
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

<style>
.vue-select {
    width: 100%;
}

.vue-dropdown-item.highlighted {
    background-color: rgb(42, 207, 204);
}

.vue-dropdown-item.selected.highlighted,
.vue-dropdown-item.selected {
    background-color: rgb(31, 131, 137);
    color: white;
}
</style>
