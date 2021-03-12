<template>
    <div class="flex justify-between">
        <h3 v-text="team.name" class="text-2xl" />
        <small class="text-right pr-2">
            <StufenPill :stufe="team.stufe" class="-mr-2" /><br />
            {{ team.stamm.name }} <br />
            <span class="text-gray-600" v-text="team.bezirk.name" />
        </small>
    </div>
    <div class="md:flex mt-4">
        <div class="md:w-48 w-full flex-shrink-0 mr-2">
            <img :src="team.image" />
        </div>
        <div class="flex-auto bg-gray-50 border rounded">
            <details :open="team.users.length == 1">
                <summary class="text-gray-700 text-sm cursor-pointer p-2">
                    Status (TODO)
                </summary>
                <div>created / submitted / accepted</div>
            </details>
            <details :open="team.users.length == 1">
                <summary class="text-gray-700 text-sm cursor-pointer p-2">
                    Team-Mitglieder ({{ team.users.length }})
                </summary>
                <ul class="ml-5 my-2 text-sm list-dash list-inside">
                    <li v-for="(user, i) in team.users" :key="i">
                        {{ user.name }}
                    </li>
                </ul>
                <div class="ml-5">
                    Du kannst weitere Team-Mitglieder einladen<br />
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
        </div>
    </div>
</template>

<script>
import QRCode from "qrcode";
import StufenPill from "../../components/StufenPill.vue";

export default {
    props: {
        team: {
            type: Object,
        },
    },
    components: { StufenPill },
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
