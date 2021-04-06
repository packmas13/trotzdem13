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
          <details v-if="team.contact_name" open>
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
          <slot name="actions"></slot>
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
