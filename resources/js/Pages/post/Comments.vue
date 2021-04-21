<template>
    <div class="p-2 border-t border-gray-600">
        <p class="text-lg">Kommtentare</p>
        <div
            class="px-2 border-t"
            v-for="comment in comments"
        >
            <small class="text-xs">
                {{ comment.author.name }} ({{ (new Date(comment.created_at)).toLocaleString() }})
            </small>
            <p>
                {{ comment.content }}
            </p>
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