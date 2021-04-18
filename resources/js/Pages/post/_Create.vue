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
                    required
                />
                <p
                    v-if="form.errors.content"
                    v-text="form.errors.content"
                    class="text-sm text-red-600 mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-2">
                <label>
                    <input
                        type="checkbox"
                        class="mr-1"
                        v-model="banner_related"
                    />
                    <span class="text-gray-600">Beitrag zum Banner?</span>
                </label>
                <RadioInput
                    label="Stufenbanner"
                    :error="form.errors.banner_id"
                    name="banner_id"
                    :required="true"
                    :options="banners"
                    v-model="form.banner_id"
                    v-slot="option"
                    v-if="banner_related"
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
import AppLayout from "@/Layouts/AppLayout";

import JetActionMessage from "@/Jetstream/ActionMessage";
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import BannerPill from "@/components/BannerPill";
import CategoryIcon from "@/components/CategoryIcon";
import RadioInput from "@/input/RadioInput";
import {EditorContent} from '@tiptap/vue-3'

export default {
    components: {
        CategoryIcon,
        BannerPill,
        JetActionMessage,
        JetButton,
        JetFormSection,
        AppLayout,
        RadioInput,
        EditorContent,
    },
    props: {
        banners: {
            type: Object,
        },
        team: {
            type: Object,
        },
    },
    data() {
        return {
            form: this.$inertia.form({
                subject: "",
                content: "",
                team_id: this.team.id,
                banner_id: "",
                challenge_id: "",
            }),
            banner_related: false,
            challenge_related: false,
            editor: null,
        };
    },

    mounted() {
        this.editor = new Editor({
            content: '<p>I’m running tiptap with Vue.js. 🎉</p>',
        })
    },

    beforeUnmount() {
        this.editor.destroy()
    },

    methods: {
        createPost() {
            this.form.post(route("app.post.store"), {
                onSuccess: () => this.form.reset(),
                onError: () => {},
            });
        },
    },
};
</script>
