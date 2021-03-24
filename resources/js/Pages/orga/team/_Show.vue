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
        <div class="flex-auto bg-gray-50 border rounded flex flex-col">
            <details open class="flex-auto">
                <summary class="text-gray-700 text-sm cursor-pointer p-2">
                    {{ team.users.length }} Gruppen-Mitglieder ({{
                        team.join_code
                    }})
                </summary>
                <ul class="ml-5 my-2 text-sm list-dash list-inside">
                    <li v-for="(user, i) in team.users" :key="i">
                        <strong
                            v-if="team.leader_id == user.id"
                            v-text="user.name"
                            title="Gruppenverantwortliche:r"
                        />
                        <template v-else>{{user.name}}</template>
                        <span class="text-gray-700"> - {{user.email}}</span>
                    </li>
                </ul>
            </details>
            <div
                v-if="!team.approved_at && !approving"
                class="p-2 flex items-start"
            >
                <button
                    type="button"
                    class="primary-button mr-2"
                    @click="approve(true)"
                >
                    Gruppe Freigeben
                </button>
                <details>
                    <summary class="py-2">Gruppe Blockieren</summary>
                    <form @submit.prevent="approve(false)">
                        <InputLabel
                            class="flex flex-col mb-4"
                            label="Warum soll diese Gruppe blockiert werden?"
                            help="z.B. Spam, duplikat"
                        >
                            <input type="text" v-model="blockReason" required />
                        </InputLabel>
                        <button class="danger-button">Gruppe Blockieren</button>
                    </form>
                </details>
            </div>
        </div>
    </div>
</template>

<script>
import BannerPill from "@/components/BannerPill.vue";

export default {
    props: {
        team: {
            type: Object,
        },
    },
    components: {
        BannerPill,
    },
    data() {
        return {
            blockReason: "",
            approving: false,
        };
    },
    methods: {
        approve(approved) {
            if (this.approving) {
                return;
            }
            this.approving = true;
            const data = {
                approved,
                team_id: this.team.id,
                reason: this.blockReason,
            };
            this.$inertia.post(this.route("app.orga.team.approve"), data, {
                preserveScroll: (page) => {
                    this.approving = false;
                    return !Object.keys(page.props.errors).length;
                },
            });
        },
    },
};
</script>
