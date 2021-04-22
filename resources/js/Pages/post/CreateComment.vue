<template>
    <form @submit.prevent="createComment">
            <div class="mt-1 p-2 bg-white shadow-xl sm:rounded-lg flex flex-row flex-nowrap">
                <input
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
                    Senden
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
    },
}
</script>

<style scoped>

</style>