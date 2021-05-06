<template>
    <app-layout current-route="app.post.index">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Beitrag bearbeiten
            </h2>
        </template>
            <div class="my-1 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg p-4">
                    <form @submit.prevent="updatePost">
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
                                            <banner-pill :banner="post.team.banner"/>
                                        </span>
                                    </label>
                                </div>
                                <div class="mt-1" v-if="challenges.length">
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
                        </div>

                        <div class="flex justify-between mt-6">
                            <div class="flex">
                                <jet-button
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Speichern
                                </jet-button>
                                <jet-action-message :on="form.recentlySuccessful" class="ml-3">
                                    Gespeichert.
                                </jet-action-message>
                                <inertia-link
                                    :href="route('app.post.index')"
                                    class="secondary-button mr-3"
                                >
                                    Abbrechen
                                </inertia-link>
                            </div>

                            <button
                                @click="deletePost"
                                type="button"
                                class="danger-button"
                            >
                                Löschen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    </app-layout>
</template>

<script>
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import BannerPill from "@/components/BannerPill";
import CategoryIcon from "@/components/CategoryIcon";
import RadioInput from "@/input/RadioInput";
import VueSelect from 'vue-next-select'
import AppLayout from "@/Layouts/AppLayout";

export default {
    components: {
        AppLayout,
        CategoryIcon,
        BannerPill,
        JetActionMessage,
        JetButton,
        JetFormSection,
        RadioInput,
        VueSelect,
    },
    props: {
        post: {
            type: Object,
        },
        banners: {
            type: Object,
        },
        challenges: {
            type: Object,
        },
    },
    data() {
        const team = this.post.team
        const currentChallengeId = team.current_challenges.length > 0 ? team.current_challenges[0].id : null
        return {
            form: this.$inertia.form({
                subject: this.post.subject,
                content: this.post.content,
                banner_id: this.post.banner_id,
                challenge_id: parseInt(this.post.challenge_id ? this.post.challenge_id : currentChallengeId),
                banner_related: this.post.banner_id != null,
                challenge_related: this.post.challenge_id != null,
            }),
        };
    },

    mounted() {
        let teamChallengeIds = this.post.team.challenges.map(challenge => challenge.id);
        this.challenges.sort((a, b) => {
            return teamChallengeIds.includes(b.id) - teamChallengeIds.includes(a.id)
        })
    },

    methods: {
        updatePost() {
            this.form.banner_id = this.form.banner_related ? this.post.team.banner.id : null;
            this.form.challenge_id = this.form.challenge_related ? this.form.challenge_id : null;
            this.form.post(route("app.post.update", this.post.id));
        },
        deletePost() {
            if (!confirm("Beitrag wirklich löschen?")) {
                return;
            }
            this.$inertia.post(route("app.post.delete", this.post.id));
        },
    },
};
</script>

<style>
.icon.arrow-downward {
    color: #999;
    border-style: solid;
    border-width: 4px 4px 0;
    border-color: #999 transparent transparent;
    content: '';
    transition: transform .2s linear;
    cursor: pointer
}

.icon.arrow-downward.active {
    transform: rotate(90deg)
}

.vue-select {
    position: relative;
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    flex-direction: column;
    width: 100%;
    border-radius: 4px;
    border: 1px solid #999;
    box-sizing: border-box;
    outline: 0
}

.vue-select[data-is-focusing=true]:not([data-visible-length='0']) {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0
}

.vue-dropdown[data-removable=false] .vue-dropdown-item.selected:hover,.vue-select.disabled *,.vue-select.disabled input,.vue-tags[data-removable=false] .vue-tag.selected img:hover {
    cursor: not-allowed
}

.vue-select-header {
    display: flex;
    width: 100%;
    align-items: center;
    justify-content: space-between
}

.vue-select-header>.icon.arrow-downward,.vue-select-header>.icon.loading,.vue-tag>span {
    margin-right: 4px
}

.vue-dropdown,.vue-input {
    min-width: 0;
    box-sizing: border-box
}

.vue-input,.vue-tag.selected {
    display: flex;
    align-items: center;
    border-radius: 4px
}

.vue-input {
    max-width: 100%;
    padding: 4px
}

.vue-select[data-is-focusing=false] .vue-input>input,input[readonly] {
    cursor: default
}

.vue-input,.vue-input>input {
    border: 0;
    outline: 0;
    width: 100%
}

.vue-input>input {
    min-width: 0;
    font-size: .8rem;
    padding: 0
}

.vue-input>input[disabled] {
    background-color: rgb(239,239,239);
}

.vue-input>input[readonly],.vue-select-header>.vue-input>input[disabled] {
    background-color: unset
}

.vue-dropdown {
    position: absolute;
    background-color: #fff;
    z-index: 1;
    max-height: 300px;
    overflow-y: auto;
    width: inherit;
    left: -1px;
    margin: 0;
    padding: 0;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border: 1px solid #999;
    list-style-type: none
}

.vue-dropdown[data-visible-length='0'] {
    border: 0
}

.vue-dropdown-item {
    list-style-type: none;
    padding: 4px;
    cursor: pointer;
    min-height: 1rem
}

.vue-dropdown-item.highlighted {
    background-color: rgb(244, 242, 238);
}

.vue-dropdown-item.selected {
    background-color: rgb(31, 131, 137);
}

.vue-dropdown-item.selected.highlighted {
    background-color: rgb(31, 131, 137);
}

</style>
