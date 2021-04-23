<template>
    <svg @click="toggleReact('like')" class="mx-5 w-6 h-6 cursor-pointer" :fill="hasReacted ? 'red' : 'none'" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
    </svg>
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
        reactedUsers: {
            type: Array
        },
    },
    data() {
        return {
            hasReacted: false,
            loading: false
        }
    },
    mounted() {
        this.hasReacted = this.reactedUsers.find(user => user.id === this.$page.props.user.id)
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

</style>