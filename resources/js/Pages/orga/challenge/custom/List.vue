<template>
    <app-layout current-route="app.orga.challenge.pending">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Eingereichte Projekte
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div
                        v-if="Object.keys(errors).length"
                        class="bg-red-100 p-5 text-red-800 border-l-4 border-r-4 border-red-800"
                    >
                        <ul>
                            <li v-for="(error, field) in errors" :key="field">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                    <div class="p-6 sm:px-20">
                        <div v-if="!challenges.length" class="italic text-gray-600">
                            Keine eingereichten Projekte vorhanden.
                        </div>
                        <ul v-else>
                            <li
                                v-for="challenge in challenges"
                                :key="challenge.id"
                                class="border-b py-4"
                            >
                              <ChallengeApproval :challenge="challenge"/>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ChallengeApproval from "./Approval";

export default {
    components: {
        AppLayout,
      ChallengeApproval,
    },
    props: {
        challenges: {
          type: Array,
        },
        errors: Object,
    },
    data() {
      return {
        rejectReason: "",
      };
    },
    methods: {
      approve(challenge, approved) {
        const data = {
          approved,
          challenge_id: challenge.id,
          reason: this.rejectReason,
        };
        this.$inertia.post(this.route("app.orga.challenge.approve"), data, {
          preserveScroll: (page) => {
            return !Object.keys(page.props.errors).length;
          },
        });
      },
      convert(challenge) {
        const data = {
          challenge_id: challenge.id,
          quantity: this.form.quantity
        };
        this.$inertia.post(this.route("app.orga.challenge.convert"), data, {
          preserveScroll: (page) => {
            return !Object.keys(page.props.errors).length;
          },
        });
      },
    },
};
</script>
