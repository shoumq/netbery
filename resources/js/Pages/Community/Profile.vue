<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Link, Head} from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <title>{{ community.title }}</title>
    </Head>
    <Layout>
        <div class="profile">
            <div class="profile-top-j">
                <div class="profile-top">
                    <!--                    <img class="profile-img" :src="'../storage/images/' + community.img_id" alt="">-->

                    <img class="profile-img" :src="'../storage/images/' + filenameData" alt=""
                         v-if="$page.props.auth.user.id !== parseInt(community.admin)">

                    <label class="input-file" v-else-if="$page.props.auth.user.id === parseInt(community.admin)">
                        <input type="file" name="file" class="file-input" @change="storeImage">
                        <img class="profile-img" :src="'../storage/images/' + filenameData" alt="">
                    </label>

                    <div class="flex-info">
                        <div class="flex">
                            <div class="profile-name">{{ community.title }}</div>
                            <div v-if="community.isVerified === '1'">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#0d6efd" class="bi bi-patch-check"
                                     viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                          d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                    <path
                                        d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z"/>
                                </svg>
                            </div>
                        </div>
                        <form class="profile-desc" v-if="$page.props.auth.user.id === parseInt(community.admin)">
                            <input @input="updateStatus" type="text" v-model="status"
                                   :class="{'input': true, 'input-status': true}"
                                   placeholder="Ваш статус" spellcheck="false">
                        </form>
                        <div class="profile-desc" v-else>{{
                                community.status
                            }}
                        </div>
                    </div>
                </div>

                <div class="profile-top__b" v-if="$page.props.auth.user.name !== community.title">
                    <button class="btn btn-primary" @click="subscribeCommunity" v-if="isSubData === 0">
                        Подписаться
                    </button>
                    <button class="btn btn-primary" @click="unsubscribeCommunity" v-else-if="isSubData === 1">
                        Отписаться
                    </button>
                </div>
            </div>
        </div>


        <div class="content-flex">
            <div class="content-main">
                <form class="input-news dir" @submit.prevent="storePost"
                      v-if="$page.props.auth.user.id === parseInt(community.admin)">
                    <input type="text" class="input" placeholder="Что у вас нового?" v-model="body" name="body">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-send svg"
                             viewBox="0 0 16 16">
                            <path
                                d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                        </svg>
                    </button>
                </form>

                <div class="posts">
                    <div class="posts-item" v-for="item in postsData">
                        <div class="del-flex">
                            <div class="posts-item__flex">
                                <div>
                                    <img class="posts-item__img" :src="'../storage/images/' + filenameData" alt="">
                                </div>
                                <div>
                                    <div class="posts-item__title">{{ community.title }}
                                    </div>
                                    <div class="posts-item__time">{{ getTime(community.created_at) }}</div>
                                </div>
                            </div>

                            <div class="del" v-if="$page.props.auth.user.id === parseInt(community.admin)"
                                 @click="deletePost(item.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="red" class="bi bi-trash3 svg"
                                     viewBox="0 0 16 16">
                                    <path
                                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="posts-item__content">{{ item.body }}</div>

                        <div :class="{'like': true, 'like_is': item.your_like === 1}"
                             @click="storeLike(item.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-heart" viewBox="0 0 16 16">
                                <path
                                    d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                            </svg>
                            {{ item.likes }}
                        </div>
                    </div>
                </div>
            </div>


            <div class="content-info">

                <div class="content-info__item2">
                    <Link href="#" class="content-info__title">Подписчики</Link>
                    <div class="content-info__flex">
                        <Link :href="'/user/' + item.users[0].login"
                              class="content-info__item" v-for="item in communities_sub">
                            <img class="content-info__item-img" :src="'../storage/images/' + item.users[0].img_id"
                                 alt="">
                            <div class="content-info__item-title">
                                {{ item.users[0].name }}
                            </div>
                        </Link>
                    </div>
                </div>

                <div class="content-info__item2">
                    <Link href="#" class="content-info__title">Администратор</Link>
                    <div class="content-info__flex2">
                        <Link :href="'/user/' + admin.login"
                              class="content-info__item3">
                            <img class="content-info__item-img" :src="'../storage/images/' + admin.img_id"
                                 alt="">
                            <div class="content-info__item-title">
                                {{ admin.name }} {{ admin.surname }}
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>


<script>
export default {
    data() {
        return {
            body: '',
            postsData: this.posts,
            status_success: false,
            isSubData: this.isSub,
            status: this.community.status,
            filenameData: this.community.img_id
        }
    },

    props: ['community', 'posts', 'communities_sub', 'isSub', 'admin'],

    methods: {
        storePost() {
            axios.post(`/create_community_post/${this.community.id}`, {
                body: this.body
            }).then((response) => {
                this.body = ''
                this.postsData.unshift(response.data)
            })
        },

        storeLike(post_id) {
            axios.get('/community/post_like/' + post_id)
                .then((response) => {
                    this.postsData.find(x => x.id === parseInt(post_id)).likes = response.data.likes
                    this.postsData.find(x => x.id === parseInt(post_id)).your_like = response.data.my_like
                })
        },

        deletePost(post_id) {
            axios.get(`/delete_community_post/${post_id}`)
                .then(() => {
                    this.postsData.splice(this.postsData.findIndex(x => x.id === post_id), 1)
                })
        },

        subscribeCommunity() {
            axios.post('/subscribe_community/' + this.community.id)
                .then(() => {
                    this.isSubData = 1
                })
        },

        unsubscribeCommunity() {
            axios.post('/unsubscribe_community/' + this.community.id)
                .then(() => {
                    this.isSubData = 0
                })
        },

        getTime(time) {
            return time.split(':')[0] + ':' + time.split(':')[1]
        },

        updateStatus() {
            axios.post('/community/update_status/' + this.community.id, {
                status: this.status
            })
        },

        storeImage(event) {
            this.filename = event.target.files[0].name;
            this.file = event.target.files[0];

            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('community_id', this.community.id);

            axios.post(`/community/update_image/`, formData)
                .then(() => {
                    this.filenameData = this.filename;
                })
        },
    },
}
</script>

<style scoped lang="sass">
.input-status
    padding: 3rem 0
    border-radius: 0
    border: none
    border-bottom: 1px solid #dce1e6
    width: 500rem
    box-shadow: none

    @media (max-width: 768px)
        width: 100%

    &:focus
        border: none
        border-bottom: 1px solid #67a4d9

    &__success
        border: none
        border-bottom: 1px solid #3fc03f !important

.posts
    margin-top: 0 !important

.input-news
    margin-bottom: 30rem

    input
        border-radius: 100rem !important

.flex-info
    gap: 12rem !important

.file-input
    display: none

.input-file
    transition: 0.3s
    cursor: pointer

    &:hover
        filter: brightness(60%)

.dir
    background: white
    padding: 15rem
    border-radius: 10rem
    border: 1rem solid #dce1e6

    input
        background: #f4f5f6
</style>
