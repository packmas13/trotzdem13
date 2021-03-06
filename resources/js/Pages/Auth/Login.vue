<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <h2 class="text-3xl mb-8 text-center">Anmeldung</h2>

        <jet-validation-errors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

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

            <div class="mt-4">
                <jet-label for="password" value="Passwort" />
                <jet-input
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
            </div>

            <div class="text-right">
                <inertia-link
                    v-if="canResetPassword"
                    :href="route('password.request', { email: form.email })"
                    class="text-link text-sm"
                >
                    Passwort vergessen?
                </inertia-link>
            </div>

            <div class="text-center mt-4">
                <jet-button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Anmelden
                </jet-button>
            </div>
        </form>

        <template #alternative>
            <div class="text-center">
                Noch kein Konto?
                <inertia-link
                    :href="route('register', { email: form.email })"
                    class="text-link inline-block"
                >
                    Jetzt registrieren.
                </inertia-link>
            </div>
        </template>
    </jet-authentication-card>
</template>

<script>
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo";
import JetButton from "@/Jetstream/Button";
import JetInput from "@/Jetstream/Input";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetLabel from "@/Jetstream/Label";
import JetValidationErrors from "@/Jetstream/ValidationErrors";

export default {
    components: {
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        JetInput,
        JetCheckbox,
        JetLabel,
        JetValidationErrors,
    },

    props: {
        canResetPassword: Boolean,
        status: String,
    },

    data() {
        const urlParams = new URLSearchParams(window.location.search);
        return {
            form: this.$inertia.form({
                email: urlParams.get("email") || "",
                password: "",
                remember: true,
            }),
        };
    },

    methods: {
        submit() {
            this.form
                .transform((data) => ({
                    ...data,
                    remember: this.form.remember ? "on" : "",
                }))
                .post(this.route("login"), {
                    onFinish: () => this.form.reset("password"),
                });
        },
    },
};
</script>
