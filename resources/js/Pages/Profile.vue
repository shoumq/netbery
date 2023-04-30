<script setup>
import Layout from '@/Layouts/Layout.vue';

let testImg = 'https://sun1-14.userapi.com/impg/L16pctUv_LjgDquGYmrtnIsLOOeePXmizcwUKw/Ms4qi0pf9Bk.jpg?size=1620x2160&quality=95&sign=31e693c2d9c4f43335c97945ffbe8e66&type=album'
</script>

<template>
    <Layout>
        <div class="profile">
            <div class="profile-top-j">
                <div class="profile-top">
                    <img class="profile-img" :src="'../storage/images/' + filenameData" alt=""
                         v-if="$page.props.auth.user.id !== user.id">

                    <label class="input-file" v-else-if="$page.props.auth.user.id === user.id">
                        <input type="file" name="file" class="file-input" @change="storeImage">
                        <img class="profile-img" :src="'../storage/images/' + filenameData" alt="">
                    </label>

                    <div class="flex-info">
                        <div class="flex">
                            <div class="profile-name">{{ user.name }} {{ user.surname }}</div>
                            <div v-if="user.admin === '1'">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#0d6efd" class="bi bi-patch-check"
                                     viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                          d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                    <path
                                        d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="profile-desc" v-if="$page.props.auth.user.name !== user.name">{{
                                user.status
                            }}
                        </div>
                        <form class="profile-desc" v-if="$page.props.auth.user.id === user.id">
                            <input @input="updateStatus" type="text" v-model="status"
                                   :class="{'input': true, 'input-status': true, 'input-status__success': status_success}"
                                   placeholder="Ваш статус">
                        </form>
                        <a class="profile-info">Email: {{ user.email }}</a>
                    </div>
                </div>

                <div class="profile-top__b" v-if="$page.props.auth.user.id === user.id">
                    <button class="btn btn-primary">Редактировать</button>
                    <button class="btn btn-primary" @click="logoutFun">Выйти</button>
                </div>

                <div class="profile-top__b" v-else-if="$page.props.auth.user.id !== user.id">
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
                                <img class="posts-item__img" :src="'../storage/images/' + filenameData" alt="">
                            </div>
                            <div>
                                <div class="posts-item__title">{{ user.name }}
                                </div>
                                <div class="posts-item__time">{{ getTime(item.time) }}</div>
                            </div>
                        </div>

                        <div class="posts-item__content">{{ item.body }}</div>

                        <div :class="{'like': true, 'like_is': false}"
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
                <div class="content-info__item2" v-if="friendsData.length !== 0">
                    <a href="#" class="content-info__title">Знакомые</a>
                    <div class="content-info__flex">
                        <a :href="'/user/' + checkLogin(item.user_one_login, item.user_two_login, checkHome)"
                           class="content-info__item" v-for="item in friendsData">
                            <img class="content-info__item-img"
                                 :src="'../storage/images/' + checkImage(item.user_one_img, item.user_two_img, checkHome)"
                                 alt="">
                            <div class="content-info__item-title">
                                {{ checkName(item.user_one, item.user_two, checkHome).split(' ')[0] }}
                            </div>
                        </a>
                    </div>
                </div>

                <div class="content-info__item2" v-if="communities.length !== 0">
                    <a href="#" class="content-info__title">Подписки</a>
                    <div class="content-info__flex2">
                        <a :href="'/community/' + item.communities[0].id"
                           class="content-info__item3" v-for="item in communities">
                            <img class="content-info__item-img" :src="'../storage/images/' + item.communities[0].img_id"
                                 alt="">
                            <div class="content-info__item-title">
                                {{ item.communities[0].title }}
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
            status: this.user.status,
            status_success: false,
            friendsData: this.friends,
            checkHome: this.$page.props.auth.user.name === this.user.name,
            filename: '',
            file: '',
            filenameData: this.user.img_id,
            like: 0
        }
    },

    props: ['user', 'posts', 'friends', 'communities'],

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

        getBool(bool) {
            return bool === 1;
        },

        storeLike(post_id) {
            axios.get('/post_like/' + post_id)
                .then((response) => {
                    this.postsData.find(x => x.id === parseInt(post_id)).likes = response.data.likes
                })
        },

        checkCountLike() {
            axios.get('/post_like_check/' + '1')
        },

        updateStatus() {
            axios.post('/user/update_status', {
                status: this.status
            })
        },

        getTime(time) {
            return time.split(':')[0] + ':' + time.split(':')[1]
        },

        createDialog() {
            axios.post('/create_dialog/', {
                id: this.user.id
            }).then(response => {
                window.location.href = `/chat/${response.data}`
            })
        },

        storeImage(event) {
            this.filename = event.target.files[0].name;
            this.file = event.target.files[0];

            let formData = new FormData();
            formData.append('file', this.file);

            axios.post(`/user/update_image/`, formData)
                .then(() => {
                    this.filenameData = this.filename;
                })
        },

        checkName(name1, name2, home) {
            if (home === true) {
                if (name1 === this.$page.props.auth.user.name + ' ' + this.$page.props.auth.user.surname) {
                    return name2
                } else {
                    return name1
                }
            } else {
                if (name1 === this.$page.props.auth.user.name + ' ' + this.$page.props.auth.user.surname) {
                    return name1
                } else {
                    return name2
                }
            }

        },

        checkLogin(name1, name2, home) {
            if (home === true) {
                if (name1 === this.$page.props.auth.user.login) {
                    return name2
                } else {
                    return name1
                }
            } else {
                if (name1 === this.$page.props.auth.user.login) {
                    return name1
                } else {
                    return name2
                }
            }
        },

        checkImage(name1, name2, home) {
            if (home === true) {
                if (name1 === this.$page.props.auth.user.img_id) {
                    return name2
                } else {
                    return name1
                }
            } else {
                if (name1 === this.$page.props.auth.user.img_id) {
                    return name1
                } else {
                    return name2
                }
            }
        }
    },

    mounted() {
        this.checkCountLike();
        window.Echo.channel('store_post')
            .listen('.store_post', response => {
                this.postsData.unshift(response.post)
            })

        // window.Echo.channel('store_like')
        //     .listen('.store_like', response => {
        //         console.log(response)
        //     })
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

.posts
    margin-top: 0 !important

.input-news
    margin-bottom: 30rem

.file-input
    display: none
</style>
