<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <h2 class="text-3xl mb-8 text-center">Passwort vergessen</h2>

        <div class="mb-4 text-sm text-gray-600">
            Haben Sie Ihr Passwort vergessen? Kein Problem. Teilen Sie uns
            einfach Ihre E-Mail-Adresse mit und wir senden Ihnen per E-Mail
            einen Link zum Zurücksetzen des Passworts, über den Sie ein Neues
            auswählen können.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="email" value="E-Mail" />
                <jet-input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                />
            </div>

            <div class="text-center mt-4">
                <jet-button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Zurücksetzungslink senden
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo";
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import JetValidationErrors from "@/Jetstream/ValidationErrors";

export default {
    components: {
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        JetInput,
        JetLabel,
        JetValidationErrors,
    },

    props: {
        status: String,
    },

    data() {
        const urlParams = new URLSearchParams(window.location.search);
        return {
            form: this.$inertia.form({
                email: urlParams.get("email") || "",
            }),
        };
    },

    methods: {
        submit() {
            this.form.post(this.route("password.email"));
        },
    },
};
</script>
