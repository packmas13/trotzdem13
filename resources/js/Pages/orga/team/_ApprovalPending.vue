<template>
    <TeamDetail :team="team">
        <template v-slot:actions>
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
        </template>
    </TeamDetail>
</template>

<script>
import TeamDetail from "./_Show";

export default {
    components: {
        TeamDetail,
    },
    props: {
        team: {
            type: Object,
        },
        errors: Object,
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
