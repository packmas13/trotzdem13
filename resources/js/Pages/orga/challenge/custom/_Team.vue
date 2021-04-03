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
        <div class="md:w-48 w-full flex-shrink-0 mr-2 text-center mb-2" v-if="team.image">
            <img :src="team.image" class="inline" />
        </div>
        <div class="ml-2">
            <span>Name: {{team.contact_name}}</span><br>
            <span>Straße: {{team.contact_street}}</span><br>
            <span>Postleitzahl: {{team.contact_zip}}</span><br>
            <span>Ort: {{team.contact_city}}</span><br>
            <span>Handynummer: {{team.contact_phone}}</span><br>
            <span>Email-Adresse: {{team.contact_email}}</span>
        </div>
    </div>
</template>

<script>
import BannerPill from "../../../../components/BannerPill.vue";

export default {
    props: {
        team: {
            type: Object,
        },
    },
    components: {
        BannerPill,
    },
};
</script>
