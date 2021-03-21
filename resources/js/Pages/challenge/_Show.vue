<template>
    <div class="flex-auto bg-gray-50 border rounded">
        <h3 class="text-2xl">
          <CategoryIcon :category="challenge.category"/>
            {{ challenge.title }}
        </h3>
        <slot name="info"></slot>
        <small class="">
            Geeignet für: <BannerPill v-for="banner in challenge.banners" :banner="banner" print-stufe class="-mr-2" />
        </small>
        <div class="m-4">{{ challenge.description }}</div>
        <slot name="actions"></slot>
    </div>
</template>

<script>
import BannerPill from "@/components/BannerPill.vue";
import CategoryIcon from "@/components/CategoryIcon";

export default {
    props: {
        challenge: {
            type: Object,
        },
    },
    components: {
        BannerPill,
        CategoryIcon
    },
};
</script>
