<template>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form @submit.prevent="postStore">
                <textarea v-model="content" placeholder="Envie de poster ?" class="rounded-lg border border-gray-200 w-full p-2 font-semibold resize-none focus:outline-none">
                </textarea>
                <span class="my-5 text-red-500" v-if="$page.props.errors.content">
                    {{ $page.props.errors.content }}
                </span>
                <div class="flex items-center space-x-4 justify-end mt-3">
                    <p :class="{'text-red-500': howManyChars < 0}" class="text-sm text-gray-400 font-thin">{{ howManyChars }} caractères restants</p>
                    <PrimaryButton :disabled="!canSubmit" class="bg-blue-500 hover:bg-blue-800 rounded-full font-extrabold">Post</PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {

    props: {
        errors: Object,
    },

    components: {
        PrimaryButton
    },

    methods: {
        postStore() {
            this.$inertia.post('posts', {content: this.content}, {preserveScroll: false})
        }
    },

    data() {
        return {
            content: '',
            limit: 300
        }
    },

    computed: {
        howManyChars() {
            return this.limit - this.content.length
        },

        canSubmit() {
            return this.content.length && this.howManyChars >= 0
        }
    }

}
</script>

<style scoped>
    button:disabled {
        opacity: 50%;
        cursor: not-allowed;
    }
</style>
