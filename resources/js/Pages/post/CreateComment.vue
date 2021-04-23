<template>
    <form @submit.prevent="createComment">
            <div class="mt-1 p-2 bg-white shadow-xl sm:rounded-lg flex flex-row flex-nowrap">
                <input
                    ref="input"
                    type="text"
                    class="rounded-md border-gray-300 flex-grow"
                    v-model="form.content"
                    placeholder="Neuer Kommentar..."
                    required
                >
                <jet-button
                    class="ml-1"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    <svg class="w-6 h-6 transform rotate-90" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                    </svg>
                </jet-button>
            </div>
    </form>
</template>

<script>
import JetButton from "@/Jetstream/Button";

export default {
    name: "CreateComment",
    components: {
        JetButton,
    },
    props: {
        post_id: {
            type: Number,
        },
    },
    data() {
        return {
            form: this.$inertia.form({
                post_id: this.post_id,
                content: "",
            }),
        };
    },

    methods: {
        createComment() {
            this.form.post(route("app.comment.store"), {
                preserveScroll: true,
                onSuccess: () => this.form.reset(),
                onError: (error) => {
                    this.form.error = error;
                },
            });
        },
        focus() {
            this.$refs.input.focus()
        }
    },
}
</script>

<style scoped>

</style>