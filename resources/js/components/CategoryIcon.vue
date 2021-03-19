<template>
  <img
      :src="category.icon_path"
      class="h-20 w-20 rounded-full inline-block"
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
