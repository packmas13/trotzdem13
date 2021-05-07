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
            <img class="" :src="team.image || '/img/placeholder.png'" />
            <div class="flex justify-start">
                <svg
                    v-if="team.image"
                    @click="removeImage"
                    class="w-6 h-6 cursor-pointer"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <title>Bild löschen</title>
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <svg
                    @click="showChangeImage"
                    class="w-6 h-6 cursor-pointer"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <title>Bild ändern</title>
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                </svg>
            </div>
            <change-team-image :team="team" v-if="changeImage" @finished="hideChangeImage"/>
        </div>
        <div class="flex-auto bg-gray-50 border rounded">
            <div v-if="!team.is_approved" class="p-5 bg-blue-100 text-blue-800">
                Deine Gruppe wird verifiziert. Sobald sie freigegeben ist, wird
                sie auf der öffentlichen Seite präsentiert.
            </div>
            <div v-else-if="team.handovers && team.handovers.length">
                <div
                    v-for="handover in team.handovers"
                    :key="handover.id"
                    class="p-2 bg-green-50 text-green-800 mb-2"
                >
                    Ihr kriegt das
                    <BannerPill
                        :banner="handover.banner"
                        :variant="handover.variant"
                    />
                    <strong
                        >spätestens am
                        {{ formatDate(handover.received_at) }}</strong
                    >, von der Gruppe:<br />
                    <other-team
                        class="text-black"
                        :team="handover.previous_team"
                    />
                    <br />
                    und gibt es bitte
                    <strong
                        >spätestens am
                        {{
                            formatDate(handover.next_handover.received_at)
                        }}</strong
                    >
                    weiter, an die Gruppe:<br />
                    <other-team
                        class="text-black"
                        :team="handover.next_handover.team"
                    />
                </div>
            </div>
            <div v-else class="p-5 bg-blue-100 text-blue-800">
                Deine Gruppe wurde verifiziert. Sobald der Zeitplan des
                Bannerlaufs steht werden wir dich informieren.<br />
            </div>
            <div
                v-if="team.is_approved && !team.can_choose_challenge"
                class="p-5 bg-blue-100 text-blue-800"
            >
                Bald könnt ihr euer Projekt auswählen.
            </div>
            <details :open="team.users.length == 1">
                <summary class="text-gray-700 text-sm cursor-pointer p-2">
                    Gruppen-Mitglieder ({{ team.users.length }})
                </summary>
                <ul class="ml-5 my-2 text-sm list-dash list-inside">
                    <li v-for="(user, i) in team.users" :key="i">
                        <strong
                            v-if="team.leader_id == user.id"
                            v-text="user.name"
                            title="Gruppenverantwortliche:r"
                        />
                        <template v-else>{{ user.name }}</template>
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
            <details
                v-if="
                    team.currentChallenges.length || team.can_choose_challenge
                "
                open
            >
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
                <div v-else class="p-2">
                    <ChallengeDetail
                        v-for="challenge in team.currentChallenges"
                        :key="challenge.id"
                        :challenge="challenge"
                    >
                        <template v-slot:actions v-if="challenge.team_id">
                            <div
                                v-if="!challenge.approved_at"
                                class="p-5 bg-blue-100 text-blue-800"
                            >
                                Euer Projekt wird geprüft. Sobald es freigegeben
                                ist, könnt ihr loslegen.
                            </div>
                            <div v-else class="p-5 bg-green-100 text-green-800">
                                Euer Projekt wurde freigegeben. Ihr könnt jetzt
                                loslegen!
                            </div>
                        </template>
                    </ChallengeDetail>
                </div>
            </details>
            <details v-if="team.contact_name">
                <summary class="text-gray-700 text-sm cursor-pointer p-2">
                    Kontaktdaten
                </summary>
                <div class="ml-5">
                    <span>Name: {{ team.contact_name }}</span
                    ><br />
                    <span>Straße: {{ team.contact_street }}</span
                    ><br />
                    <span>Postleitzahl: {{ team.contact_zip }}</span
                    ><br />
                    <span>Ort: {{ team.contact_city }}</span
                    ><br />
                    <span>Handynummer: {{ team.contact_phone }}</span
                    ><br />
                    <span>Email-Adresse: {{ team.contact_email }}</span>
                </div>
            </details>
        </div>
    </div>
</template>

<script>
import QRCode from "qrcode";
import JetButton from "@/Jetstream/Button";
import BannerPill from "../../components/BannerPill.vue";
import ChallengeDetail from "../challenge/_Show";
import OtherTeam from "./_OtherTeam.vue";
import ChangeTeamImage from "@/components/ChangeTeamImage";

export default {
    props: {
        team: {
            type: Object,
        },
    },
    components: {
        ChangeTeamImage,
        BannerPill,
        ChallengeDetail,
        OtherTeam,
        JetButton
    },
    data() {
        return {
            joinQrcode: null,
            changeImage: false,
        };
    },
    computed: {
        joinLink() {
            return this.route("app.team.join", { code: this.team.join_code });
        },
        formatDate() {
            return (s) => {
                const d = new Date(s);
                return d.toLocaleDateString("de-DE", {
                    day: "numeric",
                    month: "long",
                });
            };
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
    methods: {
        showChangeImage() {
            this.changeImage = true;
        },
        hideChangeImage() {
            this.changeImage = false;
        },
        removeImage() {
            if (confirm("Bild wirklich löschen?")) {
                this.$inertia.post(route("app.team.image", this.team.id));
            }
        }
    }
};
</script>
