<template>
    <div>
        <strong>{{ team.name }}</strong> ({{ team.troop.name
        }}<template v-if="team.troop.id != team.district.id"
            >, {{ team.district.name }}</template
        >)
        <div v-if="team.contact">
            <small>Gruppenverantwortliche:r:</small> {{ team.contact.name
            }}<br />
            <a
                :href="'mailto:' + team.contact.email"
                class="text-link"
                v-text="team.contact.email"
            /><br />
            <a
                :href="'tel:' + team.contact.phone"
                class="text-link"
                v-text="team.contact.phone"
            />
        </div>
        <div v-else class="text-sm italic text-gray-600">
            Kontaktdaten können nur von Gruppenverantwortliche:r gesehen werden.
        </div>
    </div>
</template>

<script>
export default {
    props: {
        team: {
            type: Object,
            required: true,
        },
    },
};
</script>
