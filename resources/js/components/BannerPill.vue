<template>
    <span
        :class="
            'bg-' + banner.color + '-light' + ' text-' + banner.color + '-dark'
        "
        class="px-2 py-1 rounded-full inline-block"
        v-text="banner.name"
    />
</template>

<script>
export default {
    props: {
        banner: {
            type: Object,
            required: true,
        },
    },
};
</script>
