<template>
    <div class="flex-auto flex rounded">
        <div class="sm:mr-4 mr-2 w-24 text-left flex-shrink-0 text-sm">
            <p class="text-xs">
                <a :href="teamFilterLink" class="text-link">{{ post.team.name }}</a>
            </p>
            <img :src="post.team.image" />
            <p class="mt-1 text-xs">
                Erstellt von:
                {{ post.author.name }}
            </p>

            <p v-if="post.updated_at > post.created_at" class="mt-1 text-xs text-gray-600 block">
                Zuletzt bearbeitet: {{ (new Date(post.updated_at)).toLocaleString() }}
            </p>
            <p v-else class="mt-1 text-xs text-gray-600 block">
                am {{ (new Date(post.created_at)).toLocaleString() }}
            </p>
            <slot name="info"></slot>
        </div>
        <div class="pr-2 flex-grow">
            <div class="flex flex-row justify-between">
                <h2 class="text-2xl sm:text-3xl text-teal-600 break-words flex-grow">
                    {{ post.subject }}
                </h2>
                <div class="flex-grow-0">
                    <p v-if="post.banner" class="text-xs text-right pr-2">
                        <a :href="bannerFilterLink"><BannerPill :banner="post.banner" /></a>
                    </p>
                    <p v-if="post.challenge" class="text-xs text-right pr-2">
                        <a :href="challengeFilterLink" class="text-link">Projekt: {{ post.challenge.title }}</a>
                    </p>
                </div>
            </div>
            <div class="w-full my-2" >
                <div class="w-full video-container xl:mb-4 mb-1" v-if="post.video">
                    <iframe :src="post.video" allowfullscreen></iframe>
                </div>
                <img class="float-right w-full" :class="post.content.length > 500 ? 'md:w-1/2 xl:w-1/3 mb-1 ml-1' : ''" v-if="post.image" :src="post.image" />
                <p class="whitespace-pre-line text-sm sm:text-base pb-2" v-html="contentWithHashtags">
                </p>
            </div>

            <slot name="actions"></slot>
        </div>
    </div>
    <div class="mt-1 w-full pt-2 border-t border-gray-600 flex flex-row">
        <svg class="mx-5 w-6 h-6 flex-1 cursor-pointer" fill="currentColor" viewBox="0 0 20 20" @click="comment()" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
        </svg>
        <span class="w-2" />
        <Reactions class="flex-1" :reactions="post.reactions" :post_id="post.id"></Reactions>
        <jet-dropdown class="flex-grow-0" align="right" width="48" v-if="post.canEdit">
            <template #trigger>
                <button
                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out"
                >
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                </button>
            </template>

            <template #content>
                <jet-dropdown-link
                    :href="route('app.post.edit', { id: post.id })"
                >
                    Bearbeiten
                </jet-dropdown-link>
            </template>
        </jet-dropdown>
    </div>
    <div class="mt-1 pl-10 border-gray-600">
        <Comments :comments="post.comments" />
        <CreateComment ref="createComment" v-show="showCommentInput" :post_id="post.id" />
    </div>
</template>

<script>
import BannerPill from "../../components/BannerPill.vue";
import Comments from "@/Pages/post/Comments";
import CreateComment from "@/Pages/post/CreateComment";
import SecondaryButton from "@/Jetstream/SecondaryButton";
import Reactions from "@/components/Reactions";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";

export default {
    props: {
        post: {
            type: Object,
        },
    },
    components: {
        Reactions,
        SecondaryButton,
        CreateComment,
        Comments,
        BannerPill,
        JetDropdown,
        JetDropdownLink,
    },
    data() {
        return {
            showCommentInput: this.post.comments.length > 0,
        }
    },
    computed: {
        teamFilterLink() {
            return this.route("app.post.index", {team: this.post.team_id});
        },
        bannerFilterLink() {
            return this.route("app.post.index", {banner: this.post.banner_id});
        },
        challengeFilterLink() {
            return this.route("app.post.index", {project: this.post.challenge_id});
        },
        contentWithHashtags() {
            return this.escapeHTML(this.post.content).replaceAll(/#([a-zA-Z0-9_äöüÄÖÜß-]+)/g, (match) => {
                let url = this.route("app.post.index", {hashtag: match});
                return `<a href="${url}" class="text-link">${match}</a>`
            })
        },
    },
    methods: {
        comment() {
            this.showCommentInput = true
            this.$nextTick(this.$refs.createComment.focus);
        },
        escapeHTML(str) {
            let el = document.createElement('div');
            el.textContent = str;
            return el.innerHTML;
        },
    }
};
</script>
