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
                    <details class="px-4 py-2 bg-white sm:p-6">
                        <summary class="py-2">Neuen Beitrag erstellen</summary>
                        <PostCreate :banners="banners" :team="selectedTeam" v-if="selectedTeam"/>
                        <div v-else>
                            <h3>Für welches Team möchtest du einen Beitrag erstellen?</h3>
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
                            <PostDetail :post="post" />
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
            type: Array,
        },
        banners: {
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
