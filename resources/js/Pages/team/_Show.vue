<template>
    <div class="flex justify-between">
        <h3 v-text="team.name" class="text-2xl" />
        <small class="text-right pr-2">
            <BannerPill :banner="team.banner" class="-mr-2" />
            <br />
            {{ team.troop.name }} <br />
            <span class="text-gray-600" v-text="team.district.name" />
        </small>
    </div>
    <div class="md:flex mt-4">
        <div class="md:w-48 w-full flex-shrink-0 mr-2 text-center mb-2">
            <img :src="team.image" class="inline" />
        </div>
        <div class="flex-auto bg-gray-50 border rounded">
            <div v-if="!team.is_approved" class="p-5 bg-blue-100 text-blue-800">
                Deine Gruppe wird verifiziert. Sobald sie freigegeben ist, wird
                sie auf der öffentlichen Seite präsentiert.
            </div>
            <div v-else class="p-5 bg-green-100 text-green-800">
                Deine Gruppe wurde verifiziert. Sobald der Zeitplan des
                Bannerlaufs steht werden wir dich informieren.
            </div>
            <details :open="team.users.length == 1">
                <summary class="text-gray-700 text-sm cursor-pointer p-2">
                    Gruppen-Mitglieder ({{ team.users.length }})
                </summary>
                <ul class="ml-5 my-2 text-sm list-dash list-inside">
                    <li v-for="(user, i) in team.users" :key="i">
                        {{ user.name }}
                    </li>
                </ul>
                <div class="ml-5">
                    Du kannst weitere Mitglieder einladen<br />
                    <ul class="list-disc list-inside">
                        <li>
                            mit dem Code:
                            <code
                                class="select-all text-link"
                                v-text="team.join_code"
                            />
                        </li>
                        <li>
                            mit dem Link:
                            <a :href="joinLink" class="text-link">{{
                                joinLink
                            }}</a>
                        </li>
                        <li v-if="joinQrcode">
                            mit dem QRCode:
                            <img :src="joinQrcode" class="m-4 inline-block" />
                        </li>
                    </ul>
                </div>
            </details>
            <details :open="true">
                <summary class="text-gray-700 text-sm cursor-pointer p-2">
                  Projekte
                </summary>
                <div
                    v-if="!team.currentChallenges.length"
                    class="italic text-gray-600"
                >
                    <inertia-link
                        :href="
                            route('app.challenge.selection', { id: team.id })
                        "
                        class="m-1 secondary-button"
                        >Projekt auswählen
                    </inertia-link>
                </div>
                <div v-else>
                    <h2>Aktuelles Projekt:</h2>
                    <ChallengeDetail
                        v-for="challenge in team.currentChallenges"
                        :key="challenge.id"
                        :challenge="challenge"
                    >
                    </ChallengeDetail>
                </div>
            </details>
        </div>
    </div>
</template>

<script>
import QRCode from "qrcode";
import BannerPill from "../../components/BannerPill.vue";
import ChallengeDetail from "../challenge/_Show";

export default {
    props: {
        team: {
            type: Object,
        },
    },
    components: {
        BannerPill,
        ChallengeDetail,
    },
    data() {
        return {
            joinQrcode: null,
        };
    },
    computed: {
        joinLink() {
            return this.route("app.team.join", { code: this.team.join_code });
        },
    },
    mounted() {
        QRCode.toDataURL(this.joinLink, {
            margin: 0,
            color: {
                // dark: "#ba4b18ff",
                light: "#FFFFFF00",
            },
        }).then((url) => {
            this.joinQrcode = url;
        });
    },
};
</script>
