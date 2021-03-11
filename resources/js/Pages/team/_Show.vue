<template>
    <h3 v-text="team.name" class="text-2xl" />
    Status: created / submitted / accepted<br />
    <details
        class="mt-4 bg-gray-50 border rounded"
        :open="team.users.length == 1"
    >
        <summary class="text-gray-700 text-sm cursor-pointer p-2">
            Team-Mitglieder ({{ team.users.length }})
        </summary>
        <ul class="ml-5 my-2 text-sm list-dash list-inside">
            <li v-for="(user, i) in team.users" :key="i">{{ user.name }}</li>
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
                    <a :href="joinLink" class="text-link">{{ joinLink }}</a>
                </li>
                <li v-if="joinQrcode">
                    mit dem QRCode:
                    <img :src="joinQrcode" class="m-4 inline-block" />
                </li>
            </ul>
        </div>
    </details>
</template>

<script>
import QRCode from "qrcode";

export default {
    props: {
        team: {
            type: Object,
        },
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
        console.log(this.joinLink);
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
