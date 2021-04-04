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
                Bannerlaufs steht werden wir dich informieren.<br>
            </div>
            <div v-if="team.is_approved && !team.can_choose_project" class="p-5 bg-blue-100 text-blue-800">
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
                        <template v-else>{{user.name}}</template>
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
            <details v-if="team.currentChallenges.length || team.can_choose_project" open>
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
                      <template v-slot:actions v-if="challenge.team_id" >
                        <div v-if="!challenge.approved_at" class="p-5 bg-blue-100 text-blue-800">
                          Euer Projekt wird geprüft. Sobald es freigegeben ist, könnt ihr loslegen.
                        </div>
                        <div v-else class="p-5 bg-green-100 text-green-800">
                          Euer Projekt wurde freigegeben. Ihr könnt jetzt loslegen!
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
              <span>Name: {{team.contact_name}}</span><br>
              <span>Straße: {{team.contact_street}}</span><br>
              <span>Postleitzahl: {{team.contact_zip}}</span><br>
              <span>Ort: {{team.contact_city}}</span><br>
              <span>Handynummer: {{team.contact_phone}}</span><br>
              <span>Email-Adresse: {{team.contact_email}}</span>
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
