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
                        <div class="profile-name">{{ user.name }} {{ user.surname }}</div>
                        <div class="profile-desc" v-if="$page.props.auth.user.name !== user.name">{{ user.status }}</div>
                        <form  class="profile-desc" v-if="$page.props.auth.user.name === user.name">
                            <input @input="updateStatus" type="text" v-model="status" :class="{'input': true, 'input-status': true, 'input-status__success': status_success}" placeholder="Ваш статус">
                        </form>
                        <a class="profile-info">Email: {{ user.email }}</a>
                    </div>
                </div>

                <div class="profile-top__b" v-if="$page.props.auth.user.name === user.name">
                    <button class="btn btn-primary">Редактировать</button>
                    <button class="btn btn-primary" @click="logoutFun">Выйти</button>
                </div>

                <div class="profile-top__b" v-else-if="$page.props.auth.user.name !== user.name">
                    <button class="btn btn-primary" @click="createDialog">Написать сообщение</button>
                </div>
            </div>
        </div>


        <div class="content-flex">
            <div class="content-main">
                <form class="input-news" @submit.prevent="storePost" v-if="$page.props.auth.user.name === user.name">
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
                                <div class="posts-item__title">{{ user.name }}
                                </div>
                                <div class="posts-item__time">{{ getTime(item.time) }}</div>
                            </div>
                        </div>

                        <div class="posts-item__content">{{ item.body }}</div>

<!--                        <div class="like-flex">-->
<!--                            <form @click="likePost(item.id, item.likes)" class="like">-->
<!--                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray"-->
<!--                                     class="bi bi-heart-fill" viewBox="0 0 16 16">-->
<!--                                    <path fill-rule="evenodd"-->
<!--                                          d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>-->
<!--                                </svg>-->
<!--                            </form>-->
<!--                            <div class="like-count">{{ item.likes }}</div>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>


            <div class="content-info">
                <a href="#" class="content-info__title">Друзья</a>

                <div class="content-info__flex">
                    <a href="#" class="content-info__item">
                        <img class="content-info__item-img" :src="testImg" alt="">
                        <div class="content-info__item-title">Андрей</div>
                    </a>

                    <a href="#" class="content-info__item">
                        <img class="content-info__item-img" :src="testImg" alt="">
                        <div class="content-info__item-title">Андрей</div>
                    </a>

                    <a href="#" class="content-info__item">
                        <img class="content-info__item-img" :src="testImg" alt="">
                        <div class="content-info__item-title">Андрей</div>
                    </a>
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
            status: this.user.status,
            status_success: false
        }
    },

    props: ['user', 'posts'],

    methods: {
        logoutFun() {
            axios.post('/logout');
            window.location.href = '/login/'
        },

        storePost() {
            axios.post(`/post/${this.$page.props.auth.user.id}`, {
                body: this.body
            }).then(() => {
                this.body = ''
            })
        },

        updateStatus() {
            axios.post('/user/update_status', {
                status: this.status
            })
        },

        getTime(time) {
            return time.split(':')[0] + ':' + time.split(':')[1]
        },

        likePost(id, count) {
            axios.post('/post_like/' + id)
            count = 2
            return count
        },

        createDialog() {
            axios.post('/create_dialog/', {
                id: this.user.id
            }).then(response => {
                window.location.href = `/chat/${response.data}`
            })
        }
    },

    mounted() {
        window.Echo.channel('store_post')
            .listen('.store_post', response => {
                this.postsData.unshift(response.post)
            })

        window.Echo.channel('store_like')
            .listen('.store_like', response => {
                console.log(response)
            })
    }
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
</style>
