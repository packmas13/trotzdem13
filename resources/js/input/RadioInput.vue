<template>
    <div class="col-span-6 sm:col-span-4">
        <span v-text="label" />
        <div class="pt-2 flex flex-wrap justify-betweenm">
            <label
                class="pr-3 flex items-center"
                v-for="(option, id) in options"
                :key="id"
            >
                <input
                    type="radio"
                    :name="inputName"
                    :value="id"
                    :required="required"
                    class="mr-1"
                    :checked="modelValue == id"
                    @change="emit(id)"
                />
                <slot v-bind="option" />
            </label>
        </div>
        <small v-if="help" class="text-gray-600" v-text="help" />
        <p v-if="error" v-text="error" class="text-sm text-red-600 mt-2" />
    </div>
</template>

<script>
export default {
    props: {
        label: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: false,
            default: null,
        },
        options: {
            type: Object,
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
        required: {
            type: Boolean,
            default: false,
        },
        modelValue: String,
    },

    emits: ["update:modelValue"],
    computed: {
        inputName() {
            return (
                this.name || "radio_" + Math.random().toString(36).substring(2)
            );
        },
    },
    methods: {
        emit(value) {
            this.$emit("update:modelValue", value);
        },
    },
};
</script>
