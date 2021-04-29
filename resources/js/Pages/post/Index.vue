<template>
    <app-layout current-route="app.post.index">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Beiträge
            </h2>
        </template>


        <div class="py-4" v-if="teams.length">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="px-2 bg-white shadow-xl sm:rounded-lg">
                    <details class="px-4 py-2 bg-white sm:p-6" ref="createPostSection">
                        <summary class="py-2 cursor-pointer font-bold">
                            Neuen Beitrag erstellen
                            <span class="font-medium" v-if="selectedTeam && teams.length > 1">(Gruppe: {{ selectedTeam.name }}
                                <svg class="w-6 h-6 inline cursor-pointer" fill="currentColor" viewBox="0 0 20 20" @click.prevent="selectTeam(null); $refs.createPostSection.open = true" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>)
                            </span>
                        </summary>
                        <PostCreate :banners="banners" :challenges="challenges" :team="selectedTeam" v-if="selectedTeam"/>
                        <div v-else>
                            <h3>Für welche Gruppe möchtest du einen Beitrag erstellen?</h3>
                            <button
                                v-for="team in teams"
                                :key="team.id"
                                type="button"
                                class="primary-button mr-2"
                                @click="selectTeam(team)"
                            >
                                {{ team.name }}
                            </button>
                        </div>
                    </details>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div v-if="!posts.length" class="italic text-gray-600">
                        Keine Beiträge vorhanden.
                    </div>
                    <ul v-else>
                        <li
                            v-for="post in posts"
                            :key="post.id"
                            class="py-4 px-4 xl:px-20 even:bg-sepiaGray-100"
                        >
                            <PostDetail :post="post">
                            </PostDetail>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import PostDetail from "./_Show"
import PostCreate from "./_Create"

export default {
    components: {
        AppLayout,
        PostDetail,
        PostCreate,
    },
    props: {
        posts: {
            type: Object,
        },
        banners: {
            type: Object,
        },
        challenges: {
            type: Object,
        },
        teams: {
            type: Array,
        },
    },
    data() {
        return {
            selectedTeam: this.teams.length === 1 ? this.teams[0] : null
        };
    },
    methods: {
        selectTeam(team) {
            this.selectedTeam = team;
        },
    },
};
</script>
