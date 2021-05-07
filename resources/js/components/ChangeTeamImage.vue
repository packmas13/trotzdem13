<template>
    <form @submit.prevent="changeImage">
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
            <div class="mt-1 flex justify-around">
                <button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    type="submit"
                    class="secondary-button"
                >
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Speichern</title>
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <button
                    @click="cancelImage"
                    type="button"
                    class="cancel-button"
                >
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Abbrechen</title>
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    name: "ChangeTeamImage",
    props: {
        team: {
            type: Object,
        },
    },
    data() {
        return {
            imagePreview: null,
            form: this.$inertia.form({
                image: null,
            }),
        };
    },
    methods: {
        changeImage() {
            this.form.image = null;
            if (this.imagePreview) {
                this.form.image = this.$refs.image.files[0];
                this.form.post(route("app.team.image", this.team.id), {
                    onSuccess: () => this.cancelImage(),
                });
            }
        },
        updatePreview() {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imagePreview = e.target.result;
            };
            reader.readAsDataURL(this.$refs.image.files[0]);
        },
        cancelImage() {
            this.$refs.image.value = null;
            this.imagePreview = null;
            this.$emit('finished');
        },
    },
}
</script>

<style scoped>

</style>