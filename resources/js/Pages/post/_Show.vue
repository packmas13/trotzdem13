<template>
    <div class="flex-auto flex rounded">
        <div class="sm:mr-4 mr-2 w-24 text-left flex-shrink-0 text-sm">
            <img :src="post.team.image" />
            <small>
                {{ post.author.name }}<br>
                {{ post.team.name }}
            </small>
            <small v-if="post.updated_at > post.created_at" class="text-gray-600 block">
                Zuletzt bearbeitet: {{ (new Date(post.updated_at)).toLocaleString() }}
            </small>
            <small v-else class="text-gray-600 block">
                Erstellt: {{ (new Date(post.created_at)).toLocaleString() }}
            </small>
            <slot name="info"></slot>
        </div>
        <div class="pr-2">
            <div class="flex justify-between">
                <h2 class="text-2xl sm:text-3xl text-teal-600 break-words">
                    {{ post.subject }}
                </h2>
                <small v-if="post.banner" class="text-right pr-2">
                    verknüpft mit: <BannerPill :banner="post.banner" class="-mr-2" />
                </small>
                <small v-if="post.challenge" class="text-right pr-2">
                    Projekt: {{ post.challenge.title }}
                </small>
            </div>
            <p class="whitespace-pre-line text-sm sm:text-base pb-2">
                {{ post.content }}
            </p>

            <slot name="actions"></slot>
        </div>
    </div>
    <div class="mt-1 pl-10">
        <Comments :comments="post.comments" />
        <CreateComment :post_id="post.id" />
    </div>
</template>

<script>
import BannerPill from "../../components/BannerPill.vue";
import Comments from "@/Pages/post/Comments";
import CreateComment from "@/Pages/post/CreateComment";

export default {
    props: {
        post: {
            type: Object,
        },
    },
    components: {
        CreateComment,
        Comments,
        BannerPill,
    },
};
</script>
