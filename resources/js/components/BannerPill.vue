<template>
    <span
        :class="
            'bg-' + banner.color + '-light' + ' text-' + banner.color + '-dark'
        "
        class="px-2 py-1 rounded-full inline-block"
        >{{ printStufe ? banner.stufe : banner.name
        }}<sup v-if="variant">{{ variant }}</sup></span
    >
</template>

<script>
export default {
    props: {
        banner: {
            type: Object,
            required: true,
        },
        printStufe: {
            type: Boolean,
            required: false,
            default: false,
        },
        variant: {
            type: Number,
            required: false,
            default: 0,
        },
    },
};
</script>
