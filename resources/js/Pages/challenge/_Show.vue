<template>
    <div class="flex-auto flex rounded">
        <div class="sm:mr-4 mr-2 w-24 text-center flex-shrink-0 text-sm">
            <CategoryIcon :category="challenge.category" />
            <small class="text-gray-600 block">
                {{ challenge.category.title }}
            </small>
            <slot name="info"></slot>
        </div>
        <div class="flex-auto overflow-y-hidden pr-2">
            <h2 class="text-2xl sm:text-3xl text-teal-600 break-words">
                {{ challenge.title }}
            </h2>
            <ul class="flex text-xs items-center py-1">
                <li class="pr-2">Geeignet für:</li>
                <BannerPill
                    v-for="banner in challenge.banners"
                    :key="banner.id"
                    :banner="banner"
                    print-stufe
                    class="-mr-2"
                />
            </ul>
            <p class="whitespace-pre-line text-sm sm:text-base pb-2">
                {{ challenge.description }}
            </p>
            <slot name="actions"></slot>
        </div>
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
        CategoryIcon,
    },
};
</script>
