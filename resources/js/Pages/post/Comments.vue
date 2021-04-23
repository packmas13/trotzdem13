<template>
    <div class="p-2">
        <div
            class="px-2 border-t flex flex-row"
            v-for="comment in comments"
        >
            <div class="p-2 flex-grow-0">
                <img
                    class="h-9 w-9 rounded-full object-cover"
                    :src="comment.author.profile_photo_url"
                    :alt="comment.author.name"
                />
            </div>
            <div class="flex-grow">
                <small class="text-xs">
                    {{ comment.author.name }} ({{ (new Date(comment.created_at)).toLocaleString() }})
                </small>
                <p>
                    {{ comment.content }}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Comments",
    props: {
        comments: {
            type: Array
        },
    },
}
</script>