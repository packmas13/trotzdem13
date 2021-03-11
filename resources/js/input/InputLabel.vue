<template>
    <label class="col-span-6 sm:col-span-4">
        <span v-text="label" />
        <slot />
        <small v-if="help" class="text-gray-600" v-text="help" />
        <p v-if="error" v-text="error" class="text-sm text-red-600 mt-2" />
    </label>
</template>

<script>
export default {
    props: {
        label: {
            type: String,
            required: true,
        },
        error: {
            type: [String],
            required: false,
        },
        help: {
            type: [Object, String],
            default: "",
        },
    },
};
</script>
