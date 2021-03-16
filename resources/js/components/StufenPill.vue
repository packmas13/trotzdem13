<template>
    <span
        :class="
            'bg-' + stufe.color + '-light' + ' text-' + stufe.color + '-dark'
        "
        class="px-2 py-1 rounded-full inline-block"
        v-text="stufe.name"
    />
</template>

<script>
export default {
    props: {
        stufe: {
            type: Object,
            required: true,
        },
    },
};
</script>
