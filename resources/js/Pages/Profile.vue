<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Link, Head} from '@inertiajs/vue3';
</script>

<template>
    <Head>
        <title>{{ user.name }} {{ user.surname }}</title>
    </Head>
    <div class="dialog_wrapper" ref="dialog_wrapper"></div>
    <Layout>
        <div class="dialog_img">
            <dialog open class="dialog2" ref="imgDialogRef" role="dialog" aria-modal="true">
                <div class="dialog dialog-block">

                    <div class="img">
                        <img :src="'../storage/images/' + currentImage" alt="">

                        <div class="img-info">
                            <div class="dialog_flex">
                                <div class="name">{{ user.name }} {{ user.surname }}</div>

                                <form method="dialog">
                                    <button class="btn" @click="closeModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                             class="bi bi-x-lg" viewBox="0 0 16 16">
                                            <path
                                                d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <div class="dialog_flex2">
                                <div class="dialog_time">{{ currentTime }}</div>

                                <button class="del btn btn-danger" @click="deleteImage" v-if="isCurrentUser">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" class="bi bi-trash3 svg"
                                         viewBox="0 0 16 16">
                                        <path
                                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </dialog>
        </div>

        <div class="profile">
            <div class="profile-top-j">
                <div class="profile-top">
                    <img @click="showDialog(filenameData, '', '')" style="cursor:pointer;" class="profile-img"
                         :src="'../storage/images/' + filenameData" alt=""
                         v-if="!isCurrentUser">

                    <label class="input-file" v-else-if="isCurrentUser" style="cursor:pointer;">
                        <input type="file" name="file" class="file-input" @change="storeImage">
                        <img class="profile-img" :src="'../storage/images/' + filenameData" alt="">
                    </label>

                    <div class="flex-info">
                        <div class="flex">
                            <div class="profile-name">{{ user.name }} {{ user.surname }}
                                <div :class="{'round': true, 'round-green': isOnline}"></div>
                            </div>
                            <img :src="'/storage/user_icons/' + user.admin + '.svg'" alt="" class="svg"
                                 v-if="user.admin !== '0'">
                        </div>

                        <div v-if="compl">
                            <div class="last_net" v-if="!isOnline">В сети: {{ lastOnline }}</div>
                        </div>

                        <div class="profile-desc" v-if="!isCurrentUser">{{
                                user.status
                            }}
                        </div>
                        <form class="profile-desc" v-if="isCurrentUser">
                            <input @input="updateStatus" type="text" v-model="status"
                                   :class="{'input': true, 'input-status': true, 'input-status__success': status_success}"
                                   placeholder="Ваш статус" spellcheck="false">
                        </form>
                        <a class="profile-info">Email: {{ user.email }}</a>
                    </div>
                </div>

                <div class="profile-top__b" v-if="isCurrentUser">
                    <Link href="/user/" class="btn btn-primary">Редактировать</Link>
                    <button class="btn btn-primary" @click="logoutFun">Выйти</button>
                </div>

                <div class="profile-top__b" v-else-if="!isCurrentUser">
                    <button class="btn btn-primary" @click="createDialog">Написать сообщение</button>
                </div>
            </div>
        </div>


        <div class="content-flex">
            <div class="content-main">
                <div class="dir gallery" v-if="userImages.length !== 0">
                    <Link :href="'/images/' + user.id" class="title">Фотографии</Link>

                    <div class="gallery-img">
                        <div class="img">
                            <a @click="showDialog(userImages.at(-1).name, userImages.at(-1).time, userImages.at(-1).id)">
                                <img :src="'../storage/images/' + userImages.at(-1).name" v-if="userImages.at(-1)"
                                     alt="">
                            </a>
                            <a @click="showDialog(userImages.at(-2).name, userImages.at(-2).time, userImages.at(-2).id)"
                               v-if="userImages.at(-2)">
                                <img :src="'../storage/images/' + userImages.at(-2).name" alt="">
                            </a>
                            <a @click="showDialog(userImages.at(-3).name, userImages.at(-3).time, userImages.at(-3).id)"
                               v-if="userImages.at(-3)">
                                <img :src="'../storage/images/' + userImages.at(-3).name" alt="">
                            </a>
                            <a @click="showDialog(userImages.at(-4).name, userImages.at(-4).time, userImages.at(-4).id)"
                               v-if="userImages.at(-4)">
                                <img :src="'../storage/images/' + userImages.at(-4).name" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <form class="input-news dir" @submit.prevent="storePost"
                      v-if="isCurrentUser">
                    <input type="text" class="input" placeholder="Что у вас нового?" v-model="body" name="body"
                           autocomplete="off">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-send svg"
                             viewBox="0 0 16 16">
                            <path
                                d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                        </svg>
                    </button>
                </form>

                <div class="posts">
                    <div class="posts-item" v-for="(item, index) in postsData" :key="index">
                        <div class="del-flex">
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

                            <div class="del" @click="deletePost(item.id)"
                                 v-if="item.user_id === $page.props.auth.user.id">
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
                <div class="content-info__item2" v-if="friendsData.length !== 0">
                    <Link href="#" class="content-info__title">Знакомые</Link>
                    <div class="content-info__flex">
                        <Link :href="'/user/' + checkLogin(item.user_one_login, item.user_two_login, checkHome)"
                              class="content-info__item" v-for="item in friendsData">
                            <img class="content-info__item-img"
                                 :src="'../storage/images/' + checkImage(item.user_one_img, item.user_two_img, checkHome)"
                                 alt="">
                            <div class="content-info__item-title">
                                {{ checkName(item.user_one, item.user_two, checkHome).split(' ')[0] }}
                            </div>
                        </Link>
                    </div>
                </div>

                <div class="content-info__item2" v-if="communities.length !== 0">
                    <Link :href="'/my_communities/' + user.id" class="content-info__title">Подписки</Link>
                    <div class="content-info__flex2">
                        <Link :href="'/community/' + item.communities[0].id"
                              class="content-info__item3" v-for="item in communities">
                            <img class="content-info__item-img" :src="'../storage/images/' + item.communities[0].img_id"
                                 alt="">
                            <div class="content-info__item-title">
                                {{ item.communities[0].title }}
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </Layout>

    <div class="main_dialog">
        <dialog open class="dialog1" v-for="(item, index) in alerts" :key="index">
            <div class="dialog" v-if="this.$page.props.auth.user.id !== parseInt(item.message.user_id)">
                <div class="form">
                    <div class="dialog-title">{{
                            dialogsId.find(x => x.id === parseInt(item.message.dialog_id)).user
                        }}
                    </div>
                    <div class="dialog-message">{{ item.message.body }}</div>
                </div>
                <form method="dialog">
                    <button class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                             class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path
                                d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </dialog>
    </div>
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
            alerts: [],
            uvedVar: false,
            dialogsId: [],
            dialogsName: [],
            onlineTime: '',
            isOnline: false,
            lastOnline: '',
            userImages: [],
            imgDialog: this.$refs.imgDialogRef,
            isLoading: false,
            compl: document.readyState === 'complete',

            //  Dialog
            currentImage: 'i.png',
            currentTime: '2',
            currentId: '',
        }
    },

    props: ['user', 'posts', 'friends', 'communities', 'dialogs', 'images', 'user_id'],

    methods: {
        logoutFun() {
            axios.post('/logout');
            window.location.href = '/login/'
        },

        showDialog(name_img, time_img, id_img) {
            this.$refs.imgDialogRef.show()
            this.currentImage = name_img
            this.currentTime = time_img.split(':')[0].split('T')[0]
            this.currentId = id_img

            document.querySelector('body').style.overflowY = 'hidden';
            this.$refs.dialog_wrapper.style.opacity = '1'
            this.$refs.dialog_wrapper.style.zIndex = '9999998'
        },

        closeModal() {
            document.querySelector('body').style.overflowY = 'auto'
            this.$refs.dialog_wrapper.style.opacity = '0'
            this.$refs.dialog_wrapper.style.zIndex = '0'
        },

        getDialogsId() {
            for (let i = 0; i < this.dialogs.length; i++) {
                if (this.dialogs[i].user_two !== this.$page.props.auth.user.name + ' ' + this.$page.props.auth.user.surname) {
                    this.dialogsId.push(
                        {
                            'id': this.dialogs[i].id,
                            'user': this.dialogs[i].user_two
                        }
                    );
                } else {
                    this.dialogsId.push(
                        {
                            'id': this.dialogs[i].id,
                            'user': this.dialogs[i].user_one
                        }
                    );
                }
            }
        },

        updateUserTime() {
            axios.get('/update_online/')
        },

        getUserTime() {
            axios.get('/get_online/' + this.user.id)
                .then((response) => {
                    this.isOnline = parseInt(response.data.result.split(':')[0]) === 0 && parseInt(response.data.result.split(':')[1]) === 0 && parseInt(response.data.result.split(':')[2]) < 20;
                    if (this.isOnline === false) {
                        this.lastOnline = response.data.time
                    } else {
                        this.lastOnline = ''
                    }
                })
        },

        getUserImages() {
            for (let i = 0; i < this.images.length; i++) {
                if (this.images[i].name.split('.').at(-1) === 'jpg' || this.images[i].name.split('.').at(-1) === 'jpeg' || this.images[i].name.split('.').at(-1) === 'png') {
                    this.userImages.push(this.images[i])
                }
            }
        },

        storePost() {
            axios.post(`/post/${this.$page.props.auth.user.id}`, {
                body: this.body
            }).then(() => {
                this.body = ''
            })
        },

        deletePost(post_id) {
            axios.get('/delete_post/' + post_id)
                .then(() => {
                    this.postsData.splice(this.postsData.findIndex(x => x.id === post_id), 1)
                })
        },

        storeLike(post_id) {
            axios.get('/post_like/' + post_id)
                .then((response) => {
                    this.postsData.find(x => x.id === parseInt(post_id)).likes = response.data.likes
                    this.postsData.find(x => x.id === parseInt(post_id)).your_like = response.data.my_like
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

        createDialog() {
            axios.post('/create_dialog/', {
                id: this.user.id
            }).then(response => {
                window.location.href = `/chat/${response.data}`
            })
        },

        deleteImage() {
            axios.get(`/del_images/${this.currentId}`)
                .then(() => {
                    let del_element = this.userImages.findIndex(x => x.id === this.currentId)
                    this.userImages.splice(del_element, 1)

                    document.querySelector('body').style.overflowY = 'auto'
                    this.$refs.dialog_wrapper.style.opacity = '0'
                    this.$refs.dialog_wrapper.style.zIndex = '0'

                    this.$refs.imgDialogRef.close()
                })
        },

        storeImage(event) {
            this.filename = event.target.files[0].name;
            this.file = event.target.files[0];

            let formData = new FormData();
            formData.append('file', this.file);

            axios.post(`/user/update_image/`, formData)
                .then((response) => {
                    this.filenameData = response.data.name;
                    this.userImages.push(response.data)
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
        },

        uved() {
            if (this.$page.url.split('/')[1] !== 'chat') {
                let audio = new Audio('../storage/uved.mp3');
                audio.autoplay = true;
                audio.muted = false
                audio.volume = 0.5
                audio.play();
            }
        },
    },

    computed: {
        isCurrentUser() {
            return this.$page.props.auth.user.id === this.user.id;
        }
    },

    mounted() {
        this.getUserTime();
        this.updateUserTime();
        this.getUserImages();
        this.getDialogsId();

        this.$refs.imgDialogRef.close();

        window.Echo.channel('store_post')
            .listen('.store_post', response => {
                this.postsData.unshift(response.post)
            })


        for (let i = 0; i < this.dialogsId.length; i++) {
            window.Echo.channel('store_message_' + this.dialogsId[i].id)
                .listen('.store_message', response => {
                    this.alerts.unshift(response)

                    setTimeout(() => {
                        this.alerts.length = 0;
                    }, 30000)

                    if (parseInt(response.message.user_id) !== parseInt(this.$page.props.auth.user.id)) {
                        this.uved();
                    }
                })
        }

        setInterval(this.updateUserTime, 10000)
        setInterval(this.getUserTime, 10000)
    }
}
</script>

<style scoped lang="sass">
.input-status
    padding: 3rem 0
    border-radius: 0
    border: none
    border-bottom: 1px solid #dce1e6
    width: 400rem
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

.file-input
    display: none

.input-file
    transition: 0.3s

    &:hover
        filter: brightness(60%)

.dir
    background: white
    padding: 15rem
    border-radius: 10rem
    border: 1rem solid #dce1e6

    input
        background: #f4f5f6
        border-radius: 100rem

.last_net
    font-size: 12rem
    margin-top: -2rem
    margin-bottom: 5rem
    color: gray

    @media (max-width: 768px)
        font-size: 10rem
</style>
