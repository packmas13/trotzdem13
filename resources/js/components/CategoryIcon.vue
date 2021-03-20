<template>
  <img v-if="category"
      :src="category.icon_path"
      class="h-20 w-20 rounded-full inline-block border border-gray-400"
      :alt="category.title"
      :title="category.title"
  />
</template>

<script>
export default {
    props: {
        category: {
            type: Object,
            required: true,
        },
    },
};
</script>
