<template>

    <div class="has-tooltip flex justify-center gap-0 mx-5">
        <svg @click="toggleReact('like')" class="w-6 h-6 cursor-pointer" :fill="hasReacted ? 'red' : 'none'" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
        <span class="ml-1" v-if="reactions.length" v-text="reactions.length"/>
        <span class="tooltip border-2 border-solid border-teal-600 bg-white rounded p-1" v-html="reactionNames" v-if="reactions.length"/>
    </div>


</template>

<script>
import SecondaryButton from "@/Jetstream/SecondaryButton";

export default {
    name: "Reactions",
    components: {SecondaryButton},
    props: {
        post_id: {
            type: Number
        },
        reactions: {
            type: Array
        },
    },
    data() {
        return {
            hasReacted: false,
            loading: false,
            showNames: false,
        }
    },
    mounted() {
        this.hasReacted = this.reactions.find(reaction => reaction.userId === this.$page.props.user.id)
    },
    computed: {
        reactionNames: function() {
            let names = this.reactions.map(reaction => reaction.userName)
            if(names.length > 11){
                names = names.slice(0,10)
                const additional = this.reactions.length - names.length
                names.push('+' + additional + ' weitere')
            }
            return names.join('<br>\n')
        }
    },
    methods: {
        toggleReact(type) {
            if(this.loading) return
            this.loading = true
            if(this.hasReacted) {
                this.hasReacted = false
                const data = {
                    post_id: this.post_id
                };
                this.$inertia.post(this.route("app.post.unreact"), data, {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.loading = false
                    },
                    onError: () => {
                        this.hasReacted = true
                        this.loading = false
                    }
                });
            }
            else{
                this.hasReacted = true
                const data = {
                    post_id: this.post_id,
                    type: type,
                };
                this.$inertia.post(this.route("app.post.react"), data, {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.loading = false
                    },
                    onError: () => {
                        this.hasReacted = false
                        this.loading = false
                    }
                });
            }
        },
    }
}
</script>

<style scoped>
.tooltip {
    visibility: hidden;
    position: absolute;
    top: 0;
    left: 50%;
    transform:translateY(-100%) translateX(-50%);
}

.has-tooltip {
    position: relative;
}

.has-tooltip:hover > .tooltip {
    visibility: visible;
    z-index: 50;
}
</style>