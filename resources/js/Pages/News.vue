<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Link, Head} from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <title>Новости</title>
    </Head>
    <Layout>
        <div class="content-flex">
            <div class="content-main">
                <!--                <form class="input-news" @submit.prevent="storePost">-->
                <!--                    <input type="text" class="input" placeholder="Что у вас нового?" v-model="body" name="body">-->
                <!--                    <button type="submit" class="btn btn-primary">Опубликовать</button>-->
                <!--                </form>-->

                <div class="title">Новости</div>

                <div class="posts">
                    <div v-for="(item, index) in postsData" :key="index" class="posts">
                        <div v-for="i in item.posts">
                            <div class="posts-item">
                                <div class="posts-item__flex">
                                    <Link :href="'/community/' + item.community[0].id">
                                        <img class="posts-item__img"
                                             :src="'../storage/images/' + item.community[0].img_id"
                                             alt="">
                                    </Link>
                                    <div>
                                        <Link :href="'/community/' + item.community[0].id" class="flex">
                                            <div class="posts-item__title">{{ item.community[0].title }}</div>
                                            <div v-if="item.community[0].isVerified === '1'">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="#0d6efd"
                                                     class="bi bi-patch-check"
                                                     viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                          d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                    <path
                                                        d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z"/>
                                                </svg>
                                            </div>
                                        </Link>
                                        <div class="posts-item__time">{{ getTime(i.created_at) }}</div>
                                    </div>
                                </div>
                                <div class="posts-item__content">{{ i.body }}</div>

                                <!--                                <div :class="{'like': true, 'like_is': i.your_like === 1}"-->
                                <!--                                     @click="storeLike(i.id)">-->
                                <!--                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"-->
                                <!--                                         class="bi bi-heart" viewBox="0 0 16 16">-->
                                <!--                                        <path-->
                                <!--                                            d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>-->
                                <!--                                    </svg>-->
                                <!--                                    {{ i.likes }}-->
                                <!--                                </div>-->
                            </div>
                        </div>
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
import {Link} from '@inertiajs/vue3';

export default {
    props: ['posts', 'result', 'dialogs'],

    data() {
        return {
            body: '',
            postsData: this.result,
            alerts: [],
            uvedVar: false,
            dialogsId: [],
            dialogsName: [],
        }
    },

    methods: {
        storePost() {
            axios.post(`/post/${this.$page.props.auth.user.id}`, {
                body: this.body
            }).then((response) => {
                this.body = ''
                this.postsData.unshift(response.data)
            })
        },

        getTime(time) {
            return time.split(':')[0] + ':' + time.split(':')[1]
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
    },

    mounted() {
        this.getDialogsId();

        for (let i = 0; i < this.dialogsId.length; i++) {
            window.Echo.channel('store_message_' + this.dialogsId[i].id)
                .listen('.store_message', response => {
                    this.alerts.unshift(response)

                    setTimeout(() => {
                        this.alerts.length = 0;
                    }, 30000)
                })
        }
    }
}
</script>

<style scoped>
.posts {
    margin-top: 0 !important;
}

.title {
    font-size: 20rem;
    margin-bottom: 15rem;
}

.flex {
    display: flex;
    align-items: center;
    gap: 7rem;
}

.flex svg {
    width: 14rem;
    height: 14rem;
}

a {
    color: #333333;
}
</style>
