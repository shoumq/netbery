<script setup>
import Layout from '@/Layouts/Layout.vue';

let testImg = 'https://sun1-14.userapi.com/impg/L16pctUv_LjgDquGYmrtnIsLOOeePXmizcwUKw/Ms4qi0pf9Bk.jpg?size=1620x2160&quality=95&sign=31e693c2d9c4f43335c97945ffbe8e66&type=album'
</script>

<template>
    <Layout>
        <div class="profile">
            <div class="profile-top-j">
                <div class="profile-top">
                    <img class="profile-img" :src="testImg" alt="">
                    <div class="flex-info">
                        <div class="profile-name">{{ community.title }}</div>
                        <div class="profile-desc" v-if="$page.props.auth.user.name !== community.name">{{
                                community.status
                            }}
                        </div>
                        <form class="profile-desc" v-if="$page.props.auth.user.name === community.name">
                            <input @input="updateStatus" type="text" v-model="status"
                                   :class="{'input': true, 'input-status': true, 'input-status__success': status_success}"
                                   placeholder="Ваш статус">
                        </form>
                    </div>
                </div>

                <div class="profile-top__b" v-if="$page.props.auth.user.name !== community.title">
                    <button class="btn btn-primary" @click="subscribeCommunity" v-if="isSubData === 0">Подписаться</button>
                    <button class="btn btn-primary" @click="unsubscribeCommunity" v-else-if="isSubData === 1">Отписаться</button>
                </div>
            </div>
        </div>


        <div class="content-flex">
            <div class="content-main">
                <form class="input-news" @submit.prevent="storePost" v-if="$page.props.auth.user.id === parseInt(community.admin)">
                    <input type="text" class="input" placeholder="Что у вас нового?" v-model="body" name="body">
                    <button type="submit" class="btn btn-primary">Опубликовать</button>
                </form>

                <div class="posts">
                    <div class="posts-item" v-for="item in postsData">
                        <div class="posts-item__flex">
                            <div>
                                <img class="posts-item__img" :src="testImg" alt="">
                            </div>
                            <div>
                                <div class="posts-item__title">{{ communities_sub[0].communities[0].title }}
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
                        <a :href="'/community/' + 1"
                           class="content-info__item" v-for="item in communities_sub">
                            <img class="content-info__item-img" :src="testImg" alt="">
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
        }
    },

    props: ['community', 'posts', 'communities_sub', 'isSub'],

    methods: {
        storePost() {
            axios.post(`/create_community_post/${this.communities_sub[0].communities[0].id}`, {
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
    },
}
</script>

<style scoped lang="sass">
.input-status
    padding: 3rem 0
    border-radius: 0
    border: none
    border-bottom: 1px solid #dce1e6

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
</style>
