<script>

import AppLayout from '@/Layouts/AppLayout.vue';
import CreatePost from "@/Pages/Post/Create.vue";
import ResponsePost from '@/Pages/Post/Response.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {

    props: {
        errors: Object,
        confirmsTwoFactorAuthenticatiVon: Boolean,
        sessions: Array,
        posts: Array
    },

    components: {
        AppLayout,
        PrimaryButton,
        CreatePost,
        ResponsePost
    },

    methods: {},

    data() {
        return {
            content: '',
            content2: '',
            limit: 300
        }
    },

    computed: {

        howManyChars() {
            return this.limit - this.content2.length
        },

        canSubmit() {
            return this.content2.length && this.howManyChars >= 0
        },
    }

}
</script>

<style scoped>
button:disabled {
    opacity: 50%;
    cursor: not-allowed;
}
</style>

<template>
    <AppLayout title="Posts">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Posts
            </h2>
        </template>

        <CreatePost></CreatePost>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div v-for="post in posts" v-bind:key="post.id" class="block">
                    <div class="flex items-center space-x-4 bg-white overflow-hidden rounded
                rounded-b-none border-b-2 border-gray-200 py-6 px-4 mt-20">
                        <img class="h-16 w-16 object-cover rounded-full" :src="post.user.profile_photo_url">
                        <div class="flex flex-col w-2/3">
                            <div>
                                <a class="text-sm text-gray-900 font-bold hover:text-blue-400"
                                   :href="`/profile/${post.user.name}`">
                                    {{ post.user.name }}
                                </a>
                                <span class="font-thin text-gray-400 ml-5">
                                {{ post.created_at }}
                            </span>
                            </div>
                            <div class="text-sm text-gray-600 font-thin">
                                {{ post.content }}
                            </div>
                        </div>
                    </div>

                    <div class="block">
                        <form>
                         <textarea v-model="content2" placeholder="Envie de répondre ?" class="rounded-lg border border-gray-200 w-full p-2 font-semibold
                                     resize-none focus:outline-none">
                         </textarea>
                            <span class="my-5 text-red-500" v-if="$page.props.errors.content2">
                                {{ $page.props.errors.content2 }}
                            </span>
                            <div class="w-40 flex items-center space-x-4 justify-end mt-1 mb-2">
                            </div>
                            <div class="flex items-center space-x-4 justify-end mb-8">
                                <p :class="{'text-red-500': howManyChars < 0}" class="text-sm text-gray-400 font-thin">
                                    {{ howManyChars }} caractères restants</p>
                                <a :href="`/response/${post.id}/${content2}`"
                                   onclick="document.getElementById('response-form').submit()"
                                   class="bg-white text-blue-500 cursor-pointer px-5 py-2 flex-shrink-0 hover:text-white border border-blue-500 leading-tight hover:bg-blue-500 rounded-full font-extrabold transition-all duration-300">Répondre</a>
                                <a v-if="post.user.name === 'Ugo Morisseau' " :href="`/destroy/${post.id}`" class="bg-blue-500 text-white cursor-pointer px-5 py-2 flex-shrink-0 hover:text-blue-500 border border-white leading-tight hover:bg-white rounded-full font-extrabold transition-all duration-300">Supprimer</a>
                            </div>
                        </form>


                        <!--                            <div>-->
                        <!--                                <div>-->

                        <!--                                        <div class="flex items-center space-x-4 justify-end mt-1 mb-5">-->
                        <!--                                            <primary-button as="button" method="POST" :href="`/response/${post}`" class="bg-blue-500 hover:bg-blue-800 rounded-full font-extrabold" preserve-scroll>Répondre</primary-button>-->
                        <!--                                        </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                    </div>


                    <div v-for="responsePost in post.post" v-bind:key="responsePost.id" class="flex items-center space-x-4 bg-white overflow-hidden rounded
                    rounded-b-none border-b-2 border-gray-200 py-6 px-4 mb-4">
                        <img class="h-10 w-10 object-cover rounded-full" :src="post.user.profile_photo_url">
                        <div class="flex flex-col w-2/3">
                            <div>
                                <span class="font-thin text-gray-400">
                                    En réponse à {{ post.user.name }}
                                </span>
                                <!--                                <span class="font-thin text-gray-400">-->
                                <!--                                {{ responsePost.created_at }}-->
                                <!--                            </span>-->
                            </div>
                            <div class="text-sm text-gray-600 font-thin mt-5">
                                {{ responsePost.content }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

