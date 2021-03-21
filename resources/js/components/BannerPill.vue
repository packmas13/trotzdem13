<template>
    <span
        :class="
            'bg-' + banner.color + '-light' + ' text-' + banner.color + '-dark'
        "
        class="px-2 py-1 rounded-full inline-block"
        v-text="printStufe ? banner.stufe : banner.name"
    />
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
        default: false
      }
    },
};
</script>
