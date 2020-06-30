<template>
    <div class="posts">
        <div class="post" v-for="(post,index) in posts.data" :key="index">
            <h3>{{ post.name }}</h3>
            <p> {{ post.description }}</p>
            <hr>
        </div>
        <div v-if="preloader">Carregando ....</div>
        <div v-if="!hasNextPage" v-observe-visibility="visibilityChanged">...</div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        created() {
            this.fetchPosts()
        },

        computed: {
            hasNextPage() {
                return this.posts.meta.current_page === this.posts.meta.current_page.last_page;
            }
        },

        data() {
            return {
                posts: {
                    data: [],
                    meta: {
                        current_page: 1,
                        last_page: 1
                    }
                },
                page: 1,
                preloader: false,
            }
        },
        methods: {
            fetchPosts() {
                this.preloader =true;
                axios.get(`/api/v1/posts?page=${this.page}`)
                    .then(response => {
                        // this.posts = response.data
                        this.posts.data.push(...response.data.data)
                        this.posts.meta = response.data.meta;
                    })
                    .catch(response => {
                        console.error(response)
                    })
                    .finally(()=> this.preloader = false);
            },

            visibilityChanged(isVisible) {
                if (!isVisible) return;

                if (this.hasNextPage) return;

                this.page++;
                this.fetchPosts()
            }
        },
    }
</script>
