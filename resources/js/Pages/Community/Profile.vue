<script setup>
import Layout from '@/Layouts/Layout.vue';
</script>

<template>
    <Layout>
        <div class="profile">
            <div class="profile-top-j">
                <div class="profile-top">
<!--                    <img class="profile-img" :src="'../storage/images/' + community.img_id" alt="">-->

                    <img class="profile-img" :src="'../storage/images/' + filenameData" alt="" v-if="$page.props.auth.user.id !== parseInt(community.admin)">

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
                                   placeholder="Ваш статус">
                        </form>
                        <div class="profile-desc" v-else>{{
                                community.status
                            }}
                        </div>
                    </div>
                </div>

                <div class="profile-top__b" v-if="$page.props.auth.user.name !== community.title">
                    <button class="btn btn-primary" @click="subscribeCommunity" v-if="isSubData === 0">Подписаться
                    </button>
                    <button class="btn btn-primary" @click="unsubscribeCommunity" v-else-if="isSubData === 1">
                        Отписаться
                    </button>
                </div>
            </div>
        </div>


        <div class="content-flex">
            <div class="content-main">
                <form class="input-news" @submit.prevent="storePost"
                      v-if="$page.props.auth.user.id === parseInt(community.admin)">
                    <input type="text" class="input" placeholder="Что у вас нового?" v-model="body" name="body">
                    <button type="submit" class="btn btn-primary">Опубликовать</button>
                </form>

                <div class="posts">
                    <div class="posts-item" v-for="item in postsData">
                        <div class="posts-item__flex">
                            <div>
                                <img class="posts-item__img"  :src="'../storage/images/' + filenameData" alt="">
                            </div>
                            <div>
                                <div class="posts-item__title">{{ community.title }}
                                </div>
                                <div class="posts-item__time">{{ getTime(item.created_at) }}</div>
                            </div>
                        </div>
                        <div class="posts-item__content">{{ item.body }}</div>
                    </div>
                </div>
            </div>


            <div class="content-info">

                <div class="content-info__item2">
                    <a href="#" class="content-info__title">Подписчики</a>
                    <div class="content-info__flex">
                        <a :href="'/user/' + item.users[0].login"
                           class="content-info__item" v-for="item in communities_sub">
                            <img class="content-info__item-img" :src="'../storage/images/' + item.users[0].img_id"
                                 alt="">
                            <div class="content-info__item-title">
                                {{ item.users[0].name }}
                            </div>
                        </a>
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

    props: ['community', 'posts', 'communities_sub', 'isSub'],

    methods: {
        storePost() {
            axios.post(`/create_community_post/${this.community.id}`, {
                body: this.body
            }).then((response) => {
                this.body = ''
                this.postsData.unshift(response.data)
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
                    console.log(this.filenameData)
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

.flex-info
    gap: 12rem !important

.file-input
    display: none

</style>
